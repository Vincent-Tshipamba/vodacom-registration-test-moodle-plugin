<?php

namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class Status
{
    public const TABLE = 'local_scholarship_status';
    public string $name;
    public ?string $description;
    public ?int $timecreated;
    public ?int $timemodified;

    public function __construct(\stdClass $data)
    {
        $this->name = $data->name;
        $this->description = $data->description ?? null;
        $this->timecreated = $data->timecreated ?? null;
        $this->timemodified = $data->timemodified ?? null;
    }

    public static function create(\stdClass $data)
    {
        global $DB;

        $record = (object)[
            'name' => $data->name,
            'description' => $data->description ?? '',
            'timecreated' => time(),
            'timemodified' => time(),
        ];

        if (!$DB->record_exists(self::TABLE, ['name' => $record->name])) {
            return $DB->insert_record(self::TABLE, $record);
        }
        return 0;
    }

    public static function get_status_by_name(string $name): ?\stdClass
    {
        global $DB;

        return $DB->get_record(self::TABLE, ['name' => $name]) ?: null;
    }
}