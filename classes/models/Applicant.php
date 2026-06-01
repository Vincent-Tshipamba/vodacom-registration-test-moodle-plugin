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
    public ?string $vulntype;
    public ?int $diplomacityid;
    public ?int $currentcityid;
    public ?string $address;
    public ?string $schoolname;
    public ?string $examcode;
    public ?float $percentage;
    public ?string $schoolfield;
    public ?string $intendedfield;
    public ?string $motivation;
    public ?string $careergoals;
    public ?string $additionalinfo;
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
        $this->vulntype = $data->vulntype ?? null;
        $this->diplomacityid = $data->diplomacityid ?? null;
        $this->currentcityid = $data->currentcityid ?? null;
        $this->address = $data->address ?? null;
        $this->schoolname = $data->schoolname ?? null;
        $this->examcode = $data->examcode ?? null;
        $this->percentage = $data->percentage ?? null;
        $this->schoolfield = $data->schoolfield ?? null;
        $this->intendedfield = $data->intendedfield ?? null;
        $this->motivation = $data->motivation ?? null;
        $this->careergoals = $data->careergoals ?? null;
        $this->additionalinfo = $data->additionalinfo ?? null;
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
}