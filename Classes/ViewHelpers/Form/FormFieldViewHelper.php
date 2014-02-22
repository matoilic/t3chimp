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
use MatoIlic\T3Chimp\MailChimp\Form;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\ViewHelpers\RenderViewHelper;

class FormFieldViewHelper extends AbstractViewHelper {
    /**
     * @var Field
     */
    protected $field = NULL;

    /**
     * @var Form
     */
    private $form = NULL;

    protected function getField() {
        if($this->field === NULL) {
            $this->field = $this->getForm()->getField($this->arguments['property']);
        }

        return $this->field;
    }

    /**
     * @return Form
     */
    protected function getForm() {
        if($this->form === NULL) {
            $this->form = $this->viewHelperVariableContainer->get('TYPO3\\CMS\\Fluid\\ViewHelpers\\FormViewHelper', 'formObject');
        }

        return $this->form;
    }

    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerArgument('property', 'The field Tag', TRUE);
    }

    /**
     * @param Field $field
     */
    protected function markAsRendered(Field $field) {
        $fields = $this->viewHelperVariableContainer->get('MatoIlic\\T3Chimp\\ViewHelpers\\FormViewHelper', 'renderedProperties');
        $fields[] = $field->getName();
        $this->viewHelperVariableContainer->addOrUpdate('MatoIlic\\T3Chimp\\ViewHelpers\\FormViewHelper', 'renderedProperties', $fields);
    }

    public function render() {
        $renderer = new RenderViewHelper();
        $renderer->setRenderingContext($this->renderingContext);

        if($this->renderChildrenClosure !== NULL) {
            $renderer->setRenderChildrenClosure($this->renderChildrenClosure);
        }

        $this->markAsRendered($this->getField());

        return $renderer->render(NULL, $this->getField()->getTemplate(), array('field' => $this->getField()));
    }
}
