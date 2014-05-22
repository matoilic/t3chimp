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

namespace MatoIlic\T3Chimp\MailChimp\Field;

use MatoIlic\T3Chimp\Service\FileUpload;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Request;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

class Imageurl extends AbstractField {
    /**
     * @var FileUpload
     */
    protected $uploadService;

    /**
     * @var UriBuilder
     */
    protected $uriBuilder;

    /**
     * @param Request $request
     */
    public function bindRequest(Request $request) {
        try {
            $file = $this->uploadService->processUploadedFile($this->getName());
            $this->setValue($file);
        } catch(FileUpload\InvalidExtensionException $ex) {
            $this->setValue(NULL);
            $this->errors[] = 'error_unsupportedImageFormat';
        } catch(FileUpload\FileTooLargeException $ex) {
            $this->setValue(NULL);
            $this->errors[] = 'error_fileTooLarge';
        } catch(FileUpload\FilePartiallyUploadedException $ex) {
            $this->setValue(NULL);
            $this->errors[] = 'error_filePartiallyUploaded';
        } catch(FileUpload\NoFileUploadedException $ex) {
            $this->setValue(NULL);
        }
    }

    /**
     * @return string
     */
    public function getApiValue() {
        return GeneralUtility::locationHeaderUrl('/' . $this->getValue());
    }

    /**
     * @param FileUpload $uploadService
     */
    public function injectUploadService(FileUpload $uploadService) {
        $this->uploadService = $uploadService;
    }

    /**
     * @param UriBuilder $uriBuilder
     */
    public function injectUriBuilder(UriBuilder $uriBuilder) {
        $this->uriBuilder = $uriBuilder;
    }

    protected function validate() {
        if(count($this->errors) == 0) {
            parent::validate();
        }
    }


}
