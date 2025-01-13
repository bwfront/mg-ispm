<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_chiffrelog',
        'label' => 'chiffre',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'chiffre, usercookie, objectnr, unitnr',
        'iconfile' => 'EXT:imoispm/Resources/Public/Icons/tx_ispm.gif',
    ],
    'columns' => [
        'chiffre' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_chiffrelog.chiffre',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'usercookie' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_chiffrelog.usercookie',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
            ],
        ],
        'userip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_chiffrelog.userip',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
            ],
        ],
        'objectnr' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_chiffrelog.objectnr',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'unitnr' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_chiffrelog.unitnr',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'tstamp' => [
            'exclude' => true,
            'label' => 'Timestamp',
            'config' => [
                'type' => 'datetime',
                'required' => true,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'chiffre, usercookie, userip, objectnr, unitnr, --div--;Visibility, hidden'],
    ],
];
