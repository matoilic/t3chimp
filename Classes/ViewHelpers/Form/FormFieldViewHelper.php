<?php

class Tx_T3chimp_ViewHelpers_Form_FormFieldViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
    /**
     * @var MailChimp_Field
     */
    protected $field = null;

    /**
     * @var MailChimp_Form
     */
    private $form = null;

    protected function getField() {
        if($this->field === null) {
            $this->field = $this->getForm()->getField($this->arguments['property']);
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

    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerArgument('property', 'The field Tag', true);
    }

    /**
     * @param MailChimp_Field $field
     */
    protected function markAsRendered(MailChimp_Field $field) {
        $fields = $this->viewHelperVariableContainer->get('Tx_T3chimp_ViewHelpers_FormViewHelper', 'renderedProperties');
        $fields[] = $field->getName();
        $this->viewHelperVariableContainer->addOrUpdate('Tx_T3chimp_ViewHelpers_FormViewHelper', 'renderedProperties', $fields);
    }

    public function render() {
        $renderer = new Tx_Fluid_ViewHelpers_RenderViewHelper();
        $renderer->setControllerContext($this->controllerContext);
        $renderer->setTemplateVariableContainer($this->templateVariableContainer);
        $renderer->setViewHelperVariableContainer($this->viewHelperVariableContainer);

        $this->markAsRendered($this->getField());

        return $renderer->render(null, $this->getField()->getTemplate(), array('field' => $this->getField()));
    }
}
