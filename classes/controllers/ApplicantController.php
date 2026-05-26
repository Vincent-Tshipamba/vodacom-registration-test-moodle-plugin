<?php

namespace local_scholarship\controllers;

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

    private function generate_unique_regcode(): string
    {
        do {
            $code = strtoupper(substr(bin2hex(random_bytes(4)), 0, 5));
        } while (applicant::exists_by_regcode($code));

        return $code;
    }
}