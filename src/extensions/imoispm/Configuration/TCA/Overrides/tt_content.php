<?php
defined('TYPO3') || die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$extensionKey = 'imoispm';
$pluginName = 'ispmfrontend';
$pluginTitle = 'ISPM FRONTEND';

$pluginSignature = ExtensionUtility::registerPlugin(
    $extensionKey,
    $pluginName,
    $pluginTitle,
    null,
    ""
);

// // FlexForm
// ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;Configuration,pi_flexform,', $pluginSignature, 'after:subheader');

// ExtensionManagementUtility::addPiFlexFormValue(
//     '*',
//     'FILE:EXT:imoispm/Configuration/FlexForms/flexform_ispm.xml',
//     $pluginSignature
// );
