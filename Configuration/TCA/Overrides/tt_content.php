<?php
defined('TYPO3_MODE') || die('Access denied.');

/**
 * Frontend Plugin Display
 */
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'ew_socialfeedwall',
    'Display',
    'LLL:EXT:ew_socialfeedwall/Resources/Private/Language/locallang_be.xlf:tt_content.list_type_display',
    'EXT:ew_socialfeedwall/Resources/Public/Icons/Extension.svg'
);
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['ewsocialfeedwall_display'] =
    'layout, select_key, pages, recursive';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['ewsocialfeedwall_display'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'ewsocialfeedwall_display',
    'FILE:EXT:ew_socialfeedwall/Configuration/FlexForms/Display.xml'
);
