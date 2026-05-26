<?php

namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class University
{
    public const TABLE = 'local_scholarship_univ';
    public ?int $id;
    public ?string $name;
    public ?int $cityid;
    public ?string $contactphone;
    public ?string $contactemail;
    public ?string $contactpersonname;
    public ?string $contactpersonphone;
    public ?string $website;
    public ?int $timecreated;
    public ?int $timemodified;

    public function __construct(\stdClass $data)
    {
        $this->id = $data->id ?? null;
        $this->name = $data->name ?? null;
        $this->cityid = $data->cityid ?? null;
        $this->contactphone = $data->contactphone ?? null;
        $this->contactemail = $data->contactemail ?? null;
        $this->contactpersonname = $data->contactpersonname ?? null;
        $this->contactpersonphone = $data->contactpersonphone ?? null;
        $this->website = $data->website ?? null;
        $this->timecreated = $data->timecreated ?? null;
        $this->timemodified = $data->timemodified ?? null;
    }

    public static function create(\stdClass $data): int
    {
        global $DB;

        $record = (object) [
            'name' => $data->name,
            'cityid' => $data->cityid ?? null,
            'contactphone' => $data->contactphone ?? '',
            'contactemail' => $data->contactemail ?? '',
            'contactpersonname' => $data->contactpersonname ?? '',
            'contactpersonphone' => $data->contactpersonphone ?? '',
            'website' => $data->website ?? '',
            'timecreated' => time(),
            'timemodified' => time(),
        ];

        if (!$DB->record_exists(self::TABLE, ['name' => $record->name])) {
            return $DB->insert_record(self::TABLE, $record);
        }
        return 0;
    }
}