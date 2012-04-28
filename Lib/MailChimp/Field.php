<?php

interface MailChimp_Field
{
    /**
     * @abstract
     * @return mixed
     */
    public function getDefaultValue();

    /**
     * @abstract
     * @return array
     */
    public function getErrors();

    /**
     * @abstract
     * @return string
     */
    public function getId();

    /**
     * @abstract
     * @return boolean
     */
    public function getIsRequired();

    /**
     * @abstract
     * @return boolean
     */
    public function getIsValid();

    /**
     * @abstract
     * @return string
     */
    public function getLabel();

    /**
     * @abstract
     * @return string
     */
    public function getName();

    /**
     * @abstract
     * @return string
     */
    public function getTag();

    /**
     * @abstract
     * @return string
     */
    public function getTemplate();

    /**
     * @abstract
     * @return mixed
     */
    public function getValue();

    /**
     * @abstract
     * @param mixed $value
     * @return void
     */
    public function setValue($value);
}
