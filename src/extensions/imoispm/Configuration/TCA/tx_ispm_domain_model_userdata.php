<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata',
        'label' => 'chiffre',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'chiffre, usercookie, objectnr, unitnr, firstname, surname, email',
        'iconfile' => 'EXT:imoispm/Resources/Public/Icons/tx_ispm.gif',
    ],
    'columns' => [
        'chiffre' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.chiffre',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'usercookie' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.usercookie',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
            ],
        ],
        'objectnr' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.objectnr',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],
        'unitnr' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.unitnr',
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
        'salutation' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.salutation',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim',
            ],
        ],
        'firstname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.firstname',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
            ],
        ],
        'surname' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.surname',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.email',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
            ],
        ],
        'telefon' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_userdata.telefon',
            'config' => [
                'type' => 'input',
                'size' => 255,
                'eval' => 'trim',
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
        '0' => [
            'showitem' => 'chiffre, usercookie, objectnr, unitnr, salutation, firstname, surname, email, telefon, tstamp, --div--;Visibility, hidden',
        ],
    ],
];
