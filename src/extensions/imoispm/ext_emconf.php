<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'imoispm',
    'description' => 'ispm ext desc',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Mg\\Imoispm\\' => 'Classes/',
        ],
    ],
];
