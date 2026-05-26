<?php 

namespace local_scholarship\models;;

defined('MOODLE_INTERNAL') || die();

class City
{
    public const TABLE = 'local_scholarship_city';
    public ?int $id;
    public ?string $name;
    public ?int $timecreated;
    public ?int $timemodified;

    public function __construct(\stdClass $data)
    {
        $this->id = $data->id ?? null;
        $this->name = $data->name ?? null;
        $this->timecreated = $data->timecreated ?? null;
        $this->timemodified = $data->timemodified ?? null;
    }

    public static function create(\stdClass $data): int
    {
        global $DB;

        $record = (object)[
            'name' => $data->name,
            'timecreated' => time(),
            'timemodified' => time(),
        ];

        if (!$DB->record_exists(self::TABLE, ['name' => $record->name])) {
            return $DB->insert_record(self::TABLE, $record);
        }
        return 0;
    }

    public static function in_random_order(): array
    {
        global $DB;

        $records = $DB->get_records(self::TABLE);
        shuffle($records);
        
        return array_values($records);
    }
}