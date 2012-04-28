<?php

class Tx_T3chimp_ViewHelpers_RenderPartialViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
    /**
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function render($name, array $arguments = array()) {
        $renderer = new Tx_Fluid_ViewHelpers_RenderViewHelper();
        $renderer->setControllerContext($this->controllerContext);
        $renderer->setTemplateVariableContainer($this->templateVariableContainer);
        $renderer->setViewHelperVariableContainer($this->viewHelperVariableContainer);

        return $renderer->render(null, $name, $arguments);
    }
}
