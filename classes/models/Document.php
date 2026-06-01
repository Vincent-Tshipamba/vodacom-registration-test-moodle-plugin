<?php

namespace local_scholarship\models;

defined('MOODLE_INTERNAL') || die();

class Document
{
    public const TABLE = 'local_scholarship_document';


    public static function create(\stdClass $data): int
    {
        global $DB;

        $data->timecreated = time();
        $data->timemodified = time();

        return $DB->insert_record(self::TABLE, $data);
    }
}