<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imoobjects',
        'label' => 'street',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'city,street,streetnumber',
        'iconfile' => 'EXT:imoispm/Resources/Public/Icons/tx_ispm.gif',
    ],
    'types' => [
        '1' => ['showitem' => 'uid, units, postalcode, city, state, street, streetnumber, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_ispm_domain_model_imoobjects',
                'foreign_table_where' => 'AND {#tx_ispm_domain_model_imoobjects}.{#pid}=###CURRENT_PID### AND {#tx_ispm_domain_model_imoobjects}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'value' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ],
        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imoobjects.city',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'state' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imoobjects.state',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'street' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imoobjects.street',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'streetnumber' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imoobjects.streetnumber',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'postalcode' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imoobjects.postalcode',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'trim,num',
                'default' => '',
            ],
        ],
        'uid' => [
            'label' => 'UID',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'readOnly' => true,
            ],
        ],
        'units' => [
            'exclude' => 0,
            'label' => 'Units',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_ispm_domain_model_imounits',
                'foreign_field' => 'imoobjectuid',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'expandSingle' => 1,
                    'newRecordLinkAddTitle' => 1,
                ],
            ],
        ],
    ],
];
