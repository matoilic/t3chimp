<?php

########################################################################
# Extension Manager/Repository config file for ext "t3chimp".
#
# Auto generated 11-05-2012 10:10
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'T3Chimp',
	'description' => 'MailChimp plugin for Typo3',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.2.1',
	'dependencies' => 'extbase,fluid,t3jquery',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'alpha',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Mato Ilic',
	'author_email' => 'info@matoilic.ch',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.5.0-0.0.0',
			'extbase' => '1.3.0-0.0.0',
			'fluid' => '1.3.0-0.0.0',
			't3jquery' => '2.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:64:{s:16:"ext_autoload.php";s:4:"acb8";s:21:"ext_conf_template.txt";s:4:"bc1f";s:12:"ext_icon.gif";s:4:"8b14";s:17:"ext_localconf.php";s:4:"0f68";s:14:"ext_tables.php";s:4:"b65b";s:40:"Classes/Controller/BackendController.php";s:4:"cce7";s:46:"Classes/Controller/SubscriptionsController.php";s:4:"8a53";s:26:"Classes/Core/Bootstrap.php";s:4:"938a";s:29:"Classes/Service/MailChimp.php";s:4:"472b";s:61:"Classes/Service/MailChimp/EmailAlreadySubscribedException.php";s:4:"c5f8";s:63:"Classes/Service/MailChimp/EmailAlreadyUnsubscribedException.php";s:4:"9f79";s:53:"Classes/Service/MailChimp/EmailNotExistsException.php";s:4:"d8a7";s:39:"Classes/Service/MailChimp/Exception.php";s:4:"d5ed";s:60:"Classes/Service/MailChimp/ListAlreadySubscribedException.php";s:4:"a73a";s:56:"Classes/Service/MailChimp/ListInvalidOptionException.php";s:4:"585a";s:56:"Classes/Service/MailChimp/ListNotSubscribedException.php";s:4:"950d";s:28:"Classes/Session/Provider.php";s:4:"b602";s:38:"Classes/ViewHelpers/FormViewHelper.php";s:4:"e153";s:47:"Classes/ViewHelpers/RenderPartialViewHelper.php";s:4:"0402";s:41:"Classes/ViewHelpers/WritableArguments.php";s:4:"b9ad";s:56:"Classes/ViewHelpers/Form/AbstractFormFieldViewHelper.php";s:4:"54fb";s:47:"Classes/ViewHelpers/Form/CheckboxViewHelper.php";s:4:"3419";s:45:"Classes/ViewHelpers/Form/ErrorsViewHelper.php";s:4:"8c3f";s:48:"Classes/ViewHelpers/Form/FormFieldViewHelper.php";s:4:"f47d";s:44:"Classes/ViewHelpers/Form/RadioViewHelper.php";s:4:"3873";s:54:"Classes/ViewHelpers/Form/RemainingFieldsViewHelper.php";s:4:"9553";s:45:"Classes/ViewHelpers/Form/SelectViewHelper.php";s:4:"cd26";s:48:"Classes/ViewHelpers/Form/TextfieldViewHelper.php";s:4:"5544";s:40:"Configuration/FlexForms/Subscription.xml";s:4:"380e";s:34:"Configuration/TypoScript/setup.txt";s:4:"336b";s:48:"Configuration/TypoScript/DefaultStyles/setup.txt";s:4:"7fbc";s:19:"Lib/MCAPI.class.php";s:4:"9b81";s:24:"Lib/SettingsProvider.php";s:4:"c7dc";s:23:"Lib/MailChimp/Field.php";s:4:"bedc";s:22:"Lib/MailChimp/Form.php";s:4:"73ea";s:32:"Lib/MailChimp/Field/Abstract.php";s:4:"d4ef";s:30:"Lib/MailChimp/Field/Action.php";s:4:"08f2";s:34:"Lib/MailChimp/Field/Checkboxes.php";s:4:"a15f";s:32:"Lib/MailChimp/Field/Dropdown.php";s:4:"0bc3";s:29:"Lib/MailChimp/Field/Email.php";s:4:"ce84";s:40:"Lib/MailChimp/Field/InterestGrouping.php";s:4:"d85e";s:29:"Lib/MailChimp/Field/Radio.php";s:4:"34f4";s:28:"Lib/MailChimp/Field/Text.php";s:4:"f27b";s:37:"Lib/MailChimp/Field/Helper/Choice.php";s:4:"a52a";s:42:"Lib/MailChimp/Field/Helper/MultiChoice.php";s:4:"d99f";s:40:"Resources/Private/Language/locallang.xml";s:4:"def5";s:48:"Resources/Private/Language/locallang_backend.xml";s:4:"0b0d";s:43:"Resources/Private/Partials/ActionField.html";s:4:"d610";s:47:"Resources/Private/Partials/CheckboxesField.html";s:4:"a351";s:45:"Resources/Private/Partials/DropdownField.html";s:4:"9957";s:42:"Resources/Private/Partials/EmailField.html";s:4:"0e78";s:38:"Resources/Private/Partials/Errors.html";s:4:"6245";s:36:"Resources/Private/Partials/Form.html";s:4:"8708";s:53:"Resources/Private/Partials/InterestGroupingField.html";s:4:"f87f";s:42:"Resources/Private/Partials/RadioField.html";s:4:"4f4a";s:41:"Resources/Private/Partials/TextField.html";s:4:"47ee";s:46:"Resources/Private/Templates/Backend/Index.html";s:4:"2292";s:52:"Resources/Private/Templates/Subscriptions/Index.html";s:4:"d624";s:54:"Resources/Private/Templates/Subscriptions/Process.html";s:4:"b557";s:57:"Resources/Private/Templates/Subscriptions/Subscribed.html";s:4:"75fe";s:59:"Resources/Private/Templates/Subscriptions/Unsubscribed.html";s:4:"c274";s:35:"Resources/Public/Images/loading.gif";s:4:"e423";s:39:"Resources/Public/JavaScripts/t3chimp.js";s:4:"60d8";s:40:"Resources/Public/Stylesheets/t3chimp.css";s:4:"9864";}',
	'suggests' => array(
	),
);

?>