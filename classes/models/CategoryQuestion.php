<?php 

namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class CategoryQuestion
{
    public const TABLE = 'local_scholarship_qcategory';
    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?int $timecreated;
    public ?int $timemodified;

    public function __construct(\stdClass $data)
    {
        $this->id = $data->id ?? null;
        $this->name = $data->name ?? null;
        $this->description = $data->description ?? null;
        $this->timecreated = $data->timecreated ?? null;
        $this->timemodified = $data->timemodified ?? null;
    }

    public static function create(\stdClass $data): int
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
}