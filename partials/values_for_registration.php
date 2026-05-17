<?php
$homeurl = new moodle_url('/local/scholarship/index.php');

$steps = [
    ['number' => '01', 'title' => get_string('apply_step1_title', 'local_scholarship')],
    ['number' => '02', 'title' => get_string('apply_step2_title', 'local_scholarship')],
    ['number' => '03', 'title' => get_string('apply_step3_title', 'local_scholarship')],
    ['number' => '04', 'title' => get_string('apply_step4_title', 'local_scholarship')],
    ['number' => '05', 'title' => get_string('apply_step5_title', 'local_scholarship')],
];

$genders = [
    'male' => get_string('apply_gender_male', 'local_scholarship'),
    'female' => get_string('apply_gender_female', 'local_scholarship'),
];

$study_options = [
    'scientific' => get_string('study_scientific', 'local_scholarship'),
    'commercial' => get_string('study_commercial', 'local_scholarship'),
    'pedagogy' => get_string('study_pedagogy', 'local_scholarship'),
    'literary' => get_string('study_literary', 'local_scholarship'),
    'electricity' => get_string('study_electricity', 'local_scholarship'),
    'electronics' => get_string('study_electronics', 'local_scholarship'),
    'study_secretarial' => get_string('study_secretarial', 'local_scholarship'),
    'mechanics' => get_string('study_mechanics', 'local_scholarship'),
    'fashion' => get_string('study_fashion', 'local_scholarship'),
    'other' => get_string('apply_other_study_option_label', 'local_scholarship'),
];

$intended_fields = [
    // Informatique & Technologies
    'field_software' => get_string('field_software', 'local_scholarship'),
    'field_computer' => get_string('field_computer', 'local_scholarship'),
    'field_telecom' => get_string('field_telecom', 'local_scholarship'),

    // Ingénierie & Sciences Appliquées
    'field_civil' => get_string('field_civil', 'local_scholarship'),
    'field_electric' => get_string('field_electric', 'local_scholarship'),
    'field_chemistry' => get_string('field_chemistry', 'local_scholarship'),
    'field_physic' => get_string('field_physic', 'local_scholarship'),
    'field_mathematics' => get_string('field_mathematics', 'local_scholarship'),
    'field_geology' => get_string('field_geology', 'local_scholarship'),
    'field_environment' => get_string('field_environment', 'local_scholarship'),
    'field_architecture' => get_string('field_architecture', 'local_scholarship'),

    // Santé & Sciences Médicales
    'field_medicine' => get_string('field_medicine', 'local_scholarship'),
    'field_dentistry' => get_string('field_dentistry', 'local_scholarship'),
    'field_pharmacy' => get_string('field_pharmacy', 'local_scholarship'),
    'field_nursing' => get_string('field_nursing', 'local_scholarship'),
    'field_public_health' => get_string('field_public_health', 'local_scholarship'),

    // Économie, Gestion & Business
    'field_economics' => get_string('field_economics', 'local_scholarship'),
    'field_management' => get_string('field_management', 'local_scholarship'),
    'field_hr' => get_string('field_hr', 'local_scholarship'),
    'field_marketing' => get_string('field_marketing', 'local_scholarship'),
    'field_accounting' => get_string('field_accounting', 'local_scholarship'),
    'field_bank' => get_string('field_bank', 'local_scholarship'),
    'field_insurace' => get_string('field_insurace', 'local_scholarship'),

    // Droit
    'field_private_law' => get_string('field_private_law', 'local_scholarship'),
    'field_public_law' => get_string('field_public_law', 'local_scholarship'),
    'field_international_law' => get_string('field_international_law', 'local_scholarship'),
    'field_economic_law' => get_string('field_economic_law', 'local_scholarship'),

    // Sciences Humaines & Sociales
    'field_philosophy' => get_string('field_philosophy', 'local_scholarship'),
    'field_history' => get_string('field_history', 'local_scholarship'),
    'field_sociology' => get_string('field_sociology', 'local_scholarship'),
    'field_psychology' => get_string('field_psychology', 'local_scholarship'),
    'field_political_sciences' => get_string('field_political_sciences', 'local_scholarship'),
    'field_international_relations' => get_string('field_international_relations', 'local_scholarship'),
    'field_development' => get_string('field_development', 'local_scholarship'),

    // Agriculture & Sciences Vétérinaires
    'field_agronomy' => get_string('field_agronomy', 'local_scholarship'),
    'field_veterinary' => get_string('field_veterinary', 'local_scholarship'),

    // Autre
    'other' => get_string('apply_other_university_field_label', 'local_scholarship'),
];

$vulnerabilities = [
    'none' => get_string('apply_vulnerability_none', 'local_scholarship'),
    'disabled' => get_string('apply_vulnerability_disabled', 'local_scholarship'),
    'albinos' => get_string('apply_vulnerability_albino', 'local_scholarship'),
    'refugee' => get_string('apply_vulnerability_refugee', 'local_scholarship'),
    'orphan' => get_string('apply_vulnerability_orphan', 'local_scholarship'),
];

$cities = [
    ['id' => 1, 'name' => 'Kinshasa'],
    ['id' => 2, 'name' => 'Lubumbashi'],
    ['id' => 3, 'name' => 'Mbuji-Mayi'],
    ['id' => 4, 'name' => 'Kisangani'],
    ['id' => 5, 'name' => 'Kananga'],
    ['id' => 6, 'name' => 'Likasi'],
    ['id' => 7, 'name' => 'Goma'],
    ['id' => 8, 'name' => 'Bukavu'],
    ['id' => 9, 'name' => 'Kolwezi'],
    ['id' => 10, 'name' => 'Matadi'],
    ['id' => 11, 'name' => 'Boma'],
    ['id' => 12, 'name' => 'Uvira'],
    ['id' => 13, 'name' => 'Bunia'],
    ['id' => 14, 'name' => 'Kikwit'],
    ['id' => 15, 'name' => 'Kalemie'],
    ['id' => 16, 'name' => 'Isiro'],
    ['id' => 17, 'name' => 'Kindu'],
    ['id' => 18, 'name' => 'Butembo'],
    ['id' => 19, 'name' => 'Tshikapa'],
    ['id' => 20, 'name' => 'Mwene-Ditu'],
    ['id' => 21, 'name' => 'Gemena'],
    ['id' => 22, 'name' => 'Lisala'],
    ['id' => 23, 'name' => 'Beni'],
];

$document_types = [
    [
        'name' => 'DIPLOMA',
        'title' => get_string('apply_diploma_label', 'local_scholarship'),
        'description' => get_string('apply_diploma_hint', 'local_scholarship'),
        'is_for_candidats' => true,
    ],
    [
        'name' => 'ID',
        'title' => get_string('apply_id_label', 'local_scholarship'),
        'description' => get_string('apply_id_hint', 'local_scholarship'),
        'is_for_candidats' => true,
    ],
    // [
    //     'name' => 'PHOTO',
    //     'title' => get_string('apply_browse_photo_label', 'local_scholarship'),
    //     'description' => get_string('apply_browse_photo_hint', 'local_scholarship'),
    //     'is_for_candidats' => true,
    // ],
    // [
    //     'name' => 'RECO_LETTER',
    //     'title' => get_string('apply_recommendation_letter_label', 'local_scholarship'),
    //     'description' => get_string('apply_recommendation_letter_hint', 'local_scholarship'),
    //     'is_for_candidats' => true,
    // ],
];