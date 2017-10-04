<?php

$EM_CONF['ew_socialfeedwall'] = array (
    'title' => 'Social feed wall',
    'description' => 'Displays social feeds like twitter wall',
    'category' => 'misc',
    'version' => '1.0.0',
    'state' => 'stable',
    'clearcacheonload' => 1,
    'author' => 'Sebastian Fischer',
    'author_email' => 'typo3@evoweb.de',
    'author_company' => '',
    'constraints' => array (
        'depends' => array (
            'typo3' => '8.7.0-8.7.99',
        ),
        'conflicts' => '',
    ),
);
