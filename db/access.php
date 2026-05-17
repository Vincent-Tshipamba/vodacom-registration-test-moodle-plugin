<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/scholarship:manage' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager' => CAP_ALLOW,
        ],
    ],
];
