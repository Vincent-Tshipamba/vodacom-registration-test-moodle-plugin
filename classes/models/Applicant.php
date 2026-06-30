<?php

namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class Applicant
{
    public ?int $id;
    public ?string $fullname;
    public ?int $editionid;
    public ?string $regcode;
    public ?string $gender;
    public ?int $birthdate;
    public ?string $phone;
    public ?string $email;
    public ?int $diplomacityid;
    public ?int $currentcityid;
    public ?string $address;
    public ?string $schoolname;
    public ?string $examcode;
    public ?float $percentage;
    public ?string $schoolfield;
    public ?string $intendedfield;
    public ?string $motivation;
    public ?int $statusid;
    public ?int $submittedat;
    public ?int $timecreated;
    public ?int $timemodified;

    public function __construct(\stdClass $data)
    {
        $this->id = $data->id ?? null;
        $this->fullname = $data->fullname ?? null;
        $this->editionid = $data->editionid ?? null;
        $this->regcode = $data->regcode ?? null;
        $this->gender = $data->gender ?? null;
        $this->birthdate = $data->birthdate ?? null;
        $this->phone = $data->phone ?? null;
        $this->email = $data->email ?? null;
        $this->diplomacityid = $data->diplomacityid ?? null;
        $this->currentcityid = $data->currentcityid ?? null;
        $this->address = $data->address ?? null;
        $this->schoolname = $data->schoolname ?? null;
        $this->examcode = $data->examcode ?? null;
        $this->percentage = $data->percentage ?? null;
        $this->schoolfield = $data->schoolfield ?? null;
        $this->intendedfield = $data->intendedfield ?? null;
        $this->motivation = $data->motivation ?? null;
        $this->statusid = $data->statusid ?? null;
        $this->submittedat = $data->submittedat ?? null;
        $this->timecreated = $data->timecreated ?? null;
        $this->timemodified = $data->timemodified ?? null;
    }

    public static function create(\stdClass $data): int
    {
        global $DB;

        $data->timecreated = time();
        $data->timemodified = time();

        return $DB->insert_record('local_scholarship_app', $data);
    }

    public static function update(int $id, \stdClass $data): void
    {
        global $DB;

        $data->id = $id;
        $data->timemodified = time();

        $DB->update_record('local_scholarship_app', $data);
    }

    public static function find(int $id): ?\stdClass
    {
        global $DB;

        return $DB->get_record('local_scholarship_app', ['id' => $id]) ?: null;
    }

    public static function exists_by_examcode(string $examcode, int $editionid): bool
    {
        global $DB;

        return $DB->record_exists('local_scholarship_app', [
            'examcode' => $examcode,
            'editionid' => $editionid,
        ]);
    }

    public static function find_by_examcode(string $examcode, int $editionid): ?\stdClass
    {
        global $DB;

        return $DB->get_record('local_scholarship_app', [
            'examcode' => $examcode,
            'editionid' => $editionid,
        ]) ?: null;
    }

    public static function exists_by_regcode(string $regcode): bool
    {
        global $DB;

        return $DB->record_exists('local_scholarship_app', [
            'regcode' => $regcode,
        ]);
    }

    public static function slug(string $text): string
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');

        return $text;
    }

    public static function get_documents(int $applicantid)
    {
        global $DB;

        $documents = $DB->get_records_sql("
            SELECT d.*, dt.name AS doctypename
            FROM {local_scholarship_document} d
            LEFT JOIN {local_scholarship_doctype} dt ON dt.id = d.doctypeid
            WHERE d.applicantid = ?
            ORDER BY dt.sortorder ASC, d.timecreated ASC
            ", [$applicantid]);

        $context = \context_system::instance();
        $applicant_documents = [];

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

            $applicant_documents[$type] = [
                'id' => $doc->id,
                'url' => $url,
                'type' => $type,
                'label' => $doc->doctypename,
                'ext' => $ext,
                'is_pdf' => $ext === 'pdf',
                'status' => $doc->verifstatus,
            ];
        }
        
        return $applicant_documents;
    }
}