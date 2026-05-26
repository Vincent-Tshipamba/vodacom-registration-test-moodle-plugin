<?php

namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class DocumentType
{
    public const TABLE = 'local_scholarship_doctype';
    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?int $reqcandidate;
    public ?int $reqscholar;
    public ?int $sortorder;
    public ?int $timecreated;
    public ?int $timemodified;

    public function __construct(\stdClass $data)
    {
        $this->id = $data->id ?? null;
        $this->name = $data->name ?? null;
        $this->description = $data->description ?? null;
        $this->reqcandidate = $data->reqcandidate ?? null;
        $this->reqscholar = $data->reqscholar ?? null;
        $this->sortorder = $data->sortorder ?? null;
        $this->timecreated = $data->timecreated ?? null;
        $this->timemodified = $data->timemodified ?? null;
    }

    public static function create(\stdClass $data): int
    {
        global $DB;

        $record = (object)[
            'name' => $data->name,
            'description' => $data->description ?? '',
            'reqcandidate' => isset($data->reqcandidate) ? (int)$data->reqcandidate : 0,
            'reqscholar' => isset($data->reqscholar) ? (int)$data->reqscholar : 0,
            'sortorder' => $data->sortorder ?? 0,
            'timecreated' => time(),
            'timemodified' => time(),
        ];

        if (!$DB->record_exists(self::TABLE, ['name' => $record->name])) {
            return $DB->insert_record(self::TABLE, $record);
        }
        return 0;
    }
}