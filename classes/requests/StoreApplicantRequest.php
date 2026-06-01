<?php

namespace local_scholarship\requests;

defined('MOODLE_INTERNAL') || die();

class StoreApplicantRequest
{
    public static function validate(): \stdClass
    {
        $data = new \stdClass();

        $data->fullname = required_param('fullname', PARAM_TEXT);
        $data->gender = required_param('gender', PARAM_ALPHA);
        $data->birthdate = required_param('birthdate', PARAM_TEXT);
        $data->phone = required_param('phone', PARAM_TEXT);
        $data->email = optional_param('email', '', PARAM_EMAIL);
        $data->vulntype = optional_param('vulntype', '', PARAM_TEXT);

        $data->diplomacityid = optional_param('diplomacityid', 0, PARAM_INT);
        $data->currentcityid = optional_param('currentcityid', 0, PARAM_INT);
        $data->address = optional_param('address', '', PARAM_TEXT);

        $data->schoolname = required_param('schoolname', PARAM_TEXT);
        $data->examcode = required_param('examcode', PARAM_ALPHANUMEXT);
        $data->percentage = required_param('percentage', PARAM_FLOAT);
        $data->schoolfield = required_param('schoolfield', PARAM_TEXT);
        $data->other_study_option = optional_param('other_study_option', '', PARAM_TEXT);
        $data->intendedfield = required_param('intendedfield', PARAM_TEXT);
        $data->other_university_field = optional_param('other_university_field', '', PARAM_TEXT);

        $data->motivation = required_param('motivation', PARAM_TEXT);
        $data->careergoals = required_param('careergoals', PARAM_TEXT);
        $data->additionalinfo = optional_param('additionalinfo', '', PARAM_TEXT);

        if ($data->percentage < 0 || $data->percentage > 100) {
            throw new \moodle_exception('invalidpercentage', 'local_scholarship');
        }

        return $data;
    }
}