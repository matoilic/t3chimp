<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][$_EXTKEY] = t3lib_extMgm::extPath($_EXTKEY).'Classes/Hook/Cache.php:&Tx_T3chimp_Hook_Cache->clearCache';

if (TYPO3_MODE === 'BE' && TYPO3_version >= '4.6.0') {
    $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3chimp']);

    if($extConf['debug']) {
        if (TYPO3_version < '6.0.0') {
            $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Tx_T3chimp_Command_MaintenanceCommandController';
        }
    }
}

Tx_Extbase_Utility_Extension::configurePlugin(
    $_EXTKEY,
    'subscription',
    array(
        'Subscriptions' => 'index,process,edit'
    ),
    array(
        'Subscriptions' => 'process,edit'
    )
);
