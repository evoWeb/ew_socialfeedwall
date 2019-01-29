<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Evoweb.EwSocialfeedwall',
        'Display',
        [
            'Display' => 'show, getTweets',
        ],
        [
            'Display' => 'getTweets',
        ]
    );

    /**
     * Page TypoScript for new content element wizards
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:ew_socialfeedwall/Configuration/'
        . 'TSconfig/NewContentElement.typoscript">'
    );
});
