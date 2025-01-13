<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'ispm',
    'description' => 'ispm site package',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'bootstrap_package' => '15.0.0-15.99.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Mediagear\\Ispm\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'mediagear',
    'author_email' => 'bennet.witczak@mediagear.de',
    'author_company' => 'mediagear',
    'version' => '1.0.0',
];
