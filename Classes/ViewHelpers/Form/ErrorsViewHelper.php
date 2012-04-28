<?php

class Tx_T3chimp_ViewHelpers_Form_ErrorsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
    /**
     * @var MailChimp_Field
     */
    protected $field = null;

    /**
     * @var MailChimp_Form
     */
    private $form = null;

    /**
     * @param string $property
     * @return MailChimp_Field
     * @throws Exception
     */
    protected function getField($property) {
        if($this->field === null) {
            $this->field = $this->getForm()->getField($property);
            if($this->field === null) {
                throw new Exception('Unknown field ' . htmlentities($property) . ' referenced in template');
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

    /**
     * @param string $property
     * @return string
     */
    public function render($property) {
        $errors = $this->getField($property)->getErrors();

        if(count($errors) > 0) {
            $renderer = new Tx_Fluid_ViewHelpers_RenderViewHelper();
            $renderer->setControllerContext($this->controllerContext);
            $renderer->setTemplateVariableContainer($this->templateVariableContainer);
            $renderer->setViewHelperVariableContainer($this->viewHelperVariableContainer);

            return $renderer->render(null, 'Errors', array('errors' => $errors));
        }

        return '';
    }
}
