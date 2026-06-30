<?php

namespace local_scholarship\controllers;

use local_scholarship\models\Edition;

defined('MOODLE_INTERNAL') || die();

class InterviewController
{
    public static function index()
    {
        global $DB;

        $data = new \stdClass();

        $data->currentEdition = Edition::get_current_edition();

        if (!$data->currentEdition) {
            throw new \moodle_exception('nocurrentedition', 'local_scholarship');
        }

        return $data;
    }
}