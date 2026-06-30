<?php

use local_scholarship\models\CategoryQuestion;
use local_scholarship\models\City;
use local_scholarship\models\DocumentType;
use local_scholarship\models\Edition;
use local_scholarship\models\University;

defined('MOODLE_INTERNAL') || die();

function xmldb_local_scholarship_install()
{
    global $DB;

    $now = time();

    // Statuts initiaux.
    $statuses = [
        'PENDING',
        'REJECTED',
        'SHORTLISTED',
        'TEST_PASSED',
        'INTERVIEW_PASSED',
        'ADMITTED'
    ];

    foreach ($statuses as $status) {
        if (!$DB->record_exists('local_scholarship_status', ['name' => $status])) {
            $record = (object) [
                'name' => $status,
                'timecreated' => $now,
                'timemodified' => $now,
            ];

            $DB->insert_record('local_scholarship_status', $record);
        }
    }

    // Villes initiales.
    $cities = [
        'Kinshasa',
        'Lubumbashi',
        'Mbuji-Mayi',
        'Kisangani',
        'Kananga',
        'Likasi',
        'Goma',
        'Bukavu',
        'Kolwezi',
        'Matadi',
        'Boma',
        'Uvira',
        'Bunia',
        'Kikwit',
        'Kalemie',
        'Isiro',
        'Kindu',
        'Butembo',
        'Tshikapa',
        'Mwene-Ditu',
        'Tshikapa',
        'Gemena',
        'Lisala',
        'Beni',
    ];

    foreach ($cities as $city) {
        City::create((object) ['name' => $city]);
    }

    // Categories de questions initiales.
    $categories = [
        ['name' => 'Francais', 'description' => 'Questions de langue francaise'],
        ['name' => 'Anglais', 'description' => 'Questions de langue anglaise'],
        ['name' => 'Culture Generale', 'description' => 'Questions de culture generale'],
        ['name' => 'Maths', 'description' => 'Questions de mathematiques'],
        ['name' => 'Psychotechnique', 'description' => 'Questions psychotechniques'],
    ];

    foreach ($categories as $category) {
        CategoryQuestion::create((object) $category);
    }

    // types de documents initiaux.
    $document_types = [
        [
            'name' => 'DIPLOMA',
            'description' => 'Diploma or certificate of the highest level of education attained by the applicant.',
            'reqcandidate' => true,
            'reqscholar' => false,
            'sortorder' => 2,
        ],
        [
            'name' => 'ID',
            'description' => 'National identification document of the applicant.',
            'reqcandidate' => true,
            'reqscholar' => false,
            'sortorder' => 1,
        ],
        [
            'name' => 'PHOTO',
            'description' => 'Recent passport-sized photograph of the applicant.',
            'reqcandidate' => true,
            'reqscholar' => false,
        ],
        [
            'name' => 'REGISTRATION_PROOF',
            'description' => 'Proof of registration for the current academic year.',
            'reqcandidate' => false,
            'reqscholar' => false,
            'sortorder' => 3,
        ],
        [
            'name' => 'FEES_RECEIPT',
            'description' => 'Receipt of payment for tuition or other academic fees.',
            'reqcandidate' => false,
            'reqscholar' => true,
            'sortorder' => 4,
        ],
        [
            'name' => 'RESULTS_PROOF',
            'description' => 'Official document showing the results of the applicant\'s most recent examinations.',
            'reqcandidate' => false,
            'reqscholar' => true,
            'sortorder' => 5,
        ]
    ];

    foreach ($document_types as $type) {
        DocumentType::create((object) $type);
    }

    // Editions initiales.
    // SELECTION_PHASE, INTERVIEW_PHASE, TEST_PHASE, OPEN, CLOSED, ARCHIVED
    $editions = [
        [
            'name' => 'Edition 2019',
            'year' => 2019,
            'description' => 'Première édition du programme de bourses',
            'quota' => 25,
            'appstartdate' => '2019-07-01',
            'appenddate' => '2019-08-31',
            'iscurrent' => false,
            'isactive' => false,
            'ismixed' => true,
            'status' => 'ARCHIVED',
        ],
        [
            'name' => 'Edition 2020',
            'year' => 2020,
            'description' => 'Deuxième édition du programme de bourses',
            'quota' => 25,
            'appstartdate' => '2020-07-01',
            'appenddate' => '2020-08-31',
            'iscurrent' => false,
            'ismixed' => true,
            'status' => 'ARCHIVED',
        ],
        [
            'name' => 'Edition 2021',
            'year' => 2021,
            'description' => 'Troisième édition du programme de bourses',
            'quota' => 25,
            'appstartdate' => '2021-07-01',
            'appenddate' => '2021-08-31',
            'iscurrent' => false,
            'ismixed' => true,
            'status' => 'OPEN',
        ],
        [
            'name' => 'Edition 2022',
            'year' => 2022,
            'description' => 'Quatrième édition du programme de bourses',
            'quota' => 25,
            'appstartdate' => '2022-07-01',
            'appenddate' => '2022-08-31',
            'iscurrent' => false,
            'ismixed' => true,
            'status' => 'OPEN',
        ],
        [
            'name' => 'Edition 2023',
            'year' => 2023,
            'description' => 'Cinquième édition du programme de bourses',
            'quota' => 100,
            'appstartdate' => '2023-07-01',
            'appenddate' => '2023-08-31',
            'iscurrent' => false,
            'ismixed' => true,
            'status' => 'OPEN',
        ],
        [
            'name' => 'Edition 2024',
            'year' => 2024,
            'description' => 'Sixième édition du programme de bourses',
            'quota' => 50,
            'appstartdate' => '2024-07-01',
            'appenddate' => '2024-08-31',
            'iscurrent' => false,
            'ismixed' => true,
            'status' => 'OPEN',
        ],
        [
            'name' => 'Edition 2025',
            'year' => 2025,
            'description' => 'Septième édition du programme de bourses',
            'quota' => 50,
            'appstartdate' => '2025-07-01',
            'appenddate' => '2025-08-31',
            'iscurrent' => false,
            'ismixed' => false,
            'status' => 'OPEN',
        ],
        [
            'name' => 'Edition 2026',
            'year' => 2026,
            'description' => 'Huitième édition du programme de bourses',
            'quota' => 50,
            'appstartdate' => '2026-06-20',
            'appenddate' => '2026-08-31',
            'iscurrent' => true,
            'ismixed' => false,
            'status' => 'SELECTION_PHASE',
        ]
    ];

    foreach ($editions as $edition) {
        Edition::create((object) $edition);
    }


    $universities = [
        'Université de Kinshasa',
        'Université de Lubumbashi',
        'Université de Goma',
        'Université de Kisangani',
        'Université de Bukavu',
        'Université de Mbandaka',
        'Université de Kananga',
        'Université de Matadi',
        'Université de Tshikapa',
        'Université de Kindu',
        'Université de Kalemie',
        'Université de Boma',
        'Université de Uvira',
        'Université de Mwene-Ditu',
        'Université de Gemena',
        'Université de Lisala',
        'Université de Beni',
        'Université de Butembo',
        'Université de Isiro',
        'Université de Dungu',
        'Institut Supérieur Pédagogique de Bukavu',
        'Institut Supérieur d\'Architecture et d\'Urbanisme de Kinshasa',
        'Institut Supérieur des Techniques Médicales de Lubumbashi',
        'Institut Supérieur de Commerce de Goma',
        'Institut Supérieur de Technologie de Kisangani',
        'Institut Supérieur des Sciences Agronomiques de Mbandaka',
        'Institut Supérieur Pédagogique de Kinshasa',
        'Institut Supérieur des Arts et Métiers de Kinshasa',
        'Institut Supérieur d\'Informatique Programmation et Analyse de Kinshasa',
        'Haute École de Commerce de Kinshasa',
        'Université Protestante au Congo',
        'Université Catholique de Bukavu',
        'Université Pedagogique Nationale',
        'Université Libre des Pays des Grands Lacs',
        'Leadership Academia University',
    ];

    foreach ($universities as $universityName) {
        University::create((object)[
            'name' => $universityName,
            'cityid' => City::in_random_order()[0]->id ?? null,
            'contactemail' => strtolower(str_replace(' ', '_', $universityName)) . '@' . strtolower(str_replace(' ', '', $universityName)) . '.com',
            'contactphone' => '+243' . rand(800000000, 899999999),
            'contactpersonname' => "Personne à contacter dans $universityName",
            'contactpersonphone' => '+243' . rand(800000000, 899999999),
            'website' => 'https://www.' . strtolower(str_replace(' ', '', $universityName)) . '.com',
        ]);
    }
    return true;
}