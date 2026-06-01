<?php

namespace local_scholarship\controllers;

use local_scholarship\models\Applicant;
use local_scholarship\models\Edition;
use local_scholarship\models\HistoriqueStatusChange;
use local_scholarship\models\Status;

class AdminController
{
    public static function dashboard(): \stdClass
    {
        require(__DIR__ . '/../../admin/partials/values.php');

        global $DB;

        $currentedition = Edition::get_current_edition();

        $stats = [
            'total' => 0,
            'total_scholars' => 0,
            'pending' => 0,
            'accepted' => 0,
            'rejected' => 0,
            'shortlisted' => 0,
            'test_passed' => 0,
            'interview_passed' => 0,
        ];

        if ($currentedition) {
            $stats['total_applicants'] = $DB->count_records('local_scholarship_app', [
                'editionid' => $currentedition->id,
            ]);

            $stats['total_scholars'] = $DB->count_records_sql("
                SELECT COUNT(1)
                FROM {local_scholarship_app} a
                JOIN {local_scholarship_status} s ON s.id = a.statusid
                WHERE a.editionid = ?
                AND s.name = ?
            ", [$currentedition->id, 'ADMITTED']);

            $stats['pending'] = $DB->count_records_sql("
                SELECT COUNT(1)
                FROM {local_scholarship_app} a
                JOIN {local_scholarship_status} s ON s.id = a.statusid
                WHERE a.editionid = ?
                AND s.name = ?
            ", [$currentedition->id, 'PENDING']);

            $stats['accepted'] = $DB->count_records_sql("
                SELECT COUNT(1)
                FROM {local_scholarship_app} a
                JOIN {local_scholarship_status} s ON s.id = a.statusid
                WHERE a.editionid = ?
                AND s.name = ?
            ", [$currentedition->id, 'ADMITTED']);

            $stats['rejected'] = $DB->count_records_sql("
                SELECT COUNT(1)
                FROM {local_scholarship_app} a
                JOIN {local_scholarship_status} s ON s.id = a.statusid
                WHERE a.editionid = ?
                AND s.name = ?
            ", [$currentedition->id, 'REJECTED']);

            $stats['shortlisted'] = $DB->count_records_sql("
                SELECT COUNT(1)
                FROM {local_scholarship_app} a
                JOIN {local_scholarship_status} s ON s.id = a.statusid
                WHERE a.editionid = ?
                AND s.name = ?
            ", [$currentedition->id, 'SHORTLISTED']);

            $stats['test_passed'] = $DB->count_records_sql("
                SELECT COUNT(1)
                FROM {local_scholarship_app} a
                JOIN {local_scholarship_status} s ON s.id = a.statusid
                WHERE a.editionid = ?
                AND s.name = ?
            ", [$currentedition->id, 'TEST_PASSED']);

            $stats['interview_passed'] = $DB->count_records_sql("
                SELECT COUNT(1)
                FROM {local_scholarship_app} a
                JOIN {local_scholarship_status} s ON s.id = a.statusid
                WHERE a.editionid = ?
                AND s.name = ?
            ", [$currentedition->id, 'INTERVIEW_PASSED']);
        }

        $editionstats = $DB->get_records_sql("
            SELECT e.id, e.name, e.year, COUNT(a.id) AS total
            FROM {local_scholarship_edition} e
            LEFT JOIN {local_scholarship_app} a ON a.editionid = e.id
            GROUP BY e.id, e.name, e.year
            ORDER BY e.year ASC
        ");

        $recentapplications = [];
        $isregistrationopen = false;

        if ($currentedition) {
            $now = time();

            $isregistrationopen =
                !empty($currentedition->appstartdate)
                && !empty($currentedition->appenddate)
                && $now >= (int) $currentedition->appstartdate
                && $now <= (int) $currentedition->appenddate;

            if ($isregistrationopen) {
                $recentapplications = $DB->get_records_sql("
                    SELECT a.id,
                        a.fullname,
                        a.phone,
                        a.email,
                        a.examcode,
                        a.percentage,
                        a.submittedat,
                        c.name AS diplomacityname,
                        s.name AS statusname
                    FROM {local_scholarship_app} a
                    LEFT JOIN {local_scholarship_status} s ON s.id = a.statusid
                    LEFT JOIN {local_scholarship_city} c ON c.id = a.diplomacityid
                    WHERE a.editionid = ?
                    ORDER BY a.submittedat DESC, a.timecreated DESC
                ", [$currentedition->id]);
            }
        }

        return (object) [
            'currentedition' => $currentedition,
            'stats' => $stats,
            'editionstats' => $editionstats,
            'recentapplications' => $recentapplications,
            'statusLabels' => $statusLabels,
            'statusClasses' => $statusClasses,
            'isRegistrationOpen' => $isregistrationopen,
        ];
    }

    public static function applicants(): \stdClass
    {
        global $DB;

        $currentedition = Edition::get_current_edition();

        $applicants = [];

        if ($currentedition) {
            $applicants = $DB->get_records_sql("
                SELECT a.id,
                    a.fullname,
                    a.phone,
                    a.examcode,
                    a.percentage,
                    a.submittedat,
                    c.name AS diplomacityname,
                    ci.name AS currentcityname,
                    s.name AS statusname
                FROM {local_scholarship_app} a
                LEFT JOIN {local_scholarship_status} s ON s.id = a.statusid
                LEFT JOIN {local_scholarship_city} c ON c.id = a.diplomacityid
                LEFT JOIN {local_scholarship_city} ci ON ci.id = a.currentcityid
                WHERE a.editionid = ?
                ORDER BY a.submittedat DESC, a.timecreated DESC
            ", [$currentedition->id]);
        }

        return (object) [
            'applicants' => $applicants,
        ];
    }

    public static function applicant_details(): \stdClass
    {
        global $DB;

        $id = optional_param('id', null, PARAM_INT);

        $applicant = null;

        if ($id) {
            $applicant = $DB->get_record_sql("
                SELECT a.*,
                    ci.name AS currentcityname,
                    c.name AS diplomacityname,
                    s.name AS statusname
                FROM {local_scholarship_app} a
                LEFT JOIN {local_scholarship_status} s ON s.id = a.statusid
                LEFT JOIN {local_scholarship_city} ci ON ci.id = a.currentcityid
                LEFT JOIN {local_scholarship_city} c ON c.id = a.diplomacityid
                WHERE a.id = ?
            ", [$id], MUST_EXIST);

            $history = $DB->get_records_sql("
                SELECT hist.*,
                    u.firstname as changerfirstname,
                    u.lastname as changerlastname,
                    os.name AS oldstatusname,
                    ns.name AS newstatusname
                FROM {local_scholarship_statushist} hist
                LEFT JOIN {user} u ON u.id = hist.changedby
                LEFT JOIN {local_scholarship_status} os ON os.id = hist.oldstatusid
                LEFT JOIN {local_scholarship_status} ns ON ns.id = hist.newstatusid
                WHERE hist.applicantid = ?
                ORDER BY hist.timecreated DESC
            ", [$id]);
        }

        $applicant->birthdate = date('Y-m-d', $applicant->birthdate);
        $applicant->age = self::getAge(new \DateTimeImmutable($applicant->birthdate));
        $applicant->history = $history;

        $documents = $DB->get_records_sql("
            SELECT d.*, dt.name AS doctypename
            FROM {local_scholarship_document} d
            LEFT JOIN {local_scholarship_doctype} dt ON dt.id = d.doctypeid
            WHERE d.applicantid = ?
            ORDER BY dt.sortorder ASC, d.timecreated ASC
            ", [$id]);
        
        $context = \context_system::instance();
        $applicant->documents = [];
        
        foreach ($documents as $doc) {
            $url = \moodle_url::make_pluginfile_url(
                $context->id,
                'local_scholarship',
                $doc->filearea,
                $doc->itemid,
                '/',
                $doc->filename
            )->out(false);

            $ext = strtolower(pathinfo($doc->filename, PATHINFO_EXTENSION));
            $type = strtoupper($doc->doctypename);

            $applicant->documents[$type] = [
                'id' => $doc->id,
                'url' => $url,
                'type' => $type,
                'label' => $doc->doctypename,
                'ext' => $ext,
                'is_pdf' => $ext === 'pdf',
                'status' => $doc->verifstatus,
            ];
        }

        return (object) [
            'applicant' => (object) $applicant,
        ];
    }

    private static function getAge(\DateTimeInterface $birthdate): int
    {
        $today = new \DateTimeImmutable('today');

        return $birthdate->diff($today)->y;
    }

    public static function update_applicant_status()
    {
        global $USER;

        require_sesskey();

        $id = optional_param('id', null, PARAM_INT);
        $status = optional_param('application_status', null, PARAM_TEXT);

        // retrieve applicant
        $applicant = Applicant::find($id);
        if (!$applicant) {
            throw new \moodle_exception('applicantnotfound', 'local_scholarship');
        }

        // retrieve status
        $new_status = Status::get_status_by_name($status);
        if (!$new_status) {
            throw new \moodle_exception('statusnotfound', 'local_scholarship');
        }

        Applicant::update($id, (object) [
            'statusid' => $new_status->id,
        ]);

        HistoriqueStatusChange::create((object) [
            'applicantid' => $applicant->id,
            'oldstatusid' => $applicant->statusid,
            'newstatusid' => $new_status->id,
            'changedby' => $USER->id,
            'note' => null,
            'timecreated' => time(),
        ]);

        $message = get_string('statusupdated', 'local_scholarship');
        $url = new \moodle_url('/local/scholarship/admin/applicants/show', ['id' => $id]);
        redirect(
            $url,
            $message,
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
    }
}