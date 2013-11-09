<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Mato Ilic <info@matoilic.ch>
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

class Tx_T3chimp_MailChimp_Field_Imageurl extends Tx_T3chimp_MailChimp_Field_Abstract {
    /**
     * @var Tx_T3chimp_Service_FileUpload
     */
    protected $uploadService;

    /**
     * @var Tx_Extbase_MVC_Web_Routing_UriBuilder
     */
    protected $uriBuilder;

    /**
     * @param Tx_Extbase_MVC_Request $request
     */
    public function bindRequest(Tx_Extbase_MVC_Request $request) {
        try {
            $file = $this->uploadService->processUploadedFile($this->getName());
            $this->setValue($file);
        } catch(Tx_T3chimp_Service_FileUpload_InvalidExtensionException $ex) {
            $this->setValue(NULL);
            $this->errors[] = 't3chimp.error.unsupportedImageFormat';
        } catch(Tx_T3chimp_Service_FileUpload_FileTooLargeException $ex) {
            $this->setValue(NULL);
            $this->errors[] = 't3chimp.error.fileTooLarge';
        } catch(Tx_T3chimp_Service_FileUpload_FilePartiallyUploadedException $ex) {
            $this->setValue(NULL);
            $this->errors[] = 't3chimp.error.filePartiallyUploaded';
        } catch(Tx_T3chimp_Service_FileUpload_NoFileUploadedException $ex) {
            $this->setValue(NULL);
        }
    }

    /**
     * @return string
     */
    public function getApiValue() {
        return t3lib_div::locationHeaderUrl('/' . $this->getValue());
    }

    /**
     * @param Tx_T3chimp_Service_FileUpload $uploadService
     */
    public function injectUploadService(Tx_T3chimp_Service_FileUpload $uploadService) {
        $this->uploadService = $uploadService;
    }

    /**
     * @param Tx_Extbase_MVC_Web_Routing_UriBuilder $uriBuilder
     */
    public function injectUriBuilder(Tx_Extbase_MVC_Web_Routing_UriBuilder $uriBuilder) {
        $this->uriBuilder = $uriBuilder;
    }

    protected function validate() {
        if(count($this->errors) == 0) {
            parent::validate();
        }
    }


}
