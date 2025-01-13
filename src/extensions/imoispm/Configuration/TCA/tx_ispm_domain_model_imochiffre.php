<?php

use Mg\Imoispm\Tca\ImoChiffreItemsProc;

return [
    'ctrl' => [
        'title' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre',
        'label' => 'chiffre',
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
        'searchFields' => 'chiffre',
        'iconfile' => 'EXT:imoispm/Resources/Public/Icons/tx_ispm.gif',
    ],
    'types' => [
        '0' => ['showitem' => 'userid, objectnr, unitnr, hidden'],
    ],
    'columns' => [ 
        'userid' => [
            'exclude' => 1,
            'label' => 'User',
            'description' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre.fe_user.description',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_ispm_domain_model_frontenduser',
                'size' => 1,
                'maxitems' => 1,
                'minitems' => 0,
                'default' => 0,
                'hideSuggest' => true,
                'suggestOptions' => [
                    'tx_ispm_domain_model_frontenduser' => [
                        'searchWholePhrase' => 1,
                    ],
                ],
            ],
        ],
        'objectnr' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre.objectnr',
            'description' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre.objectnr.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_ispm_domain_model_imoobjects',
                'itemsProcFunc' => ImoChiffreItemsProc::class . '->objectNrItemsProc',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],    
        'unitnr' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre.unitnr',
            'description' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre.unitnr.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_ispm_domain_model_imounits',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'chiffre' => [
            'exclude' => true,
            'label' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre.chiffre',
            'description' => 'LLL:EXT:imoispm/Resources/Private/Language/locallang_db.xlf:tx_ispm_domain_model_imochiffre.chiffre.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => '',
            ],
        ],
    ],
];
