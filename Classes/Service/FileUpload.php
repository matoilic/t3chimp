<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Mato Ilic <info@matoilic.ch>
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

class Tx_T3chimp_Service_FileUpload implements t3lib_Singleton {
    /**
     * @var array
     */
    protected $allowedExtensions;

    /**
     * @var SettingsProvider
     */
    protected $settingsProvider;

    /**
     * @var array
     */
    protected $files = array();

    /**
     * @var string
     */
    protected $uploadFolder;

    public function __construct() {
        $this->uploadFolder = t3lib_div::getFileAbsFileName('uploads/tx_t3chimp');
        $this->allowedExtensions = explode(',', $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']);
    }

    /**
     * @param SettingsProvider $settingsProvider
     */
    public function injectSettingsProvider(SettingsProvider $settingsProvider) {
        $key = 'tx_' . strtolower($settingsProvider->get('extensionName')) . '_' . $settingsProvider->get('pluginName');

        if(array_key_exists($key, $_FILES)) {
            foreach($_FILES[$key]['name'] as $fieldName => $fileName) {
                $this->files[$fieldName] = array(
                    'name' => $fileName,
                    'type' => $_FILES[$key]['type'][$fieldName],
                    'tmp_name' => $_FILES[$key]['tmp_name'][$fieldName],
                    'error' => $_FILES[$key]['error'][$fieldName],
                    'size' => $_FILES[$key]['size'][$fieldName]
                );
            }
        }
    }

    /**
     * @param string $fileName
     * @return bool
     */
    protected function isAllowed($fileName) {
        $extension = substr(strrchr($fileName, '.'), 1);

        return in_array($extension, $this->allowedExtensions);
    }

    /**
     * @param string $fieldName
     * @return null|string
     * @throws Exception
     */
    public function processUploadedFile($fieldName) {
        if(!array_key_exists($fieldName, $this->files)) {
            return null;
        }

        $file = $this->files[$fieldName];

        switch($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                new Tx_T3chimp_Service_FileUpload_FileTooLargeException();

            case UPLOAD_ERR_PARTIAL:
                new Tx_T3chimp_Service_FileUpload_FilePartiallyUploadedException();

            case UPLOAD_ERR_NO_FILE:
                new Tx_T3chimp_Service_FileUpload_NoFileUploadedException();
        }

        if(!$this->isAllowed($file['name'])) {
            throw new Tx_T3chimp_Service_FileUpload_InvalidExtensionException('invalid file extension', 0, null, $this->allowedExtensions);
        }

        $basicFileFunctions = t3lib_div::makeInstance('t3lib_basicFileFunctions');

        $fileName = $basicFileFunctions->getUniqueName($file['name'], $this->uploadFolder);
        t3lib_div::upload_copy_move($file['tmp_name'], $fileName);

        return 'uploads/tx_t3chimp/' . basename($fileName);
    }
}
