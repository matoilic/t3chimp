<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

require_once(t3lib_extMgm::extPath($_EXTKEY) . '/Classes/Domain/Repository/ListRepository.php');

if(!defined('T3CHIMP_API_KEY')) {
    $global = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
    define('T3CHIMP_API_KEY', $global['apiKey']);
}

Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'subscription', 'Newsletter Subscription');

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_subscription'] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_subscription', 'FILE:EXT:t3chimp/Configuration/FlexForms/Subscription.xml');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'T3Chimp Setup');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/DefaultStyles', 'T3Chimp Showroom CSS Styles (optional)');