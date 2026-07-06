<?php

namespace local_scholarship\controllers;

use DateTimeImmutable;
use local_scholarship\models\Applicant;
use local_scholarship\models\Edition;
use local_scholarship\models\Status;
use local_scholarship\requests\StoreApplicantRequest;

defined('MOODLE_INTERNAL') || die();

class ApplicantController
{
    public function store()
    {
        global $DB;

        require_sesskey();

        $data = StoreApplicantRequest::validate();

        $edition = Edition::get_current_edition();

        if (!$edition) {
            throw new \moodle_exception('nocurrentedition', 'local_scholarship');
        }

        $data->editionid = $edition->id;

        $existing = Applicant::find_by_examcode($data->examcode, $edition->id);

        if ($existing) {
            return [
                'success' => true,
                'message' => get_string('apply_confirmation_message', 'local_scholarship'),
                'regcode' => $existing->regcode,
                'existing' => true,
            ];
        }

        $transaction = $DB->start_delegated_transaction();

        try {
            $data->regcode = $this->generate_unique_regcode();
            $status = Status::get_status_by_name('PENDING');
            $birthdate = new DateTimeImmutable($data->birthdate);
            $data->birthdate = $birthdate->getTimestamp();
            $data->statusid = $status ? $status->id : 1;
            $data->submittedat = time();

            if (($data->schoolfield ?? null) === 'other') {
                $otherStudy = trim((string) $data->other_study_option);
                if ($otherStudy !== '') {
                    $data->schoolfield = $otherStudy;
                }
            }

            if (($data->intendedfield ?? null) === 'other') {
                $otherUni = trim((string) $data->other_university_field);
                if ($otherUni !== '') {
                    $data->intendedfield = $otherUni;
                }
            }

            // Vérification future du code EXETAT dans un fichier Excel.
            // À activer quand le fichier sera disponible.
            //
            // require_once($CFG->libdir . '/phpspreadsheet/vendor/autoload.php');
            //
            // $filepath = $CFG->dataroot . '/local_scholarship/codes/codes_exetat.xlsx';
            // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filepath);
            // $worksheet = $spreadsheet->getActiveSheet();
            //
            // $found = false;
            // foreach ($worksheet->getRowIterator() as $row) {
            //     $cell = $worksheet->getCell('A' . $row->getRowIndex());
            //     if ($data->examcode === trim((string)$cell->getValue())) {
            //         $found = true;
            //         break;
            //     }
            // }
            //
            // if (!$found) {
            //     throw new \moodle_exception('examcodenotfound', 'local_scholarship');
            // }

            $applicantid = Applicant::create($data);

            $applicantfullname = Applicant::slug($data->fullname);

            $documenttypes = $DB->get_records('local_scholarship_doctype', ['reqcandidate' => 1]);

            foreach ($documenttypes as $doctype) {
                $inputname = strtolower($doctype->name);

                $this->store_application_documents(
                    $applicantid,
                    $applicantfullname,
                    $doctype->id,
                    $doctype->name,
                    $inputname
                );
            }

            $transaction->allow_commit();

            return [
                'success' => true,
                'regcode' => $data->regcode,
                'applicantid' => $applicantid,
                'existing' => false,
                'fullname' => $data->fullname,
            ];

        } catch (\Throwable $e) {
            $transaction->rollback($e);
        }
    }

