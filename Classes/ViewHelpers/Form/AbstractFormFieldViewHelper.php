<?php

abstract class Tx_T3chimp_ViewHelpers_Form_AbstractFormFieldViewHelper extends Tx_Fluid_ViewHelpers_Form_AbstractFormFieldViewHelper {
    /**
     * @var MailChimp_Field
     */
    protected $field = null;

    /**
     * @var MailChimp_Form
     */
    private $form = null;

    /**
     * @return array
     */
    protected function getErrorsForProperty() {
        $errors = $this->getField()->getErrors();
        $localizedErrors = array();

        foreach($errors as $error) {
            $value = Tx_Extbase_Utility_Localization::translate($error, 'T3chimp');
            $localizedErrors[] = ($value !== null) ? $value : $this->getValue();
        }

        return $localizedErrors;
    }


    /**
     * @return MailChimp_Field
     * @throws Exception
     */
    protected function getField() {
        if($this->field === null) {
            $this->field = $this->getForm()->getField($this->arguments['property']);
            if($this->field === null) {
                throw new Exception('Unknown field ' . htmlentities($this->arguments['property']) . ' referenced in template');
            }
        }

        return $this->field;
    }

    /**
     * @return MailChimp_Form
     */
    protected function getForm() {
        if($this->form === null) {
            $this->form = $this->viewHelperVariableContainer->get('Tx_Fluid_ViewHelpers_FormViewHelper', 'formObject');
        }

        return $this->form;
    }

    protected function getName() {
        return $this->prefixFieldName($this->getField()->getName());
    }

    protected function getPropertyValue() {
        return $this->getValue();
    }

    protected function getValue() {
        $this->getField()->getValue();
    }
}
