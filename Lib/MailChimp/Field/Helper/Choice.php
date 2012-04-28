<?php

class MailChimp_Field_Helper_Choice {
    /**
     * @var string
     */
    protected $id;

    /**
     * @var MailChimp_Field
     */
    protected $parent;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param MailChimp_Field $parent
     * @param mixed $value
     */
    public function __construct(MailChimp_Field $parent, $value) {
        $this->parent = $parent;
        $this->value = $value;
        $this->id = strtolower(str_replace(' ', '-', $value));
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->parent->getId() . '-' . $this->id;
    }

    public function getLocalizedValue() {
        $value = Tx_Extbase_Utility_Localization::translate(
            't3chimp: ' . $this->getValue(),
            'T3chimp'
        );

        return ($value !== null) ? $value : $this->getValue();
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    public function getIsSelected() {
        return $this->value == $this->parent->getValue();
    }
}
