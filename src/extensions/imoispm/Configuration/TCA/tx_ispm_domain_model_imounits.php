<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imounits',
        'label' => 'number',
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
        'searchFields' => 'chiffre,number',
        'iconfile' => 'EXT:imoispm/Resources/Public/Icons/tx_ispm.gif',
    ],
    'types' => [
        '1' => ['showitem' => 'chiffre, imoobjectuid, number, placeholder, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'chiffre' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre.chiffre',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_ispm_domain_model_imochiffre',
                'foreign_field' => 'unitnr',
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'expandSingle' => 1,
                    'newRecordLinkAddTitle' => 1,
                ],
            ],
        ],
        'imoobjectuid' => [
            'exclude' => 0,
            'label' => 'Object',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_ispm_domain_model_imoobjects',
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],
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
                'foreign_table' => 'tx_ispm_domain_model_imounits',
                'foreign_table_where' => 'AND {#tx_ispm_domain_model_imounits}.{#pid}=###CURRENT_PID### AND {#tx_ispm_domain_model_imounits}.{#sys_language_uid} IN (-1,0)',
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
        'number' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imounits.number',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'placeholder' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imounits.placeholder',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
        'offer' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imounits.offer',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
    ],
];
