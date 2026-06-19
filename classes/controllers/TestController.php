<?php

namespace local_scholarship\controllers;

use local_scholarship\models\Edition;
use local_scholarship\models\PhaseTest;
use local_scholarship\models\Status;

defined('MOODLE_INTERNAL') || die();

class TestController
{
    public static function index(): \stdClass
    {
        global $DB;

        $data = new \stdClass();

        $data->currentEdition = Edition::get_current_edition();

        if (!$data->currentEdition) {
            throw new \moodle_exception('nocurrentedition', 'local_scholarship');
        }

        $data->phaseTest = PhaseTest::get_current_phase();

        $data->lockstatus = self::get_phase_test_lock_status($data->phaseTest->id);

        if (!$data->phaseTest) {
            $record = (object) [
                'editionid' => $data->currentEdition->id,
                'status' => 'AWAITING',
                'durationmin' => 60,
                'passingscore' => 50,
                'timecreated' => time(),
                'timemodified' => time(),
            ];

            $record->id = $DB->insert_record('local_scholarship_phasetest', $record);
            $data->phaseTest = $record;
        }

        $data->categories = array_values($DB->get_records(
            'local_scholarship_qcategory',
            null,
            'name ASC',
            'id, name'
        ));

        $data->questions = self::get_phase_questions($data->phaseTest->id);

        $data->testCandidates = self::get_test_candidates($data->currentEdition->id);

        $data->testDashboardStats = self::get_test_dashboard_stats(
            $data->currentEdition->id,
            $data->phaseTest->id
        );

        $data->testResults = self::get_test_results(
            $data->currentEdition->id,
            $data->phaseTest->id
        );

        $data->testResultsStats = self::get_test_results_stats(
            $data->currentEdition->id,
            $data->phaseTest->id
        );

        $data->testResultDetails = self::get_test_result_details(
            $data->phaseTest->id
        );

        $data->questionSuggestions = self::get_question_suggestions();
        $data->assertionSuggestions = self::get_assertion_suggestions();

        return $data;
    }

