<?php

class MailChimp_Field_InterestGrouping extends MailChimp_Field_Checkboxes {
    public function getGroupingId() {
        return $this->definition['groupingId'];
    }

    public function getTag() {
        return $this->definition['name'];
    }
}
