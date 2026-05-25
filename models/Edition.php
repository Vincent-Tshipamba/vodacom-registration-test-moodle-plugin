<?php

namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class Edition
{
    public ?int $id;
    public ?string $name;
    public ?int $year;
    public ?bool $iscurrent;
    public ?bool $isactive;
    public ?int $timecreated;
    public ?int $timemodified;

    public function __construct(\stdClass $data)
    {
        $this->id = $data->id ?? null;
        $this->name = $data->name ?? null;
        $this->year = $data->year ?? null;
        $this->iscurrent = isset($data->iscurrent) ? (bool)$data->iscurrent : null;
        $this->isactive = isset($data->isactive) ? (bool)$data->isactive : null;
        $this->timecreated = $data->timecreated ?? null;
        $this->timemodified = $data->timemodified ?? null;
    }

    public static function get_current_edition(): ?\stdClass
    {
        global $DB;

        return $DB->get_record('local_scholarship_edition', [
            'iscurrent' => 1,
            'isactive' => 1,
        ]) ?: null;
    }
}