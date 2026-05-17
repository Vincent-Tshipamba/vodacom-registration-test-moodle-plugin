<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add('localplugins', new admin_externalpage(
        'local_scholarship_dashboard',
        get_string('pluginname', 'local_scholarship'),
        new moodle_url('/local/scholarship/index.php'),
        'local/scholarship:manage'
    ));
}
