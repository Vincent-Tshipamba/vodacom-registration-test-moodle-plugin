<?php

namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class PhaseTest
{
    public ?int $id;
    public ?int $editionid;
    public ?string $description;
    public ?int $durationmin;
    public ?int $starttime;
    public ?int $endtime;
    public ?int $numberquestions;
    public ?int $passingscore;
    public ?string $status;
    public ?int $timecreated;
    public ?int $timemodified;

    public function __construct(\stdClass $data)
    {
        $this->id = $data->id ?? null;
        $this->editionid = $data->editionid ?? null;
        $this->status = $data->status ?? null;
        $this->starttime = $data->starttime ?? null;
        $this->endtime = $data->endtime ?? null;
        $this->numberquestions = $data->numberquestions ?? null;
        $this->passingscore = $data->passingscore ?? null;
        $this->editionid = $data->editionid ?? null;
        $this->durationmin = $data->durationmin ?? null;
        $this->description = $data->description ?? null;
        $this->timecreated = $data->timecreated ?? null;
        $this->timemodified = $data->timemodified ?? null;
    }

    public static function create(\stdClass $data): int
    {
        global $DB;

        $data->timecreated = time();
        $data->timemodified = time();

        return $DB->insert_record('local_scholarship_phasetest', $data);
    }

    public static function update(int $id, \stdClass $data): void
    {
        global $DB;

        $data->id = $id;
        $data->timemodified = time();

        $DB->update_record('local_scholarship_phasetest', $data);
    }

    public static function find(int $id): ?\stdClass
    {
        global $DB;

        return $DB->get_record('local_scholarship_phasetest', ['id' => $id]) ?: null;
    }

    public static function get_current_phase(): ?\stdClass
    {
        global $DB;

        $currentedition = Edition::get_current_edition();

        if (!$currentedition) {
            return null;
        }

        return $DB->get_record('local_scholarship_phasetest', [
            'editionid' => (int) $currentedition->id,
        ]) ?: null;
    }
}