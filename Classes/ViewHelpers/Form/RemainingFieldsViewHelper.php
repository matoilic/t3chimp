<?php

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
     * @param MailChimp_Field $field
     * @return string
     */
    protected function renderField($field) {
        $arguments = new Tx_Fluid_Core_ViewHelper_Arguments(array('property' => $field->getName()));
        $renderer = new Tx_T3chimp_ViewHelpers_Form_FormFieldViewHelper();
        $renderer->setControllerContext($this->controllerContext);
        $renderer->setTemplateVariableContainer($this->templateVariableContainer);
        $renderer->setViewHelperVariableContainer($this->viewHelperVariableContainer);
        $renderer->setArguments($arguments);

        return $renderer->render();
    }
}
