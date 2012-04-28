<?php

class MailChimp_Field_Checkboxes extends MailChimp_Field_Radio {
    public function getDefaultValue() {
        return array();
    }


    /**
     * @param array $choices
     */
    protected function initializeChoices(array $choices) {
        foreach($choices as $choice) {
            $this->choices[] = new MailChimp_Field_Helper_MultiChoice($this, $choice['name']);
            $this->validValues[] = $choice['name'];
        }
    }

    /**
     * @param mixed $value
     * @throws Exception
     */
    public function setValue($value) {
        if($value === null || strlen($value) == 0) {
            $this->value = array();
            return;
        }

        if(!is_array($value)) {
            throw new Exception('Value for checkboxes field must be an array');
        }

        foreach($value as $selection) {
            if(!in_array($selection, $this->validValues)) {
                throw new Exception('Invalid choice ' . htmlentities($selection) . ' for field ' . $this->getName());
            }
        }

        $this->value = $value;
        $this->resetValidation();
    }


    /**
     * @return void
     */
    protected function validate() {
        $this->isValidated = true;
        $value = $this->getValue();
        if($this->getIsRequired() && count($value) == 0) {
            $this->errors[] = 't3chimp.error.required';
        }
    }
}
