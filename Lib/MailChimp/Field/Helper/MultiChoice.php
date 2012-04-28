<?php

class MailChimp_Field_Helper_MultiChoice extends MailChimp_Field_Helper_Choice {
    /**
     * @return bool
     */
    public function getIsSelected() {
        return in_array($this->getValue(), $this->parent->getValue());
    }
}
