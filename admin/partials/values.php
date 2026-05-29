<?php

$statusLabels = [
    'PENDING' => get_string('status_pending', 'local_scholarship'),
    'REJECTED' => get_string('status_rejected', 'local_scholarship'),
    'SHORTLISTED' => get_string('status_shortlisted', 'local_scholarship'),
    'TEST_PASSED' => get_string('status_test_passed', 'local_scholarship'),
    'INTERVIEW_PASSED' => get_string('status_interview_passed', 'local_scholarship'),
    'ADMITTED' => get_string('status_admitted', 'local_scholarship'),
];

$statusClasses = [
    'PENDING' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-300',
    'REJECTED' => 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-300',
    'SHORTLISTED' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-300',
    'TEST_PASSED' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/15 dark:text-blue-300',
    'INTERVIEW_PASSED' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300',
    'ADMITTED' => 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-300',
];