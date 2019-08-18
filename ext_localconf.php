<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'EwSocialfeedwall',
        'Display',
        [
            \Evoweb\EwSocialfeedwall\Controller\DisplayController::class => 'show, getTweets',
        ],
        [
            \Evoweb\EwSocialfeedwall\Controller\DisplayController::class => 'getTweets',
        ]
    );

    /**
     * Page TypoScript for new content element wizards
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import \'EXT:ew_socialfeedwall/Configuration/TSconfig/NewContentElement.typoscript\''
    );
});
