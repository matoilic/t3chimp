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

class TextAreaViewHelper extends AbstractFormFieldViewHelper {
    /**
     * @var string
     */
    protected $tagName = 'textarea';

    /**
     * Initialize the arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerTagAttribute('rows', 'int', 'The number of rows of a text area');
        $this->registerTagAttribute('cols', 'int', 'The number of columns of a text area');
        $this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
        $this->registerTagAttribute('placeholder', 'string', 'The placeholder of the textarea');
        $this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', FALSE, 'f3-form-error');
        $this->registerUniversalTagAttributes();
    }

    /**
     * Renders the textarea.
     *
     * @param bool $required
     * @param string $placeholder
     * @return string
     * @api
     */
    public function render($required = FALSE, $placeholder = NULL) {
        $name = $this->getName();
        $this->registerFieldNameForFormTokenGeneration($name);

        $this->tag->forceClosingTag(TRUE);

        $this->tag->addAttribute('name', $name);

        if($required) {
            $this->tag->addAttribute('required', 'required');
        }

        if($placeholder != NULL) {
            $this->tag->addAttribute('placeholder', $placeholder);
        }

        $this->tag->setContent(htmlspecialchars($this->getValue()));

        $this->setErrorClassAttribute();

        return $this->tag->render();
    }
}
