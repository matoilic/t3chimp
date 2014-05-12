<?php

if (!defined ('TYPO3_MODE')) die ('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin($_EXTKEY, 'subscription', 'T3Chimp: Newsletter Subscription');

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_subscription'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($_EXTKEY . '_subscription', 'FILE:EXT:t3chimp/Configuration/FlexForms/Subscription.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'T3Chimp Setup');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/DefaultStyles', 'T3Chimp CSS Styles (optional)');

/*if (TYPO3_MODE === 'BE') {
    Tx_Extbase_Utility_Extension::registerModule(
        $_EXTKEY,
        'tools',
        't3chimp',
        '',
        array(
            'Backend' 	=> 'index'
        ),
        array(
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_backend.xlf',
        )
    );
}*/

$feUserColumns = array(
    'subscribed_to_newsletter' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang.xlf:fe_users.subscribed_to_newsletter',
        'config' => Array (
            'type' => 'check',
            'default' => '0'
        )
    )
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $feUserColumns, 1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCATypes('fe_users', '--div--;T3Chimp,subscribed_to_newsletter;;;;1-1-1');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['MatoIlic\\T3Chimp\\Scheduler\\SyncToMailChimpTask'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xlf:syncToMailChimpTask.name',
    'description'      => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xlf:syncToMailChimpTask.description',
    'additionalFields' => 'MatoIlic\\T3Chimp\\Scheduler\\SyncToMailChimpFieldProvider'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['MatoIlic\\T3Chimp\\Scheduler\\SyncBackFromMailChimpTask'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xlf:syncBackFromMailChimpTask.name',
    'description'      => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xlf:syncBackFromMailChimpTask.description',
    'additionalFields' => 'MatoIlic\\T3Chimp\\Scheduler\\SyncBackFromMailChimpFieldProvider'
);

