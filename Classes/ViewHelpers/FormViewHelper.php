<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Mato Ilic <info@matoilic.ch>
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

class Tx_T3chimp_ViewHelpers_FormViewHelper extends Tx_Fluid_ViewHelpers_FormViewHelper {
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerTagAttribute('pageType', 'Page type for AJAX requests', true);
    }


    /**
     * Render the form.
     *
     * @param string $action Target action
     * @param array $arguments Arguments
     * @param string $controller Target controller
     * @param string $extensionName Target Extension Name (without "tx_" prefix and no underscores). If NULL the current extension name is used
     * @param string $pluginName Target plugin. If empty, the current plugin name is used
     * @param integer $pageUid Target page uid
     * @param mixed $object Object to use for the form. Use in conjunction with the "property" attribute on the sub tags
     * @param boolean $noCache set this to disable caching for the target page. You should not need this.
     * @param boolean $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
     * @param string $section The anchor to be added to the action URI (only active if $actionUri is not set)
     * @param string $format The requested format (e.g. ".html") of the target page (only active if $actionUri is not set)
     * @param array $additionalParams additional action URI query parameters that won't be prefixed like $arguments (overrule $arguments) (only active if $actionUri is not set)
     * @param boolean $absolute If set, an absolute action URI is rendered (only active if $actionUri is not set)
     * @param boolean $addQueryString If set, the current query parameters will be kept in the action URI (only active if $actionUri is not set)
     * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the action URI. Only active if $addQueryString = TRUE and $actionUri is not set
     * @param string $fieldNamePrefix Prefix that will be added to all field names within this form. If not set the prefix will be tx_yourExtension_plugin
     * @param string $actionUri can be used to overwrite the "action" attribute of the form tag
     * @param string $objectName name of the object that is bound to this form. If this argument is not specified, the name attribute of this form is used to determine the FormObjectName
     * @return string rendered form
     */
    public function render($action = NULL, array $arguments = array(), $controller = NULL, $extensionName = NULL, $pluginName = NULL, $pageUid = NULL, $object = NULL, $noCache = FALSE, $noCacheHash = FALSE, $section = '', $format = '', array $additionalParams = array(), $absolute = FALSE, $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array(), $fieldNamePrefix = NULL, $actionUri = NULL, $objectName = NULL) {
        $this->viewHelperVariableContainer->add('Tx_T3chimp_ViewHelpers_FormViewHelper', 'renderedProperties', array());

        $this->arguments = new Tx_T3chimp_ViewHelpers_WritableArguments($this->arguments);

        $this->tag->addAttribute('id', 't3chimp-form-' . $object->getListId());

        return parent::render($action, $arguments, $controller, $extensionName, $pluginName, $pageUid, $object, $this->arguments['pageType'], $noCache, $noCacheHash, $section, $format, $additionalParams, $absolute, $addQueryString, $argumentsToBeExcludedFromQueryString, $fieldNamePrefix, $actionUri, $objectName);
    }
}
