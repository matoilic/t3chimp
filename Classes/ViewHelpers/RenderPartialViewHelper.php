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

namespace MatoIlic\T3Chimp\ViewHelpers;

use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\ViewHelpers\RenderViewHelper;

class RenderPartialViewHelper extends AbstractViewHelper {
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param ObjectManagerInterface $manager
     */
    public function injectObjectManager(ObjectManagerInterface $manager) {
        $this->objectManager = $manager;
    }

    /**
     * @param string $name
     * @param mixed $arguments
     * @return string
     */
    public function render($name, $arguments = NULL) {
        if($arguments === NULL) $arguments = $this->templateVariableContainer->getAll(); //4.5.x compatibility

        /* @var RenderViewHelper $renderer */
        if(TYPO3_version < '6.1.0') {
            $renderer = $this->objectManager->create('TYPO3\\CMS\\Fluid\\ViewHelpers\\RenderViewHelper');
        } else {
            $renderer = $this->objectManager->get('TYPO3\\CMS\\Fluid\\ViewHelpers\\RenderViewHelper');
        }

        if(method_exists($this, 'setControllerContext')) { //4.5.x compatibility
            $renderer->setControllerContext($this->controllerContext);
            $renderer->setTemplateVariableContainer($this->templateVariableContainer);
            $renderer->setViewHelperVariableContainer($this->viewHelperVariableContainer);
        } else {
            $renderer->setRenderingContext($this->renderingContext);
            if($this->renderChildrenClosure !== NULL) {
                $renderer->setRenderChildrenClosure($this->renderChildrenClosure);
            }
        }

        return $renderer->render(NULL, $name, $arguments);
    }
}
