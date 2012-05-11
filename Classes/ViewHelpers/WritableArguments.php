<?php

/**
 * makes arguments writable
 */
class Tx_T3chimp_ViewHelpers_WritableArguments extends Tx_Fluid_Core_ViewHelper_Arguments {
    /**
     * @var array
     */
    protected $overridenValues = array();

    /**
     * @var Tx_Fluid_Core_ViewHelper_Arguments
     */
    protected $parent;

    public function __construct(Tx_Fluid_Core_ViewHelper_Arguments $parent) {
        $this->parent = $parent;
    }

    public function hasArgument($argumentName) {
        if($this->offsetExists($argumentName) && $this->overridenValues[$argumentName] !== null) {
            return true;
        }

        return $this->parent->hasArgument($argumentName);
    }

    public function offsetExists($key) {
        if(array_key_exists($key, $this->overridenValues)) {
            return true;
        }

        return $this->parent->offsetExists($key);
    }

    public function offsetGet($key) {
        if(array_key_exists($key, $this->overridenValues)) {
            return $this->overridenValues[$key];
        }

        return $this->parent->offsetGet($key);
    }

    public function offsetSet($key, $value) {
        $this->overridenValues[$key] = $value;
    }

    public function offsetUnset($key) {
        unset($this->overridenValues[$key]);
    }
}
