<?php

class MailChimp_Field_Action extends MailChimp_Field_Radio {
    /**
     * @var array
     */
    protected static $_choices = array('Subscribe', 'Unsubscribe');

    /**
     * @param array $definition
     * @param MailChimp_Form $form
     */
    public function __construct(array $definition, MailChimp_Form $form) {
        $definition['choices'] = self::$_choices;
        $definition['req'] = true;
        parent::__construct($definition, $form);
    }

    public function getDefaultValue() {
        return self::$_choices[0];
    }

    public function getLabel() {
        return 'Action';
    }

    public function getTag() {
        return 'FORM_ACTION';
    }
}
