<?php
    if (!defined ('TYPO3_MODE')) die ('Access denied.');

    $TYPO3_CONF_VARS['BE']['AJAX'][$_EXTKEY] = t3lib_extMgm::extPath($_EXTKEY).'Lib/AjaxDispatcher.php:Tx_AjaxDispatcher->dispatch';
    $TYPO3_CONF_VARS['FE']['eID_include'][$_EXTKEY] = t3lib_extMgm::extPath($_EXTKEY).'Lib/AjaxDispatcher.php';

    Tx_Extbase_Utility_Extension::configurePlugin(
        $_EXTKEY,
        'subscriptionForm',
        array(

        ),
        array(

        )
    );

    function tx_t3chimp_debug() {
        $global = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
        return $global['debug'];
    }