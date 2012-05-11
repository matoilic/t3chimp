<?php

########################################################################
# Extension Manager/Repository config file for ext "t3chimp".
#
# Auto generated 01-05-2012 22:46
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'T3Chimp',
	'description' => 'Mailchimp plugin for Typo3',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '0.2.0',
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
	'_md5_values_when_last_written' => 'a:58:{s:16:"ext_autoload.php";s:4:"642f";s:21:"ext_conf_template.txt";s:4:"604b";s:17:"ext_localconf.php";s:4:"a468";s:14:"ext_tables.php";s:4:"4d0e";s:46:"Classes/Controller/SubscriptionsController.php";s:4:"b036";s:26:"Classes/Core/Bootstrap.php";s:4:"e86e";s:29:"Classes/Service/MailChimp.php";s:4:"41af";s:61:"Classes/Service/MailChimp/EmailAlreadySubscribedException.php";s:4:"7be0";s:63:"Classes/Service/MailChimp/EmailAlreadyUnsubscribedException.php";s:4:"716d";s:53:"Classes/Service/MailChimp/EmailNotExistsException.php";s:4:"5c53";s:39:"Classes/Service/MailChimp/Exception.php";s:4:"36c8";s:60:"Classes/Service/MailChimp/ListAlreadySubscribedException.php";s:4:"f3b5";s:56:"Classes/Service/MailChimp/ListInvalidOptionException.php";s:4:"8560";s:56:"Classes/Service/MailChimp/ListNotSubscribedException.php";s:4:"1891";s:38:"Classes/ViewHelpers/FormViewHelper.php";s:4:"3afe";s:47:"Classes/ViewHelpers/RenderPartialViewHelper.php";s:4:"1619";s:41:"Classes/ViewHelpers/WritableArguments.php";s:4:"26ca";s:56:"Classes/ViewHelpers/Form/AbstractFormFieldViewHelper.php";s:4:"c393";s:47:"Classes/ViewHelpers/Form/CheckboxViewHelper.php";s:4:"b528";s:45:"Classes/ViewHelpers/Form/ErrorsViewHelper.php";s:4:"776a";s:48:"Classes/ViewHelpers/Form/FormFieldViewHelper.php";s:4:"85a8";s:44:"Classes/ViewHelpers/Form/RadioViewHelper.php";s:4:"0268";s:54:"Classes/ViewHelpers/Form/RemainingFieldsViewHelper.php";s:4:"f071";s:45:"Classes/ViewHelpers/Form/SelectViewHelper.php";s:4:"d5c8";s:48:"Classes/ViewHelpers/Form/TextfieldViewHelper.php";s:4:"3022";s:40:"Configuration/FlexForms/Subscription.xml";s:4:"380e";s:34:"Configuration/TypoScript/setup.txt";s:4:"1509";s:48:"Configuration/TypoScript/DefaultStyles/setup.txt";s:4:"e453";s:19:"Lib/MCAPI.class.php";s:4:"9b81";s:24:"Lib/SettingsProvider.php";s:4:"87e3";s:23:"Lib/MailChimp/Field.php";s:4:"7b3a";s:22:"Lib/MailChimp/Form.php";s:4:"b4e7";s:32:"Lib/MailChimp/Field/Abstract.php";s:4:"41c9";s:30:"Lib/MailChimp/Field/Action.php";s:4:"afc9";s:34:"Lib/MailChimp/Field/Checkboxes.php";s:4:"9952";s:32:"Lib/MailChimp/Field/Dropdown.php";s:4:"0f2b";s:29:"Lib/MailChimp/Field/Email.php";s:4:"08b2";s:40:"Lib/MailChimp/Field/InterestGrouping.php";s:4:"d0cf";s:29:"Lib/MailChimp/Field/Radio.php";s:4:"0a08";s:28:"Lib/MailChimp/Field/Text.php";s:4:"a386";s:37:"Lib/MailChimp/Field/Helper/Choice.php";s:4:"13ba";s:42:"Lib/MailChimp/Field/Helper/MultiChoice.php";s:4:"cb33";s:40:"Resources/Private/Language/locallang.xml";s:4:"def5";s:43:"Resources/Private/Partials/ActionField.html";s:4:"665b";s:47:"Resources/Private/Partials/CheckboxesField.html";s:4:"4139";s:45:"Resources/Private/Partials/DropdownField.html";s:4:"d5fa";s:42:"Resources/Private/Partials/EmailField.html";s:4:"69db";s:38:"Resources/Private/Partials/Errors.html";s:4:"6245";s:36:"Resources/Private/Partials/Form.html";s:4:"0faf";s:53:"Resources/Private/Partials/InterestGroupingField.html";s:4:"f87f";s:42:"Resources/Private/Partials/RadioField.html";s:4:"b16a";s:41:"Resources/Private/Partials/TextField.html";s:4:"310b";s:52:"Resources/Private/Templates/Subscriptions/Index.html";s:4:"b557";s:54:"Resources/Private/Templates/Subscriptions/Process.html";s:4:"b557";s:57:"Resources/Private/Templates/Subscriptions/Subscribed.html";s:4:"75fe";s:59:"Resources/Private/Templates/Subscriptions/Unsubscribed.html";s:4:"c274";s:39:"Resources/Public/JavaScripts/t3chimp.js";s:4:"241a";s:40:"Resources/Public/Stylesheets/t3chimp.css";s:4:"52c9";}',
	'suggests' => array(
	),
);

?>