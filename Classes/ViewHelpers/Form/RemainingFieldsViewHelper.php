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

class Tx_T3chimp_ViewHelpers_Form_RemainingFieldsViewHelper extends Tx_T3chimp_ViewHelpers_Form_FormFieldViewHelper {
    public function render() {
        if($this->viewHelperVariableContainer->exists('Tx_T3chimp_ViewHelpers_FormViewHelper', 'renderedProperties')) {
            $renderedFields = $this->viewHelperVariableContainer->get('Tx_T3chimp_ViewHelpers_FormViewHelper', 'renderedProperties');
        } else {
            $renderedFields = array();
        }

        $content = '';

        foreach($this->getForm()->getFields() as $field) {
            if(!in_array($field->getName(), $renderedFields)) {
                $content .= $this->renderField($field);
            }
        }

        return $content;
    }

    /**
     * @param Tx_T3chimp_MailChimp_Field $field
     * @return string
     */
    protected function renderField($field) {
        $arguments = new Tx_T3chimp_ViewHelpers_WritableArguments(array('property' => $field->getName()));
        $renderer = new Tx_T3chimp_ViewHelpers_Form_FormFieldViewHelper();

        if(method_exists($this, 'setControllerContext')) { //4.5.x compatibility
            $renderer->setControllerContext($this->controllerContext);
            $renderer->setTemplateVariableContainer($this->templateVariableContainer);
            $renderer->setViewHelperVariableContainer($this->viewHelperVariableContainer);
            $renderer->setArguments($arguments);
        } else {
            $renderer->setRenderingContext($this->renderingContext);
            if($this->renderChildrenClosure !== NULL) {
                $renderer->setRenderChildrenClosure($this->renderChildrenClosure);
            }
            $renderer->setArguments($arguments->toArray());
        }

        return $renderer->render();
    }
}