    public static function update_phase_status()
    {
        require_sesskey();

        $id = optional_param('id', null, PARAM_INT);
        $status = optional_param('status', null, PARAM_TEXT);

        // retrieve applicant
        $phase = PhaseTest::find($id);
        if (!$phase) {
            throw new \moodle_exception('phasenotfound', 'local_scholarship');
        }

        if (($status ?? null) === 'IN_PROGRESS' && count(self::get_phase_questions($phase->id)) < 1) {
            $message = 'Impossible de lancer la phase sans question.';
            throw new \moodle_exception($message);
        }

        PhaseTest::update($id, (object) [
            'status' => $status,
        ]);

        $message = get_string('statusupdated', 'local_scholarship');
        $url = new \moodle_url('/local/scholarship/admin/tests/');
        redirect(
            $url,
            $message,
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
    }

    private static function get_question_suggestions(): array
    {
        global $DB;

        $questions = $DB->get_records_sql("
        SELECT q.id,
               q.categoryid,
               q.questiontext
          FROM {local_scholarship_question} q
      ORDER BY q.timecreated DESC
    ", [], 0, 100);

        $items = [];

        foreach ($questions as $q) {
            $assertions = $DB->get_records_sql("
            SELECT a.id,
                   a.optiontext,
                   qa.iscorrect
              FROM {local_scholarship_questionassert} qa
              JOIN {local_scholarship_assert} a ON a.id = qa.assertid
             WHERE qa.questionid = ?
          ORDER BY qa.id ASC
        ", [$q->id]);

            $options = [];

            foreach ($assertions as $a) {
                $options[] = [
                    'id' => (int) $a->id,
                    'option_text' => $a->optiontext,
                    'is_correct' => (int) $a->iscorrect === 1,
                ];
            }

            $items[] = [
                'id' => (int) $q->id,
                'category_question_id' => (int) $q->categoryid,
                'question_text' => $q->questiontext,
                'options' => $options,
            ];
        }

        return $items;
    }

    private static function get_assertion_suggestions(): array
    {
        global $DB;

        $assertions = $DB->get_records(
            'local_scholarship_assert',
            null,
            'optiontext ASC',
            'id, optiontext',
            0,
            200
        );

        $items = [];

        foreach ($assertions as $a) {
            $items[] = [
                'id' => (int) $a->id,
                'option_text' => $a->optiontext,
            ];
        }

        return $items;
    }

    private static function get_phase_questions(int $phaseid): array
    {
        global $DB;

        $questions = $DB->get_records_sql("
        SELECT q.id,
               q.categoryid,
               q.questiontext,
               qp.ponderation
          FROM {local_scholarship_phaseques} qp
          JOIN {local_scholarship_question} q ON q.id = qp.questionid
         WHERE qp.phasetestid = ?
      ORDER BY qp.id ASC
    ", [$phaseid]);

        $items = [];

        foreach ($questions as $q) {
            $assertions = $DB->get_records_sql("
            SELECT a.id,
                   a.optiontext,
                   qa.iscorrect
              FROM {local_scholarship_questionassert} qa
              JOIN {local_scholarship_assert} a ON a.id = qa.assertid
             WHERE qa.questionid = ?
          ORDER BY qa.id ASC
        ", [$q->id]);

            $options = [];

            foreach ($assertions as $a) {
                $options[] = [
                    'uuid' => uniqid('o_', true),
                    'id' => (int) $a->id,
                    'option_text' => $a->optiontext,
                    'is_correct' => (int) $a->iscorrect === 1,
                    'position' => count($options),
                ];
            }

            $items[] = [
                'uuid' => uniqid('q_', true),
                'id' => (int) $q->id,
                'category_question_id' => (int) $q->categoryid,
                'question_text' => $q->questiontext,
                'ponderation' => (float) $q->ponderation,
                'allow_multiple' => count(array_filter($options, fn($o) => $o['is_correct'])) > 1,
                'suggestions_enabled' => true,
                'is_validated' => true,
                'position' => count($items),
                'options' => $options,
            ];
        }

        return $items;
    }

    public static function save_questions(): array
    {
        global $DB;

        $phaseid = required_param('phaseid', PARAM_INT);

        self::verify_phase_test_lock_status($phaseid);

        $questionsjson = required_param('questions', PARAM_RAW);

        $questions = json_decode($questionsjson, true);

        if (!is_array($questions)) {
            return [
                'success' => false,
                'message' => 'Données invalides.',
            ];
        }

        $transaction = $DB->start_delegated_transaction();

        try {
            $now = time();
            $sortorder = 1;
            $phasequestions = [];

            foreach ($questions as $q) {
                self::validate_question_payload($q);

                $questionid = !empty($q['id']) ? (int) $q['id'] : 0;

                $questionrecord = (object) [
                    'categoryid' => (int) $q['categoryid'],
                    'questiontext' => clean_text($q['questiontext'], FORMAT_HTML),
                    'timemodified' => $now,
                ];

                if ($questionid && $DB->record_exists('local_scholarship_question', ['id' => $questionid])) {
                    $questionrecord->id = $questionid;
                    $DB->update_record('local_scholarship_question', $questionrecord);
                } else {
                    $questionrecord->timecreated = $now;
                    $questionid = $DB->insert_record('local_scholarship_question', $questionrecord);
                }

                $DB->delete_records('local_scholarship_questionassert', [
                    'questionid' => $questionid,
                ]);

                foreach ($q['options'] as $option) {
                    if (empty(trim($option['optiontext'] ?? ''))) {
                        continue;
                    }

                    $assertid = !empty($option['id']) ? (int) $option['id'] : 0;

                    $assertrecord = (object) [
                        'optiontext' => clean_param($option['optiontext'], PARAM_TEXT),
                        'timemodified' => $now,
                    ];

                    if ($assertid && $DB->record_exists('local_scholarship_assert', ['id' => $assertid])) {
                        $assertrecord->id = $assertid;
                        $DB->update_record('local_scholarship_assert', $assertrecord);
                    } else {
                        $assertrecord->timecreated = $now;
                        $assertid = $DB->insert_record('local_scholarship_assert', $assertrecord);
                    }

                    $DB->insert_record('local_scholarship_questionassert', (object) [
                        'questionid' => $questionid,
                        'assertid' => $assertid,
                        'iscorrect' => !empty($option['iscorrect']) ? 1 : 0,
                        'timecreated' => $now,
                    ]);
                }

                $phasequestions[$questionid] = [
                    'ponderation' => (float) ($q['ponderation'] ?? 1),
                    'sortorder' => $sortorder,
                ];

                $sortorder++;
            }

            $DB->delete_records('local_scholarship_phaseques', [
                'phasetestid' => $phaseid,
            ]);

            foreach ($phasequestions as $questionid => $meta) {
                $DB->insert_record('local_scholarship_phaseques', (object) [
                    'phasetestid' => $phaseid,
                    'questionid' => $questionid,
                    'ponderation' => $meta['ponderation'],
                    'timecreated' => $now,
                ]);
            }

            $DB->update_record('local_scholarship_phasetest', (object) [
                'id' => $phaseid,
                'numberquestions' => count($phasequestions),
                'timemodified' => $now,
            ]);

            $transaction->allow_commit();

            return [
                'success' => true,
                'questions' => self::get_phase_questions($phaseid),
            ];

        } catch (\Throwable $e) {
            $transaction->rollback($e);
        }
    }

    private static function validate_question_payload(array $q): void
    {
        if (empty($q['categoryid'])) {
            throw new \moodle_exception('Catégorie obligatoire.');
        }

        if (empty(trim(strip_tags($q['questiontext'] ?? '')))) {
            throw new \moodle_exception('Texte de question obligatoire.');
        }

        if (empty($q['options']) || count($q['options']) < 2) {
            throw new \moodle_exception('Une question doit avoir au moins deux assertions.');
        }

        $correct = 0;

        $seenassertions = [];
        $seentexts = [];

        foreach ($q['options'] as $option) {
            $text = trim($option['optiontext'] ?? '');

            if ($text === '') {
                throw new \moodle_exception('Toutes les assertions doivent être remplies.');
            }

            $assertid = !empty($option['id']) ? (int) $option['id'] : 0;
            $normalizedtext = \core_text::strtolower(preg_replace('/\s+/', ' ', $text));

            if ($assertid > 0) {
                if (isset($seenassertions[$assertid])) {
                    throw new \moodle_exception('Une même assertion ne peut pas être utilisée deux fois dans une question.');
                }

                $seenassertions[$assertid] = true;
            } else {
                if (isset($seentexts[$normalizedtext])) {
                    throw new \moodle_exception('Une même assertion ne peut pas être saisie deux fois dans une question.');
                }

                $seentexts[$normalizedtext] = true;
            }

            if (!empty($option['iscorrect'])) {
                $correct++;
            }
        }

        if ($correct < 1) {
            throw new \moodle_exception('Sélectionne au moins une bonne réponse.');
        }

        if (empty($q['allowmultiple']) && $correct > 1) {
            throw new \moodle_exception('Cette question est en réponse unique mais contient plusieurs bonnes réponses.');
        }
    }

    private static function get_test_candidates(int $editionid): array
    {
        global $DB;

        return array_values($DB->get_records_sql("
        SELECT a.id,
               a.fullname,
               a.gender,
               a.phone,
               a.regcode,
               a.percentage,
               ts.id AS testsessionid,
               COALESCE(ts.status, 'NOT_STARTED') AS teststatus,
               ts.starttime,
               ts.endtime,
               ts.totalscore,
               ts.ispassed
          FROM {local_scholarship_app} a
          JOIN {local_scholarship_status} s ON s.id = a.statusid
     LEFT JOIN {local_scholarship_testsess} ts ON ts.applicantid = a.id
         WHERE a.editionid = ?
           AND s.name = ?
      ORDER BY a.fullname ASC
    ", [
            $editionid,
            'SHORTLISTED',
        ]));
    }
    private static function get_test_dashboard_stats(int $editionid, int $phaseid): \stdClass
    {
        global $DB;

        $stats = new \stdClass();

        $stats->shortlisted = $DB->count_records_sql("
        SELECT COUNT(1)
          FROM {local_scholarship_app} a
          JOIN {local_scholarship_status} s ON s.id = a.statusid
         WHERE a.editionid = ?
           AND s.name = ?
    ", [$editionid, 'SHORTLISTED']);

        $stats->started = $DB->count_records_sql("
        SELECT COUNT(1)
          FROM {local_scholarship_testsess} ts
          JOIN {local_scholarship_app} a ON a.id = ts.applicantid
          JOIN {local_scholarship_status} s ON s.id = a.statusid
          JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
         WHERE a.editionid = ?
           AND s.name = ?
           AND pl.phasetestid = ?
    ", [$editionid, 'SHORTLISTED', $phaseid]);

        $stats->completed = $DB->count_records_sql("
        SELECT COUNT(1)
          FROM {local_scholarship_testsess} ts
          JOIN {local_scholarship_app} a ON a.id = ts.applicantid
          JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
         WHERE a.editionid = ?
           AND pl.phasetestid = ?
           AND ts.status = ?
    ", [$editionid, $phaseid, 'completed']);

        $stats->passed = $DB->count_records_sql("
        SELECT COUNT(1)
          FROM {local_scholarship_testsess} ts
          JOIN {local_scholarship_app} a ON a.id = ts.applicantid
          JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
         WHERE a.editionid = ?
           AND pl.phasetestid = ?
           AND ts.ispassed = 1
    ", [$editionid, $phaseid]);

        $stats->failed = max(0, $stats->completed - $stats->passed);

        $stats->questions = $DB->count_records('local_scholarship_phaseques', [
            'phasetestid' => $phaseid,
        ]);

        $stats->ismixed = (int) $DB->get_field('local_scholarship_edition', 'ismixed', [
            'id' => $editionid
        ]);

        $stats->shortlistedmale = $DB->count_records_sql("
    SELECT COUNT(1)
      FROM {local_scholarship_app} a
      JOIN {local_scholarship_status} s ON s.id = a.statusid
     WHERE a.editionid = ?
       AND s.name = ?
       AND LOWER(a.gender) IN ('male')
", [$editionid, 'SHORTLISTED']);

        $stats->shortlistedfemale = $DB->count_records_sql("
    SELECT COUNT(1)
      FROM {local_scholarship_app} a
      JOIN {local_scholarship_status} s ON s.id = a.statusid
     WHERE a.editionid = ?
       AND s.name = ?
       AND LOWER(a.gender) IN ('female')
", [$editionid, 'SHORTLISTED']);

        $stats->passedmale = $DB->count_records_sql("
    SELECT COUNT(1)
      FROM {local_scholarship_testsess} ts
      JOIN {local_scholarship_app} a ON a.id = ts.applicantid
      JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
     WHERE a.editionid = ?
       AND pl.phasetestid = ?
       AND ts.ispassed = 1
       AND LOWER(a.gender) IN ('male')
", [$editionid, $phaseid]);

        $stats->passedfemale = $DB->count_records_sql("
    SELECT COUNT(1)
      FROM {local_scholarship_testsess} ts
      JOIN {local_scholarship_app} a ON a.id = ts.applicantid
      JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
     WHERE a.editionid = ?
       AND pl.phasetestid = ?
       AND ts.ispassed = 1
       AND LOWER(a.gender) IN ('female')
", [$editionid, $phaseid]);
        return $stats;
    }

    private static function get_phase_total_points(int $phaseid): float
    {
        global $DB;

        return (float) $DB->get_field_sql("
        SELECT COALESCE(SUM(ponderation), 0)
          FROM {local_scholarship_phaseques}
         WHERE phasetestid = ?
    ", [$phaseid]);
    }

    private static function get_test_results(int $editionid, int $phaseid): array
    {
        global $DB;

        $totalpoints = self::get_phase_total_points($phaseid);

        $records = $DB->get_records_sql("
        SELECT ts.id AS sessionid,
               a.id AS applicantid,
               a.fullname,
               a.gender,
               a.phone,
               a.regcode,
               ts.starttime,
               ts.endtime,
               ts.totalscore,
               ts.cheatingattempts,
               ts.autosubmitted,
               ts.status,
               ts.ispassed
          FROM {local_scholarship_testsess} ts
          JOIN {local_scholarship_app} a ON a.id = ts.applicantid
          JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
         WHERE a.editionid = ?
           AND pl.phasetestid = ?
           AND ts.status = ?
      ORDER BY ts.totalscore DESC, ts.endtime ASC
    ", [$editionid, $phaseid, 'completed']);

        $results = [];

        foreach ($records as $record) {
            $record->totalpoints = $totalpoints;
            $record->percentage = $totalpoints > 0
                ? round(((float) $record->totalscore / $totalpoints) * 100, 2)
                : 0;

            $record->duration = '-';

            if (!empty($record->starttime) && !empty($record->endtime)) {
                $seconds = (int) $record->endtime - (int) $record->starttime;
                $record->duration = floor($seconds / 60) . ' min';
            }

            $results[] = $record;
        }

        return $results;
    }

    private static function get_test_results_stats(int $editionid, int $phaseid): \stdClass
    {
        global $DB;

        $stats = new \stdClass();

        $basewhere = "
            FROM {local_scholarship_testsess} ts
            JOIN {local_scholarship_app} a ON a.id = ts.applicantid
            JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
            WHERE a.editionid = ?
            AND pl.phasetestid = ?
            AND ts.endtime IS NOT NULL
        ";

        $params = [$editionid, $phaseid];

        $stats->completed = (int) $DB->count_records_sql("
        SELECT COUNT(1)
        {$basewhere}
    ", $params);

        $stats->passed = (int) $DB->count_records_sql("
        SELECT COUNT(1)
        {$basewhere}
         AND ts.ispassed = 1
    ", $params);

        $stats->failed = max(0, $stats->completed - $stats->passed);

        $stats->average = (float) $DB->get_field_sql("
        SELECT COALESCE(AVG(ts.totalscore), 0)
        {$basewhere}
    ", $params);

        $stats->autosubmitted = (int) $DB->count_records_sql("
        SELECT COUNT(1)
        {$basewhere}
         AND ts.autosubmitted = 1
    ", $params);

        return $stats;
    }

    private static function get_test_result_details(int $phaseid): array
    {
        global $DB;

        $sessions = $DB->get_records_sql("
        SELECT ts.id
          FROM {local_scholarship_testsess} ts
          JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
         WHERE pl.phasetestid = ?
           AND ts.status = ?
    ", [$phaseid, 'completed']);

        $details = [];

        foreach ($sessions as $session) {
            $details[$session->id] = self::get_session_answers_detail((int) $session->id);
        }

        return $details;
    }

    private static function get_session_answers_detail(int $sessionid): array
    {
        global $DB;

        $questions = $DB->get_records_sql("
        SELECT pq.id AS phasequesid,
               pq.ponderation,
               q.id AS questionid,
               q.questiontext,
               qc.name AS category
          FROM {local_scholarship_phaseques} pq
          JOIN {local_scholarship_question} q ON q.id = pq.questionid
     LEFT JOIN {local_scholarship_qcategory} qc ON qc.id = q.categoryid
          JOIN {local_scholarship_testsess} ts ON ts.id = ?
          JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
         WHERE pq.phasetestid = pl.phasetestid
      ORDER BY pq.id ASC
    ", [$sessionid]);

        $items = [];

        foreach ($questions as $question) {
            $selected = $DB->get_fieldset_select(
                'local_scholarship_candanswer',
                'assertid',
                'testsessionid = ? AND phasequesid = ?',
                [$sessionid, $question->phasequesid]
            );

            $selected = array_map('intval', $selected);

            $options = $DB->get_records_sql("
            SELECT a.id,
                   a.optiontext,
                   qa.iscorrect
              FROM {local_scholarship_questionassert} qa
              JOIN {local_scholarship_assert} a ON a.id = qa.assertid
             WHERE qa.questionid = ?
          ORDER BY qa.id ASC
        ", [$question->questionid]);

            $optionpayload = [];
            $isquestioncorrect = true;
            $hasanswer = !empty($selected);

            foreach ($options as $option) {
                $isselected = in_array((int) $option->id, $selected, true);
                $iscorrect = (int) $option->iscorrect === 1;

                if ($isselected !== $iscorrect) {
                    $isquestioncorrect = false;
                }

                $optionpayload[] = [
                    'id' => (int) $option->id,
                    'option_text' => format_text($option->optiontext),
                    'is_correct' => $iscorrect,
                    'is_selected' => $isselected,
                ];
            }

            $items[] = [
                'phasequesid' => (int) $question->phasequesid,
                'question_text' => format_text($question->questiontext),
                'category' => $question->category,
                'ponderation' => (float) $question->ponderation,
                'selected_option_id' => $selected[0] ?? null,
                'is_correct' => $hasanswer && $isquestioncorrect,
                'options' => $optionpayload,
            ];
        }

        return $items;
    }

    public static function promote_test_passed_candidates(): array
    {
        global $DB, $USER;

        $phaseid = required_param('phaseid', PARAM_INT);

        $testpassedstatus = Status::get_status_by_name('TEST_PASSED');

        $passed = $DB->get_records_sql("
            SELECT DISTINCT a.id, a.statusid
            FROM {local_scholarship_testsess} ts
            JOIN {local_scholarship_app} a ON a.id = ts.applicantid
            JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
            WHERE pl.phasetestid = ?
            AND ts.endtime IS NOT NULL
            AND ts.ispassed = 1
        ", [$phaseid]);

        $count = 0;
        $transaction = $DB->start_delegated_transaction();

        try {
            foreach ($passed as $applicant) {
                if ((int) $applicant->statusid === (int) $testpassedstatus->id) {
                    continue;
                }

                $DB->update_record('local_scholarship_app', (object) [
                    'id' => $applicant->id,
                    'statusid' => $testpassedstatus->id,
                    'timemodified' => time(),
                ]);

                $DB->insert_record('local_scholarship_statushist', (object) [
                    'applicantid' => $applicant->id,
                    'oldstatusid' => $applicant->statusid,
                    'newstatusid' => $testpassedstatus->id,
                    'changedby' => null,
                    'note' => 'Promotion automatique après réussite du test.',
                    'timecreated' => time(),
                ]);

                $count++;
            }

            $transaction->allow_commit();

            return [
                'success' => true,
                'message' => $count . ' candidat(s) promu(s) vers TEST_PASSED.',
            ];
        } catch (\Throwable $e) {
            $transaction->rollback($e);
        }
    }

    private static function verify_phase_test_lock_status(int $phasetestid)
    {
        $lockstatus = self::get_phase_test_lock_status($phasetestid);

        if ($lockstatus->locked) {
            self::json_response([
                'success' => false,
                'message' => $lockstatus->message,
                'locked' => true,
                'active_count' => $lockstatus->activecount,
                'completed_count' => $lockstatus->completedcount,
            ], 423);
        }

        return;
    }
    private static function get_phase_test_lock_status(int $phasetestid): \stdClass
    {
        global $DB;

        $activecount = (int) $DB->count_records_sql("
        SELECT COUNT(1)
          FROM {local_scholarship_testsess} ts
          JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
         WHERE pl.phasetestid = ?
           AND ts.starttime IS NOT NULL
           AND ts.endtime IS NULL
    ", [
            $phasetestid,
        ]);

        $completedcount = (int) $DB->count_records_sql("
        SELECT COUNT(1)
          FROM {local_scholarship_testsess} ts
          JOIN {local_scholarship_phaseloc} pl ON pl.id = ts.phaselocid
         WHERE pl.phasetestid = ?
           AND ts.endtime IS NOT NULL
    ", [
            $phasetestid,
        ]);

        $status = new \stdClass();
        $status->activecount = $activecount;
        $status->completedcount = $completedcount;
        $status->locked = $activecount > 0 || $completedcount > 0;

        if ($activecount > 0) {
            $status->reason = "Modification impossible : au moins un candidat est en train de passer ce test.";
        } else if ($completedcount > 0) {
            $status->reason = "Modification impossible : au moins un candidat a déjà terminé ce test.";
        } else {
            $status->reason = "";
        }

        return $status;
    }

    protected static function json_response(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        die;
    }
}