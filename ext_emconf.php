<?php

$EM_CONF['ew_socialfeedwall'] = [
    'title' => 'Social feed wall',
    'description' => 'Displays social feeds like twitter wall',
    'category' => 'misc',
    'author' => 'Sebastian Fischer',
    'author_email' => 'typo3@evoweb.de',
    'author_company' => 'evoweb',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-10.99.99',
        ],
    ],
];
