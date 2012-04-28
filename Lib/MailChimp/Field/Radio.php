<?php

class MailChimp_Field_Radio extends MailChimp_Field_Abstract {
    /**
     * @var array
     */
    protected $choices = array();

    /**
     * @var array
     */
    protected $validValues = array();

    /**
     * @param array $definition
     * @param MailChimp_Form $form
     */
    public function __construct(array $definition, MailChimp_Form $form) {
        parent::__construct($definition, $form);
        $this->initializeChoices($this->definition['choices']);
    }

    /**
     * @return array
     */
    public function getChoices() {
        return $this->choices;
    }

    /**
     * @param array $choices
     */
    protected function initializeChoices(array $choices) {
        foreach($choices as $choice) {
            $this->choices[] = new MailChimp_Field_Helper_Choice($this, $choice);
            $this->validValues[] = $choice;
        }
    }

    /**
     * @param mixed $value
     * @throws Exception
     */
    public function setValue($value) {
        if(!in_array($value, $this->validValues)) {
            throw new Exception('Invalid choice ' . htmlentities($value) . ' for field ' . $this->getName());
        }

        parent::setValue($value);
    }
}
