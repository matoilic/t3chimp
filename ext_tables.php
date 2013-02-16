<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'subscription', 'T3Chimp: Newsletter Subscription');

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_subscription'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_subscription', 'FILE:EXT:t3chimp/Configuration/FlexForms/Subscription.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'T3Chimp Setup');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/DefaultStyles', 'T3Chimp CSS Styles (optional)');

if (TYPO3_MODE === 'BE') {
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
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_backend.xml',
        )
    );
}

t3lib_div::loadTCA('fe_users');
$feUserColumns = array(
    'subscribed_to_newsletter' => array (
        'exclude' => 0,
        'label' => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang.xml:fe_users.subscribed_to_newsletter',
        'config' => Array (
            'type' => 'check',
            'default' => '0'
        )
    )
);
t3lib_extMgm::addTCAcolumns('fe_users', $feUserColumns, 1);
t3lib_extMgm::addToAllTCATypes('fe_users','--div--;T3Chimp,subscribed_to_newsletter;;;;1-1-1');

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Tx_T3chimp_Scheduler_SyncToMailChimpTask'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xml:syncToMailChimpTask.name',
    'description'      => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xml:syncToMailChimpTask.description',
    'additionalFields' => 'Tx_T3chimp_Scheduler_SyncToMailChimpFieldProvider'
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Tx_T3chimp_Scheduler_SyncBackFromMailChimpTask'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xml:syncBackFromMailChimpTask.name',
    'description'      => 'LLL:EXT:t3chimp/Resources/Private/Language/locallang_backend.xml:syncBackFromMailChimpTask.description',
    'additionalFields' => 'Tx_T3chimp_Scheduler_SyncBackFromMailChimpFieldProvider'
);

