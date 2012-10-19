<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'subscription', 'Newsletter Subscription');

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