    public static function followup()
    {
        global $DB;


        $regcode = $_REQUEST['coupon'];

        $applicant = $DB->get_record_sql("
                SELECT a.id, a.fullname, a.examcode, a.regcode, s.name AS statusname
                FROM {local_scholarship_app} a
                LEFT JOIN {local_scholarship_status} s ON s.id = a.statusid
                WHERE a.regcode = ?
            ", [$regcode]);

        if (!$applicant) {
            return (object) [
                'error' => 'Le coupon saisi ne correspond à aucun candidat. Veuillez vérifier le code et réessayer.',
                'regcode' => $regcode
            ];
        }

        $applicant->documents = Applicant::get_documents($applicant->id);

        return $applicant;
    }

    private function store_application_documents(int $applicantid, string $applicantfullname, int $doctypeid, string $doctypename, string $inputname)
    {
        global $DB;

        if (empty($_FILES[$inputname]) || $_FILES[$inputname]['error'] === UPLOAD_ERR_NO_FILE) {
            return;
        }

        if ($_FILES[$inputname]['error'] !== UPLOAD_ERR_OK) {
            throw new \moodle_exception('fileuploaderror', 'local_scholarship');
        }

        $context = \context_system::instance();
        $fs = get_file_storage();

        $originalname = $_FILES[$inputname]['name'];
        $extension = pathinfo($originalname, PATHINFO_EXTENSION);

        $filename = $this->generate_document_filename(
            $applicantfullname,
            $doctypename,
            $extension
        );

        $filerecord = [
            'contextid' => $context->id,
            'component' => 'local_scholarship',
            'filearea' => 'applicationdocs',
            'itemid' => $applicantid,
            'filename' => $filename,
            'filepath' => '/',
        ];

        $existing = $fs->get_file(
            $filerecord['contextid'],
            $filerecord['component'],
            $filerecord['filearea'],
            $filerecord['itemid'],
            $filerecord['filepath'],
            $filerecord['filename']
        );

        if ($existing) {
            $existing->delete();
        }

        $fs->create_file_from_pathname(
            $filerecord,
            $_FILES[$inputname]['tmp_name']
        );

        $DB->insert_record('local_scholarship_document', (object) [
            'applicantid' => $applicantid,
            'doctypeid' => $doctypeid,
            'filearea' => 'applicationdocs',
            'itemid' => $applicantid,
            'filename' => $filename,
            'verifstatus' => 'PENDING',
            'reviewedby' => null,
            'reviewedat' => null,
            'timecreated' => time(),
            'timemodified' => time(),
        ]);
    }

    private function generate_document_filename(string $applicantfullname, string $doctypename, string $extension): string
    {
        $date = date('Ymd_His');
        ;
        $safeext = strtolower(clean_param($extension, PARAM_ALPHANUMEXT));
        $safetype = strtolower(clean_param($doctypename, PARAM_ALPHANUMEXT));
        $base = "{$applicantfullname}_{$safetype}_{$date}";

        return "$base.$safeext";
    }

    private function generate_unique_regcode(): string
    {
        do {
            $code = strtoupper(substr(bin2hex(random_bytes(4)), 0, 5));
        } while (applicant::exists_by_regcode($code));

        return $code;
    }

    public static function authenticate_applicant(): void
    {
        global $DB, $SESSION;

        require_sesskey();

        $examcode = required_param('national_exam_code', PARAM_TEXT);
        $coupon = required_param('coupon', PARAM_TEXT);

        $examcode = trim($examcode);
        $coupon = trim($coupon);

        $authurl = new \moodle_url('/local/scholarship/applicants/tests/test-auth.php');

        if (!preg_match('/^\d{14}$/', $examcode)) {
            redirect(
                $authurl,
                'Le code élève doit contenir exactement 14 chiffres.',
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        if ($coupon === '' || \core_text::strlen($coupon) > 6) {
            redirect(
                $authurl,
                'Le coupon est obligatoire et ne doit pas dépasser 10 caractères.',
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $currentedition = Edition::get_current_edition();
        if (!$currentedition) {
            redirect(
                $authurl,
                'Aucune édition courante n\'est configurée.',
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $shortlistedstatus = Status::get_status_by_name('SHORTLISTED');
        if (!$shortlistedstatus) {
            redirect(
                $authurl,
                'Le statut SHORTLISTED est introuvable.',
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $applicant = $DB->get_record('local_scholarship_app', [
            'examcode' => $examcode,
            'regcode' => $coupon,
            'editionid' => $currentedition->id,
            'statusid' => $shortlistedstatus->id,
        ]);

        if (!$applicant) {
            redirect(
                $authurl,
                'Désolé, les informations fournies ne correspondent à aucun candidat éligible.',
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $SESSION->scholarship_authenticated_applicant_id = (int) $applicant->id;
        $SESSION->scholarship_authenticated_examcode = $examcode;
        $SESSION->scholarship_authenticated_at = time();

        $SESSION->scholarship_used_coupon = [
            'coupon' => $coupon,
            'usedat' => time(),
            'expiresat' => time() + 3600,
        ];

        // Vérifier si le candidat a déjà terminé son test.
        $latestsession = $DB->get_record_sql("
            SELECT *
            FROM {local_scholarship_testsess}
            WHERE applicantid = ?
            ORDER BY id DESC
            LIMIT 1
        ", [$applicant->id]);

        if ($latestsession && !empty($latestsession->endtime)) {
            $SESSION->scholarship_completed_test_session_id = (int) $latestsession->id;

            redirect(new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php'));
        }

        redirect(
            new \moodle_url('/local/scholarship/applicants/tests/instructions-layout.php'),
            'Authentification réussie.',
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
    }

    public static function instructions(): \stdClass
    {
        global $SESSION;

        $authurl = new \moodle_url('/local/scholarship/applicants/tests/test-auth.php');
        $submittedurl = new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php');

        $applicant = self::get_authenticated_applicant();

        if (!$applicant) {
            redirect(
                $authurl,
                "Votre session d'examen a expiré. Veuillez vous reconnecter.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $phasetest = self::get_current_phase_test();

        if (!$phasetest) {
            redirect(
                $authurl,
                "Aucune phase d'évaluation n'est actuellement disponible.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        if (!empty($phasetest->status) && $phasetest->status !== 'IN_PROGRESS') {
            redirect(
                $authurl,
                "Cette phase n'est pas encore ouverte aux candidats.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $windowmessage = self::phase_window_error_message($phasetest);

        if ($windowmessage) {
            redirect(
                $authurl,
                $windowmessage,
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $latestsession = self::get_latest_applicant_test_session($applicant);

        if ($latestsession && !empty($latestsession->endtime) && empty($SESSION->scholarship_exam_started)) {
            self::forget_exam_session();

            $SESSION->scholarship_completed_test_session_id = (int) $latestsession->id;

            redirect($submittedurl);
        }

        $data = new \stdClass();
        $data->examstarted = !empty($SESSION->scholarship_exam_started);
        $data->applicant = $applicant;
        $data->phasetest = $phasetest;

        return $data;
    }

    public static function start_exam(): void
    {
        global $DB, $SESSION;

        require_sesskey();

        $authurl = new \moodle_url('/local/scholarship/applicants/tests/test-auth.php');
        $instructionsurl = new \moodle_url('/local/scholarship/applicants/tests/instructions-layout.php');
        $evaluationurl = new \moodle_url('/local/scholarship/applicants/tests/evaluation-layout.php');
        $submittedurl = new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php');

        $applicant = self::get_authenticated_applicant();

        if (!$applicant) {
            redirect(
                $authurl,
                "Votre session d'examen a expiré. Veuillez vous reconnecter.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $phasetest = self::get_current_phase_test();

        if (!$phasetest) {
            redirect(
                $authurl,
                "Aucune phase d'évaluation n'est actuellement disponible.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        if (!empty($phasetest->status) && $phasetest->status !== 'IN_PROGRESS') {
            redirect(
                $authurl,
                "Cette phase n'est pas encore ouverte aux candidats.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $windowmessage = self::phase_window_error_message($phasetest);

        if ($windowmessage) {
            redirect(
                $authurl,
                $windowmessage,
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $latestsession = self::get_latest_applicant_test_session($applicant);

        if ($latestsession && !empty($latestsession->endtime)) {
            self::forget_exam_session();

            $SESSION->scholarship_completed_test_session_id = (int) $latestsession->id;

            redirect($submittedurl);
        }

        $questionphasetests = self::load_phase_question_phase_tests($phasetest);

        if (empty($questionphasetests)) {
            redirect(
                $instructionsurl,
                "Cette épreuve ne contient encore aucune question.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $testsession = $DB->get_record_sql("
            SELECT *
            FROM {local_scholarship_testsess}
            WHERE applicantid = ?
            AND endtime IS NULL
            ORDER BY id DESC
            LIMIT 1
        ", [$applicant->id]);

        $durationseconds = max(1, (int) ($phasetest->duration ?? 0)) * 60;

        if ($testsession && !empty($testsession->starttime)) {
            $sessionexpired = ((int) $testsession->starttime + $durationseconds) <= time();

            if ($sessionexpired) {
                $testsession->endtime = time();
                $testsession->autosubmitted = 1;
                $testsession->timemodified = time();

                $DB->update_record('local_scholarship_testsess', $testsession);

                self::forget_exam_session();

                redirect(new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php'));
            }
        }

        if (!$testsession) {
            $record = new \stdClass();
            $record->applicantid = (int) $applicant->id;
            // TODO: Implementer une logique pour les lieux de test dans les cities
            $record->phaselocid = 1; // TODO: Remplacer par une valeur de lieu de test existant
            $record->starttime = time();
            $record->endtime = null;
            $record->totalscore = 0;
            $record->ispassed = 0;
            $record->cheatingattempts = 0;
            $record->autosubmitted = 0;
            $record->timecreated = time();
            $record->timemodified = time();

            $testsessionid = $DB->insert_record('local_scholarship_testsess', $record);
            $testsession = $DB->get_record('local_scholarship_testsess', ['id' => $testsessionid], '*', MUST_EXIST);
        } else if (empty($testsession->starttime)) {
            $testsession->starttime = time();
            $testsession->timemodified = time();

            $DB->update_record('local_scholarship_testsess', $testsession);
        }

        if (empty($SESSION->scholarship_exam_question_order)) {
            $questionids = array_map(function ($item) {
                return (int) $item->id;
            }, array_values($questionphasetests));

            shuffle($questionids);

            $SESSION->scholarship_exam_started = true;
            $SESSION->scholarship_exam_session_id = (int) $testsession->id;
            $SESSION->scholarship_exam_phase_test_id = (int) $phasetest->id;
            $SESSION->scholarship_exam_question_order = $questionids;
            $SESSION->scholarship_exam_current_index = 0;
            $SESSION->scholarship_exam_started_at = !empty($testsession->starttime) ? (int) $testsession->starttime : time();
            $SESSION->scholarship_exam_violation_count = 0;
        } else {
            $SESSION->scholarship_exam_started = true;
            $SESSION->scholarship_exam_session_id = (int) $testsession->id;
            $SESSION->scholarship_exam_phase_test_id = (int) $phasetest->id;
            $SESSION->scholarship_exam_started_at = !empty($testsession->starttime) ? (int) $testsession->starttime : time();
        }

        redirect($evaluationurl);
    }

    public static function evaluation(): \stdClass
    {
        global $SESSION;

        $authurl = new \moodle_url('/local/scholarship/applicants/tests/test-auth.php');
        $instructionsurl = new \moodle_url('/local/scholarship/applicants/tests/instructions-layout.php');
        $submittedurl = new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php');

        $applicant = self::get_authenticated_applicant();

        if (!$applicant) {
            redirect(
                $authurl,
                "Votre session d'examen a expiré. Veuillez vous reconnecter.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $phasetest = self::get_current_phase_test();

        if (!$phasetest) {
            redirect(
                $authurl,
                "Aucune phase d'évaluation n'est actuellement disponible.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        if (empty($SESSION->scholarship_exam_started)) {
            redirect(
                $instructionsurl,
                "Veuillez d'abord démarrer l'évaluation.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $testsession = self::get_active_exam_session($applicant);

        if (!$testsession) {
            self::forget_exam_session();

            redirect(
                $instructionsurl,
                "Impossible de reprendre l'épreuve. Veuillez relancer l'examen.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        if (!empty($testsession->endtime)) {
            $SESSION->scholarship_completed_test_session_id = (int) $testsession->id;
            self::forget_exam_session();

            redirect($submittedurl);
        }

        $state = self::build_exam_view_state($applicant, $phasetest, $testsession);

        if (!$state) {
            self::forget_exam_session();

            redirect(
                $instructionsurl,
                "Impossible de charger les questions de l'épreuve.",
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        $data = new \stdClass();
        $data->applicant = $applicant;
        $data->phasetest = $phasetest;
        $data->testsession = $testsession;
        $data->examquestions = $state['examQuestions'];
        $data->currentquestionindex = $state['currentQuestionIndex'];
        $data->violationcount = $state['violationCount'];
        $data->maxviolations = 3;
        $data->exammeta = $state['examMeta'];

        return $data;
    }

    protected static function get_authenticated_applicant(): ?\stdClass
    {
        global $DB, $SESSION;

        if (empty($SESSION->scholarship_authenticated_applicant_id)) {
            return null;
        }

        return $DB->get_record('local_scholarship_app', [
            'id' => (int) $SESSION->scholarship_authenticated_applicant_id,
        ]) ?: null;
    }

    protected static function get_current_phase_test(): ?\stdClass
    {
        global $DB;

        $currentedition = Edition::get_current_edition();

        if (!$currentedition) {
            return null;
        }

        return $DB->get_record('local_scholarship_phasetest', [
            'editionid' => (int) $currentedition->id,
        ]) ?: null;
    }

    protected static function get_latest_applicant_test_session(?\stdClass $applicant): ?\stdClass
    {
        global $DB;

        if (!$applicant) {
            return null;
        }

        return $DB->get_record_sql("
        SELECT *
        FROM {local_scholarship_testsess}
        WHERE applicantid = ?
        ORDER BY id DESC
            LIMIT 1
        ", [$applicant->id]) ?: null;
    }

    protected static function get_active_exam_session(?\stdClass $applicant): ?\stdClass
    {
        global $DB, $SESSION;

        if (!$applicant) {
            return null;
        }

        if (!empty($SESSION->scholarship_exam_session_id)) {
            $testsession = $DB->get_record('local_scholarship_testsess', [
                'id' => (int) $SESSION->scholarship_exam_session_id,
                'applicantid' => (int) $applicant->id,
            ]);

            if ($testsession) {
                return $testsession;
            }
        }

        return $DB->get_record_sql("
            SELECT *
            FROM {local_scholarship_testsess}
            WHERE applicantid = ?
            AND endtime IS NULL
            ORDER BY id DESC
            LIMIT 1
        ", [(int) $applicant->id,]) ?: null;
    }

    protected static function build_exam_view_state(
        \stdClass $applicant,
        \stdClass $phasetest,
        \stdClass $testsession
    ): ?array {
        global $DB, $SESSION;

        // 1. Charger les questions de la phase avec catégories + assertions.
        $phasequestions = self::load_phase_question_phase_tests($phasetest);

        if (empty($phasequestions)) {
            return null;
        }

        // 2. Sécuriser le tableau : clé = phaseques.id.
        $phasequestionsbyid = [];

        foreach ($phasequestions as $item) {
            $phasequestionsbyid[(int) $item->id] = $item;
        }

        $phasequestions = $phasequestionsbyid;

        // 3. Construire ou reprendre l'ordre aléatoire des questions.
        $questionorder = [];

        if (
            !empty($SESSION->scholarship_exam_question_order)
            && is_array($SESSION->scholarship_exam_question_order)
        ) {
            foreach ($SESSION->scholarship_exam_question_order as $id) {
                $id = (int) $id;

                if (isset($phasequestions[$id])) {
                    $questionorder[] = $id;
                }
            }
        }

        if (empty($questionorder)) {
            $questionorder = array_keys($phasequestions);
            shuffle($questionorder);

            $SESSION->scholarship_exam_question_order = $questionorder;
        }

        // 4. Charger les réponses déjà données par le candidat.
        // Une question peut avoir plusieurs lignes dans candanswer.
        $responserecords = $DB->get_records('local_scholarship_candanswer', [
            'testsessionid' => (int) $testsession->id,
        ]);

        $responsesbyphaseques = [];

        foreach ($responserecords as $response) {
            $phasequesid = (int) $response->phasequesid;

            if (!isset($responsesbyphaseques[$phasequesid])) {
                $responsesbyphaseques[$phasequesid] = [];
            }

            if (!empty($response->assertid)) {
                $responsesbyphaseques[$phasequesid][] = (int) $response->assertid;
            }
        }

        // 5. Construire les questions envoyées au JavaScript.
        $questions = [];

        foreach ($questionorder as $phasequesid) {
            $item = $phasequestions[$phasequesid];

            $selectedids = $responsesbyphaseques[$phasequesid] ?? [];
            $selectedids = array_values(array_unique(array_map('intval', $selectedids)));

            $selectedid = !empty($selectedids) ? $selectedids[0] : null;

            $question = $item->question ?? null;

            if (!$question) {
                continue;
            }

            $optionsource = [];

            if (!empty($question->options) && is_array($question->options)) {
                $optionsource = $question->options;
            } else if (!empty($question->answer_options) && is_array($question->answer_options)) {
                $optionsource = $question->answer_options;
            }

            $options = [];
            $correctcount = 0;

            foreach ($optionsource as $option) {
                $assertid = (int) ($option->id ?? $option->assertid ?? 0);

                if ($assertid <= 0) {
                    continue;
                }

                $iscorrect = !empty($option->iscorrect) || !empty($option->is_correct);

                if ($iscorrect) {
                    $correctcount++;
                }

                $optiontext = $option->optiontext
                    ?? $option->option_text
                    ?? '';

                $options[] = [
                    'id' => $assertid,
                    'optiontext' => $optiontext,
                    'option_text' => $optiontext,
                ];
            }

            $categoryname = 'Question';

            if (!empty($question->category) && !empty($question->category->name)) {
                $categoryname = $question->category->name;
            } else if (!empty($item->category_name)) {
                $categoryname = $item->category_name;
            }

            $questiontext = $question->questiontext
                ?? $question->question_text
                ?? '';

            $questions[] = [
                // id = local_scholarship_phaseques.id
                'id' => (int) $item->id,

                // question_id = local_scholarship_question.id
                'question_id' => (int) ($item->questionid ?? $question->id ?? 0),

                'category' => $categoryname,
                'question_text' => $questiontext,
                'questiontext' => $questiontext,
                'ponderation' => (float) $item->ponderation,

                // Si plus d'une assertion correcte existe, la question accepte plusieurs réponses.
                'allow_multiple' => $correctcount > 1,

                // Compatibilité JS.
                'selected_option_id' => $selectedid,
                'selected_option_ids' => $selectedids,

                // Assertions.
                'options' => $options,
            ];
        }

        if (empty($questions)) {
            return null;
        }

        // 6. Gérer le temps.
        if (empty($testsession->starttime)) {
            $testsession->starttime = time();
            $testsession->status = 'in_progress';
            $testsession->timemodified = time();

            $DB->update_record('local_scholarship_testsess', $testsession);
        }

        $startedat = !empty($SESSION->scholarship_exam_started_at)
            ? (int) $SESSION->scholarship_exam_started_at
            : (int) $testsession->starttime;

        $SESSION->scholarship_exam_started_at = $startedat;

        $durationminutes = max(1, (int) ($phasetest->durationmin ?? 0));

        $endsat = $startedat + ($durationminutes * 60);

        // Si la phase a une heure de fin globale, elle limite l'examen.
        if (!empty($phasetest->endtime) && (int) $phasetest->endtime < $endsat) {
            $endsat = (int) $phasetest->endtime;
        }

        // 7. Index courant.
        $currentindex = isset($SESSION->scholarship_exam_current_index)
            ? (int) $SESSION->scholarship_exam_current_index
            : 0;

        $maxindex = max(count($questions) - 1, 0);
        $currentindex = max(0, min($currentindex, $maxindex));

        $SESSION->scholarship_exam_current_index = $currentindex;

        // 8. Retour final pour la vue evaluation_content.php.
        return [
            'testSession' => $testsession,

            'examQuestions' => $questions,

            'currentQuestionIndex' => $currentindex,

            'violationCount' => isset($SESSION->scholarship_exam_violation_count)
                ? (int) $SESSION->scholarship_exam_violation_count
                : 0,

            'examMeta' => [
                'started_at' => date(DATE_ATOM, $startedat),
                'ends_at' => date(DATE_ATOM, $endsat),
                'duration_minutes' => $durationminutes,
                'max_violations' => 3,
            ],
        ];
    }

    protected static function load_phase_question_phase_tests(\stdClass $phasetest): array
    {
        global $DB;

        // 1. Récupérer les questions de la phase + leur catégorie.
        $items = $DB->get_records_sql("
        SELECT
            pq.id AS id,
            pq.phasetestid,
            pq.questionid,
            pq.ponderation,

            q.id AS qid,
            q.categoryid,
            q.questiontext,

            c.id AS category_id,
            c.name AS category_name

        FROM {local_scholarship_phaseques} pq
        JOIN {local_scholarship_question} q
             ON q.id = pq.questionid
        LEFT JOIN {local_scholarship_qcategory} c
             ON c.id = q.categoryid

        WHERE pq.phasetestid = ?

        ORDER BY pq.id ASC
    ", [
            (int) $phasetest->id,
        ]);

        if (!$items) {
            return [];
        }

        // 2. Récupérer les assertions liées à ces questions.
        list($insql, $params) = $DB->get_in_or_equal(
            array_map(function ($item) {
                return (int) $item->questionid;
            }, $items),
            SQL_PARAMS_QM
        );

        $assertions = $DB->get_records_sql("
        SELECT
            qa.id AS id,
            qa.questionid,
            qa.assertid,
            qa.iscorrect,

            a.optiontext

        FROM {local_scholarship_questionassert} qa
        JOIN {local_scholarship_assert} a
             ON a.id = qa.assertid

        WHERE qa.questionid {$insql}

        ORDER BY qa.questionid ASC, qa.id ASC
    ", $params);

        // 3. Grouper les assertions par question.
        $assertionsbyquestion = [];

        foreach ($assertions as $assertion) {
            $questionid = (int) $assertion->questionid;

            if (!isset($assertionsbyquestion[$questionid])) {
                $assertionsbyquestion[$questionid] = [];
            }

            $assertionsbyquestion[$questionid][] = (object) [
                'id' => (int) $assertion->assertid,
                'optiontext' => $assertion->optiontext,
                'iscorrect' => (int) $assertion->iscorrect,
            ];
        }

        // 4. Construire une structure facile à utiliser dans l'examen.
        $result = [];

        foreach ($items as $item) {
            $questionid = (int) $item->questionid;

            $item->question = (object) [
                'id' => $questionid,
                'categoryid' => (int) $item->categoryid,
                'questiontext' => $item->questiontext,

                'category' => (object) [
                    'id' => !empty($item->category_id) ? (int) $item->category_id : 0,
                    'name' => $item->category_name ?? 'Sans catégorie',
                ],

                'options' => $assertionsbyquestion[$questionid] ?? [],
            ];

            $result[(int) $item->id] = $item;
        }

        return $result;
    }

    protected static function phase_window_error_message(\stdClass $phasetest): ?string
    {
        $now = time();

        if (!empty($phasetest->starttime) && $now < (int) $phasetest->starttime) {
            return "Cette phase n'a pas encore commencé.";
        }

        if (!empty($phasetest->endtime) && $now > (int) $phasetest->endtime) {
            return "Cette phase est déjà terminée.";
        }

        return null;
    }

    protected static function exam_session_keys(): array
    {
        return [
            'scholarship_exam_started',
            'scholarship_exam_session_id',
            'scholarship_exam_phase_test_id',
            'scholarship_exam_question_order',
            'scholarship_exam_current_index',
            'scholarship_exam_started_at',
            'scholarship_exam_violation_count',
        ];
    }

    protected static function forget_exam_session(): void
    {
        global $SESSION;

        foreach (self::exam_session_keys() as $key) {
            unset($SESSION->$key);
        }
    }

    protected static function get_candidate_responses(\stdClass $testsession): array
    {
        global $DB;

        if (!$DB->get_manager()->table_exists('local_scholarship_candanswer')) {
            return [];
        }

        $records = $DB->get_records('local_scholarship_candanswer', [
            'testsessionid' => (int) $testsession->id,
        ]);

        $items = [];

        foreach ($records as $record) {
            $phasequesid = (int) $record->phasequesid;

            if (!isset($items[$phasequesid])) {
                $items[$phasequesid] = [];
            }

            if (!empty($response->assertid)) {
                $items[$phasequesid][] = (int) $record->assertid;
            }
        }

        return $items;
    }

    protected static function persist_exam_response(
        \stdClass $testsession,
        \stdClass $phaseques,
        array $selectedassertids,
        ?int $currentindex = null
    ): void {
        global $DB, $SESSION;

        $selectedassertids = array_values(array_unique(array_filter(array_map('intval', $selectedassertids))));

        $DB->delete_records('local_scholarship_candanswer', [
            'testsessionid' => (int) $testsession->id,
            'phasequesid' => (int) $phaseques->id,
        ]);

        foreach ($selectedassertids as $assertid) {
            $record = new \stdClass();
            $record->testsessionid = (int) $testsession->id;
            $record->phasequesid = (int) $phaseques->id;
            $record->assertid = (int) $assertid;
            $record->timecreated = time();

            $DB->insert_record('local_scholarship_candanswer', $record);
        }

        if ($currentindex !== null) {
            $SESSION->scholarship_exam_current_index = max(0, (int) $currentindex);
        }
    }

    protected static function json_response(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        die;
    }

    protected static function is_phase_closed(\stdClass $phasetest): bool
    {
        return !empty($phasetest->endtime) && time() > (int) $phasetest->endtime;
    }

    public static function register_exam_violation(): void
    {
        global $SESSION;

        require_sesskey();

        $applicant = self::get_authenticated_applicant();
        $phasetest = self::get_current_phase_test();
        $testsession = self::get_active_exam_session($applicant);

        if (!$applicant || !$phasetest || !$testsession) {
            self::json_response([
                'message' => 'Session invalide.',
            ], 419);
        }

        if (
            (!empty($phasetest->status) && $phasetest->status !== 'IN_PROGRESS')
            || self::is_phase_closed($phasetest)
        ) {
            if (empty($testsession->endtime)) {
                self::finalize_exam(
                    $testsession,
                    $phasetest,
                    true,
                    (int) ($SESSION->scholarship_exam_violation_count ?? 0)
                );

                self::forget_exam_session();

                $SESSION->scholarship_completed_test_session_id = (int) $testsession->id;
            }

            self::json_response([
                'count' => (int) ($SESSION->scholarship_exam_violation_count ?? 0),
                'remaining' => 0,
                'auto_submitted' => true,
                'redirect_url' => (new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php'))->out(false),
            ]);
        }

        if (!empty($testsession->endtime)) {
            self::json_response([
                'count' => (int) ($SESSION->scholarship_exam_violation_count ?? 0),
                'remaining' => 0,
                'auto_submitted' => true,
                'redirect_url' => (new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php'))->out(false),
            ]);
        }

        $currentindex = optional_param('current_index', 0, PARAM_INT);

        $SESSION->scholarship_exam_current_index = max(0, $currentindex);

        $maxviolations = 3;
        $count = ((int) ($SESSION->scholarship_exam_violation_count ?? 0)) + 1;

        $SESSION->scholarship_exam_violation_count = $count;

        if ($count >= $maxviolations) {
            self::finalize_exam($testsession, $phasetest, true, $count);

            self::forget_exam_session();

            $SESSION->scholarship_completed_test_session_id = (int) $testsession->id;

            self::json_response([
                'count' => $count,
                'remaining' => 0,
                'auto_submitted' => true,
                'redirect_url' => (new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php'))->out(false),
            ]);
        }

        self::json_response([
            'count' => $count,
            'remaining' => max(0, $maxviolations - $count),
            'auto_submitted' => false,
        ]);
    }

    protected static function finalize_exam(
        \stdClass $testsession,
        \stdClass $phasetest,
        bool $autosubmitted = false,
        ?int $cheatingattempts = null
    ): void {
        global $DB;

        $phasequestions = self::load_phase_question_phase_tests($phasetest);

        $responses = $DB->get_records('local_scholarship_candanswer', [
            'testsessionid' => (int) $testsession->id,
        ]);

        $responsesbyphaseques = [];

        foreach ($responses as $response) {
            $phasequesid = (int) $response->phasequesid;

            if (!isset($responsesbyphaseques[$phasequesid])) {
                $responsesbyphaseques[$phasequesid] = [];
            }

            if (!empty($response->assertid)) {
                $responsesbyphaseques[$phasequesid][] = (int) $response->assertid;
            }
        }

        $score = 0.0;

        foreach ($phasequestions as $phasequesid => $item) {
            $selectedids = $responsesbyphaseques[(int) $phasequesid] ?? [];
            $selectedids = array_values(array_unique(array_map('intval', $selectedids)));
            sort($selectedids);

            if (empty($selectedids)) {
                continue;
            }

            $correctids = [];

            foreach ($item->question->options as $option) {
                if (!empty($option->is_correct) || !empty($option->iscorrect)) {
                    $correctids[] = (int) $option->id; // assertid
                }
            }

            $correctids = array_values(array_unique(array_map('intval', $correctids)));
            sort($correctids);

            if ($selectedids === $correctids) {
                $score += (float) $item->ponderation;
            }
        }

        $totalpossiblescore = (float) $DB->get_field_sql("
            SELECT COALESCE(SUM(ponderation), 0)
            FROM {local_scholarship_phaseques}
            WHERE phasetestid = ?
        ", [(int) $phasetest->id,]);

        $percentagescore = $totalpossiblescore > 0
            ? ($score / $totalpossiblescore) * 100
            : 0;

        $passingscore = isset($phasetest->passingscore)
            ? (float) $phasetest->passingscore
            : 0.0;

        $testsession->endtime = !empty($testsession->endtime)
            ? (int) $testsession->endtime
            : time();

        $testsession->totalscore = $score;
        $testsession->ispassed = $percentagescore >= $passingscore ? 1 : 0;
        $testsession->cheatingattempts = $cheatingattempts !== null
            ? $cheatingattempts
            : (int) ($testsession->cheatingattempts ?? 0);

        $testsession->autosubmitted = $autosubmitted ? 1 : 0;
        $testsession->status = 'completed';
        $testsession->timemodified = time();

        $DB->update_record('local_scholarship_testsess', $testsession);
    }

    public static function save_exam_progress(): void
    {
        global $DB, $SESSION;

        require_sesskey();

        $applicant = self::get_authenticated_applicant();
        $phasetest = self::get_current_phase_test();
        $testsession = self::get_active_exam_session($applicant);

        if (!$applicant || !$phasetest || !$testsession) {
            self::json_response([
                'message' => 'Session invalide.',
            ], 419);
        }

        if (!empty($testsession->endtime)) {
            self::json_response([
                'message' => "L'épreuve est déjà terminée.",
            ], 422);
        }

        if (!empty($phasetest->status) && $phasetest->status !== 'IN_PROGRESS') {
            self::json_response([
                'message' => "Cette phase n'est plus ouverte.",
            ], 422);
        }

        if (self::is_phase_closed($phasetest)) {
            self::finalize_exam(
                $testsession,
                $phasetest,
                true,
                (int) ($SESSION->scholarship_exam_violation_count ?? 0)
            );

            self::forget_exam_session();

            $SESSION->scholarship_completed_test_session_id = (int) $testsession->id;

            self::json_response([
                'message' => "Le temps de la phase est terminé.",
                'redirect_url' => (new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php'))->out(false),
            ], 422);
        }

        $phasequesid = required_param('question_phase_test_id', PARAM_INT);
        $selectedjson = optional_param('selected_option_ids', '[]', PARAM_RAW);
        $currentindex = optional_param('current_index', 0, PARAM_INT);

        $selectedassertids = json_decode($selectedjson, true);

        if (!is_array($selectedassertids)) {
            $selectedassertids = [];
        }

        $selectedassertids = array_values(array_unique(array_filter(array_map('intval', $selectedassertids))));

        $phaseques = $DB->get_record('local_scholarship_phaseques', [
            'id' => $phasequesid,
            'phasetestid' => (int) $phasetest->id,
        ], '*', MUST_EXIST);

        // Vérifier que chaque assertion sélectionnée appartient réellement à la question.
        $validrecords = $DB->get_records('local_scholarship_questionassert', [
            'questionid' => (int) $phaseques->questionid,
        ]);

        $validassertids = [];

        foreach ($validrecords as $record) {
            $validassertids[] = (int) $record->assertid;
        }

        foreach ($selectedassertids as $assertid) {
            if (!in_array($assertid, $validassertids, true)) {
                self::json_response([
                    'message' => 'Assertion invalide pour cette question.',
                ], 422);
            }
        }

        self::persist_exam_response(
            $testsession,
            $phaseques,
            $selectedassertids,
            $currentindex
        );

        $answeredcount = (int) $DB->get_field_sql("
            SELECT COUNT(DISTINCT phasequesid)
            FROM {local_scholarship_candanswer}
            WHERE testsessionid = ?
            AND assertid IS NOT NULL
        ", [(int) $testsession->id,]);

        self::json_response([
            'saved' => true,
            'answered_count' => $answeredcount,
        ]);
    }

    public static function submitted(): \stdClass
    {
        global $SESSION;

        $authurl = new \moodle_url('/local/scholarship/applicants/tests/test-auth.php');
        $instructionsurl = new \moodle_url('/local/scholarship/applicants/tests/instructions-layout.php');

        $applicant = self::get_authenticated_applicant();

        if (!$applicant) {
            redirect(
                $authurl,
                'Votre session a expiré. Veuillez vous reconnecter.',
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_sesskey();

            $phasetest = self::get_current_phase_test();
            $testsession = self::get_active_exam_session($applicant);

            if (!$phasetest || !$testsession) {
                redirect(
                    $instructionsurl,
                    "Impossible de retrouver la session d'examen.",
                    null,
                    \core\output\notification::NOTIFY_ERROR
                );
            }

            if (empty($testsession->endtime)) {
                $autosubmitted = optional_param('auto_submitted', 0, PARAM_BOOL);

                self::finalize_exam(
                    $testsession,
                    $phasetest,
                    (bool) $autosubmitted,
                    (int) ($SESSION->scholarship_exam_violation_count ?? 0)
                );
            }

            self::forget_exam_session();

            $SESSION->scholarship_completed_test_session_id = (int) $testsession->id;

            redirect(new \moodle_url('/local/scholarship/applicants/tests/submitted-layout.php'));
        }

        $testsession = self::resolve_completed_test_session($applicant);

        if (!$testsession || empty($testsession->endtime)) {
            redirect($instructionsurl);
        }

        self::forget_exam_session();

        $data = new \stdClass();
        $data->applicant = $applicant;
        $data->summary = self::build_submission_summary($testsession);

        return $data;
    }

    protected static function resolve_completed_test_session(\stdClass $applicant): ?\stdClass
    {
        global $DB, $SESSION;

        if (!empty($SESSION->scholarship_completed_test_session_id)) {
            $testsession = $DB->get_record('local_scholarship_testsess', [
                'id' => (int) $SESSION->scholarship_completed_test_session_id,
                'applicantid' => (int) $applicant->id,
            ]);

            if ($testsession && !empty($testsession->endtime)) {
                return $testsession;
            }
        }

        return $DB->get_record_sql("
            SELECT *
            FROM {local_scholarship_testsess}
            WHERE applicantid = ?
            AND endtime IS NOT NULL
            ORDER BY endtime DESC, id DESC
            LIMIT 1
        ", [(int) $applicant->id,]) ?: null;
    }

    protected static function build_submission_summary(\stdClass $testsession): array
    {
        global $DB;

        $phasetest = self::get_current_phase_test();

        $answeredcount = (int) $DB->get_field_sql("
            SELECT COUNT(DISTINCT phasequesid)
            FROM {local_scholarship_candanswer}
            WHERE testsessionid = ?
            AND assertid IS NOT NULL
        ", [(int) $testsession->id,]);

        $totalquestions = 0;

        if ($phasetest) {
            $totalquestions = (int) $DB->count_records('local_scholarship_phaseques', [
                'phasetestid' => (int) $phasetest->id,
            ]);
        }

        $startedat = !empty($testsession->starttime) ? (int) $testsession->starttime : 0;
        $finishedat = !empty($testsession->endtime) ? (int) $testsession->endtime : 0;

        $secondsused = 0;

        if ($startedat && $finishedat) {
            $secondsused = max(0, $finishedat - $startedat);
        }

        $hours = intdiv($secondsused, 3600);
        $minutes = intdiv($secondsused % 3600, 60);
        $seconds = $secondsused % 60;

        return [
            'answered_count' => $answeredcount,
            'total_questions' => $totalquestions,
            'cheating_attempts' => (int) ($testsession->cheatingattempts ?? 0),
            'auto_submitted' => !empty($testsession->autosubmitted),
            'time_used_label' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds),
            'submitted_at' => $finishedat ? date('d/m/Y H:i', $finishedat) : '-',
        ];
    }
}