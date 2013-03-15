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

class Tx_T3chimp_ViewHelpers_RenderPartialViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
    /**
     * @var Tx_Extbase_Object_ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param Tx_Extbase_Object_ObjectManagerInterface $manager
     */
    public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $manager) {
        $this->objectManager = $manager;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function render($name, array $arguments = array()) {
        /* @var Tx_Fluid_ViewHelpers_RenderViewHelper $renderer */
        $renderer = $this->objectManager->create('Tx_Fluid_ViewHelpers_RenderViewHelper');

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

        return $renderer->render(null, $name, $arguments);
    }
}
