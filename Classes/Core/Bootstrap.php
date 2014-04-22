<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Mato Ilic <info@matoilic.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Custom bootstrap to properly initialize important properties for AJAX requests
 */
namespace MatoIlic\T3Chimp\Core;


class Bootstrap extends \TYPO3\CMS\Extbase\Core\Bootstrap {
    /**
     * @var \TYPO3\CMS\Core\Database\DatabaseConnection
     * @inject
     */
    protected $db;
    /**
     * @inherit
     */
    public function run($content, $configuration) {
        $this->initialize($configuration);
        $this->db = $GLOBALS['TYPO3_DB'];

        $GLOBALS['TSFE']->sys_language_uid = $_GET['L'];
        if(strlen($_GET['LISO']) > 0) {
            $GLOBALS['TSFE']->sys_language_isocode = $_GET['LISO'];
            $GLOBALS['TSFE']->config['config']['language'] = $_GET['LISO'];
        }

        $GLOBALS['TSFE']->id = $_GET['id'];

        if(array_key_exists('cid', $_GET)) {
            $cid = (int)$_GET['cid'];

            $ttContent = $this->db->exec_SELECTgetSingleRow(
                '*',
                'tt_content',
                'uid=' . $cid
            );

            $this->cObj->data = array_merge($this->cObj->data, $ttContent);
        }

        return $this->handleRequest();
    }
}
