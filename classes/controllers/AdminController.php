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
        global $DB, $CFG;

        $currentedition = Edition::get_current_edition();

        $page = optional_param('page', 0, PARAM_INT);
        $ajax = optional_param('ajax', 0, PARAM_INT);

        $page = max(0, $page);
        $perpage = 2;
        $offset = $page * $perpage;

        $applicants = [];
        $total = 0;
        $nextpageurl = null;

        if ($currentedition) {
            $total = (int) $DB->count_records('local_scholarship_app', [
                'editionid' => (int) $currentedition->id,
            ]);

            $applicants = $DB->get_records_sql("
            SELECT
                a.id,
                a.fullname,
                a.address,
                a.phone,
                a.regcode,
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
            ", [(int) $currentedition->id,], $offset, $perpage);

            foreach ($applicants as $applicant) {
                $applicant->documents = Applicant::get_documents($applicant->id);
            }

            if (($offset + $perpage) < $total) {
                $nextpageurl = (new \moodle_url('/local/scholarship/admin/applicants/', [
                    'page' => $page + 1,
                    'ajax' => 1,
                ]))->out(false);
            }
        }

        return (object) [
            'applicants' => $applicants,
            'total' => $total,
            'page' => $page,
            'perpage' => $perpage,
            'nextpageurl' => $nextpageurl,
        ];
    }

    public static function search()
    {
        global $DB;

        $query = required_param('query', PARAM_TEXT);
        $query = trim($query);

        $like = '%' . $DB->sql_like_escape($query) . '%';

        $params = [
            'fullname' => $like,
            'phone' => $like,
            'regcode' => $like,
            'examcode' => $like,
        ];

        $sql = "
            SELECT id,
                fullname,
                birthdate,
                phone,
                percentage,
                address,
                careergoals,
                regcode,
                examcode
            FROM {local_scholarship_app}
            WHERE " . $DB->sql_like('fullname', ':fullname', false) . "
                OR " . $DB->sql_like('phone', ':phone', false) . "
                OR " . $DB->sql_like('regcode', ':regcode', false) . "
                OR " . $DB->sql_like('examcode', ':examcode', false) . "
        ORDER BY timecreated DESC
        ";

        $records = $DB->get_records_sql($sql, $params, 0, 5);

        $results = [];

        foreach ($records as $record) {
            $results[] = [
                'id' => (int) $record->id,
                'fullname' => $record->fullname,
                'birthdate' => date('Y-m-d', $record->birthdate),
                'phone' => $record->phone,
                'percentage' => $record->percentage,
                'address' => $record->address,
                'careergoals' => $record->careergoals,
                'regcode' => $record->regcode,
                'examcode' => $record->examcode,
                'url' => (new \moodle_url('/local/scholarship/admin/applicants/show', [
                    'id' => $record->id,
                ]))->out(false),
            ];
        }

        return $results;
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

        $app_documents = Applicant::get_documents($id);

        $applicant->documents = $app_documents;

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