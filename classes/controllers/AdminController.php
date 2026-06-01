<?php

namespace local_scholarship\controllers;

use local_scholarship\models\Edition;

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
            ", [$id]);
        }
        $applicant->birthdate = date('Y-m-d', $applicant->birthdate);
        $applicant->age = self::getAge(new \DateTimeImmutable($applicant->birthdate));

        return (object) [
            'applicant' => (object) $applicant,
        ];
    }

    private static function getAge(\DateTimeInterface $birthdate): int
    {
        $today = new \DateTimeImmutable('today');

        return $birthdate->diff($today)->y;
    }
}