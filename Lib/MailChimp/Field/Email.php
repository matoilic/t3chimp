<?php

class MailChimp_Field_Email extends MailChimp_Field_Text {
    protected function validate() {
        parent::validate();

        if( $this->getIsValid() &&
            !preg_match("/^([a-z0-9])([a-z0-9-_.]+)@([a-z0-9])([a-z0-9-_]+\.)+([a-z]{2,4})$/i", $this->getValue())) {
            $this->errors[] = 't3chimp.error.invalidEmail';
        }
    }
}
