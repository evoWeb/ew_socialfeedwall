<?php

$EM_CONF['ew_socialfeedwall'] = [
    'title' => 'Social feed wall',
    'description' => 'Displays social feeds like twitter wall',
    'category' => 'misc',
    'version' => '1.0.1',
    'state' => 'stable',
    'clearcacheonload' => 1,
    'author' => 'Sebastian Fischer',
    'author_email' => 'typo3@evoweb.de',
    'author_company' => 'evoweb',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.2.99',
        ],
        'conflicts' => [],
    ],
];
