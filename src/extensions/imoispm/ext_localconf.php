<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use Mg\Imoispm\Frontend\Controller\ISPMFrontendController;

defined('TYPO3') or die('Access denied.');

/***************
 * Add default RTE configuration
 */
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['ispm'] = 'EXT:imoispm/Configuration/RTE/Default.yaml';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['debug'] = true;

$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['imoispm']['storagePid'] = 1;


ExtensionUtility::configurePlugin(
    'imoispm',
    'ispmfrontend',
    [
        ISPMFrontendController::class => 'chiffre, checkChiffre, showObjectByChiffre, saveUserData, successSaveUserData',
    ],
    // non-cacheable actions
    [
        ISPMFrontendController::class => 'checkChiffre, saveUserData, successSaveUserData',
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
