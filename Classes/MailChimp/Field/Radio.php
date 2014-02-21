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

namespace MatoIlic\T3Chimp\MailChimp\Field;

use MatoIlic\T3Chimp\MailChimp\MailChimpException;
use MatoIlic\T3Chimp\MailChimp\Field\Helper\Choice;
use MatoIlic\T3Chimp\MailChimp\Form;

class Radio extends AbstractField {
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
     * @param Form $form
     */
    public function __construct(array $definition, Form $form) {
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
            $this->choices[] = new Choice($this, $choice);
            $this->validValues[] = $choice;
        }
    }

    /**
     * @param mixed $value
     * @throws MailChimpException
     */
    public function setValue($value) {
        if(!empty($value) && !in_array($value, $this->validValues)) {
            throw new MailChimpException('Invalid choice ' . htmlentities($value) . ' for field ' . $this->getName());
        }

        parent::setValue($value);
    }
}
