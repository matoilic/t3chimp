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

namespace MatoIlic\T3Chimp\ViewHelpers\Form;

use MatoIlic\T3Chimp\MailChimp\Field;
use MatoIlic\T3Chimp\ViewHelpers\WritableArguments;

class RemainingFieldsViewHelper extends FormFieldViewHelper {
    public function render() {
        if($this->viewHelperVariableContainer->exists('MatoIlic\\T3Chimp\\ViewHelpers\\FormViewHelper', 'renderedProperties')) {
            $renderedFields = $this->viewHelperVariableContainer->get('MatoIlic\\T3Chimp\\ViewHelpers\\FormViewHelper', 'renderedProperties');
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
     * @param Field $field
     * @return string
     */
    protected function renderField($field) {
        $arguments = new WritableArguments(array('property' => $field->getName()));
        $renderer = new FormFieldViewHelper();
        $renderer->setRenderingContext($this->renderingContext);

        if($this->renderChildrenClosure !== NULL) {
            $renderer->setRenderChildrenClosure($this->renderChildrenClosure);
        }

        $renderer->setArguments($arguments->toArray());

        return $renderer->render();
    }
}
