<?php
namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class HistoriqueStatusChange 
{
    public const TABLE = 'local_scholarship_statushist';
    public int $id;
    public int $applicantid;
    public int $oldstatusid;
    public int $newstatusid;
    public int $changedby;
    public ?string $note;
    public ?int $timecreated;

    public function __construct(\stdClass $data)
    {
        $this->id = $data->id ?? 0;
        $this->applicantid = $data->applicantid ?? 0;
        $this->oldstatusid = $data->oldstatusid ?? 0;
        $this->newstatusid = $data->newstatusid ?? 0;
        $this->changedby = $data->changedby ?? 0;
        $this->note = $data->note ?? null;
        $this->timecreated = $data->timecreated ?? null;
    }

    public static function create(\stdClass $data): int
    {
        global $DB;

        $data->timecreated = time();

        return $DB->insert_record(self::TABLE, $data);
    }
}