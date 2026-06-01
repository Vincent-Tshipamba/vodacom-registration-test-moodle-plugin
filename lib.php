<?php
defined('MOODLE_INTERNAL') || die();
function local_scholarship_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = [])
{
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    require_login();

    if ($filearea !== 'applicationdocs') {
        return false;
    }

    $itemid = array_shift($args);
    $filename = array_pop($args);

    $filepath = '/';

    if (!empty($args)) {
        $filepath = '/' . implode('/', $args) . '/';
    }

    $fs = get_file_storage();

    $file = $fs->get_file(
        $context->id,
        'local_scholarship',
        $filearea,
        $itemid,
        $filepath,
        $filename
    );

    if (!$file || $file->is_directory()) {
        return false;
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}