<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TYPO3_CONF_VARS['BE']['AJAX'][$_EXTKEY] = t3lib_extMgm::extPath($_EXTKEY).'Lib/AjaxDispatcher.php:Tx_AjaxDispatcher->dispatch';
$TYPO3_CONF_VARS['FE']['eID_include'][$_EXTKEY] = t3lib_extMgm::extPath($_EXTKEY).'Lib/AjaxDispatcher.php';

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][$_EXTKEY] = t3lib_extMgm::extPath($_EXTKEY).'Classes/Hook/Cache.php:&Tx_T3chimp_Hook_Cache->clearCache';

Tx_Extbase_Utility_Extension::configurePlugin(
    $_EXTKEY,
    'subscription',
    array(
        'Subscriptions' => 'index,process,subscribed,unsubscribed'
    ),
    array(
        'Subscriptions' => 'process'
    )
);