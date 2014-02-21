<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Mato Ilic <info@matoilic.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace MatoIlic\T3Chimp\ViewHelpers\Form;

class NumberViewHelper extends AbstractFormFieldViewHelper {
    /**
     * @var string
     */
    protected $tagName = 'input';

    /**
     * Initialize the arguments.
     *
     * @return void
     */
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
        $this->registerTagAttribute('readonly', 'string', 'The readonly attribute of the input field');
        $this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', FALSE, 'f3-form-error');
        $this->registerUniversalTagAttributes();
    }

    /**
     * Renders the number field.
     *
     * @param boolean $required If the field is required or not
     * @param string $placeholder A string used as a placeholder for the value to enter
     * @param int $min The minimum value for the field
     * @param int $max The maximum value for the field
     * @param int $step Specifies the value granularity of the field’s value
     * @return string
     */
    public function render($required = FALSE, $placeholder = NULL, $min = NULL, $max = NULL, $step = NULL) {
        $name = $this->getName();
        $this->registerFieldNameForFormTokenGeneration($name);

        $this->tag->addAttribute('type', 'number');
        $this->tag->addAttribute('name', $name);

        $value = $this->getValue();

        if ($placeholder !== NULL) {
            $this->tag->addAttribute('placeholder', $placeholder);
        }

        if($min !== NULL) {
            $this->tag->addAttribute('min', $min);
        }

        if($max !== NULL) {
            $this->tag->addAttribute('max', $max);
        }

        if($step !== NULL) {
            $this->tag->addAttribute('step', $step);
        }

        if (!empty($value)) {
            $this->tag->addAttribute('value', $value);
        }

        if ($required) {
            $this->tag->addAttribute('required', 'required');
        }

        $this->setErrorClassAttribute();

        return $this->tag->render();
    }
}
