<?php

/**
 * View Helper which creates a text field (<input type="text">).
 *
  * = Examples =
 *
 * <code title="Example">
 * <f:form.textfield name="myTextBox" value="default value" />
 * </code>
 * <output>
 * <input type="text" name="myTextBox" value="default value" />
 * </output>
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 */
class Tx_T3chimp_ViewHelpers_Form_TextfieldViewHelper extends Tx_T3chimp_ViewHelpers_Form_AbstractFormFieldViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'input';

	/**
	 * Initialize the arguments.
	 *
	 * @return void
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
		$this->registerTagAttribute('maxlength', 'int', 'The maxlength attribute of the input field (will not be validated)');
		$this->registerTagAttribute('readonly', 'string', 'The readonly attribute of the input field');
		$this->registerTagAttribute('size', 'int', 'The size of the input field');
		$this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', FALSE, 'f3-form-error');
		$this->registerUniversalTagAttributes();
	}

	/**
	 * Renders the textfield.
	 *
	 * @param boolean $required If the field is required or not
	 * @param string $type The field type, e.g. "text", "email", "url" etc.
	 * @param string $placeholder A string used as a placeholder for the value to enter
	 * @return string
	 * @author Robert Lemke <robert@typo3.org>
	 * @api
	 */
	public function render($required = NULL, $type = 'text', $placeholder = NULL) {
		$name = $this->getName();
		$this->registerFieldNameForFormTokenGeneration($name);

		$this->tag->addAttribute('type', $type);
		$this->tag->addAttribute('name', $name);

		$value = $this->getValue();

		if ($placeholder !== NULL) {
			$this->tag->addAttribute('placeholder', $placeholder);
		}

		if (!empty($value)) {
			$this->tag->addAttribute('value', $value);
		}

		if ($required !== NULL) {
			$this->tag->addAttribute('required', 'required');
		}

		$this->setErrorClassAttribute();

		return $this->tag->render();
	}

}

?>