<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3chimp".
 *
 * Auto generated 24-02-2014 19:54
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'T3Chimp MailChimp Integration',
	'description' => 'Integrates MailChimp into Typo3.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '2.0.1',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 1,
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
			'typo3' => '6.1.0-6.1.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:135:{s:9:"CHANGELOG";s:4:"a4cc";s:16:"ext_autoload.php";s:4:"4fe5";s:21:"ext_conf_template.txt";s:4:"78e6";s:12:"ext_icon.gif";s:4:"8b14";s:17:"ext_localconf.php";s:4:"3fac";s:14:"ext_tables.php";s:4:"8e49";s:14:"ext_tables.sql";s:4:"05be";s:24:"ext_typoscript_setup.txt";s:4:"39a0";s:17:"generate_autoload";s:4:"a911";s:7:"GPL.txt";s:4:"c78c";s:6:"README";s:4:"55f9";s:25:"Classes/legacy_naming.php";s:4:"8b09";s:40:"Classes/Controller/BackendController.php";s:4:"a067";s:46:"Classes/Controller/SubscriptionsController.php";s:4:"5ec3";s:26:"Classes/Core/Bootstrap.php";s:4:"2ddc";s:37:"Classes/Domain/Model/FrontendUser.php";s:4:"2be8";s:47:"Classes/Domain/Repository/CountryRepository.php";s:4:"7c3f";s:52:"Classes/Domain/Repository/FrontendUserRepository.php";s:4:"36c7";s:22:"Classes/Hook/Cache.php";s:4:"7432";s:27:"Classes/MailChimp/Field.php";s:4:"4bbd";s:26:"Classes/MailChimp/Form.php";s:4:"b76c";s:34:"Classes/MailChimp/MailChimpApi.php";s:4:"d973";s:40:"Classes/MailChimp/MailChimpException.php";s:4:"7eb6";s:41:"Classes/MailChimp/Field/AbstractField.php";s:4:"16c2";s:34:"Classes/MailChimp/Field/Action.php";s:4:"5754";s:35:"Classes/MailChimp/Field/Address.php";s:4:"d67e";s:36:"Classes/MailChimp/Field/Birthday.php";s:4:"c7e5";s:38:"Classes/MailChimp/Field/Checkboxes.php";s:4:"65c9";s:32:"Classes/MailChimp/Field/Date.php";s:4:"38a1";s:36:"Classes/MailChimp/Field/Dropdown.php";s:4:"4ef8";s:33:"Classes/MailChimp/Field/Email.php";s:4:"d37c";s:39:"Classes/MailChimp/Field/EmailFormat.php";s:4:"9bcd";s:36:"Classes/MailChimp/Field/Imageurl.php";s:4:"d047";s:44:"Classes/MailChimp/Field/InterestGrouping.php";s:4:"8195";s:34:"Classes/MailChimp/Field/Number.php";s:4:"0946";s:40:"Classes/MailChimp/Field/PatternBased.php";s:4:"d2e6";s:33:"Classes/MailChimp/Field/Phone.php";s:4:"f394";s:33:"Classes/MailChimp/Field/Radio.php";s:4:"9da1";s:32:"Classes/MailChimp/Field/Text.php";s:4:"3470";s:31:"Classes/MailChimp/Field/Url.php";s:4:"635e";s:31:"Classes/MailChimp/Field/Zip.php";s:4:"44c5";s:41:"Classes/MailChimp/Field/Helper/Choice.php";s:4:"dd3d";s:48:"Classes/MailChimp/Field/Helper/CountryChoice.php";s:4:"34f1";s:46:"Classes/MailChimp/Field/Helper/MultiChoice.php";s:4:"34f4";s:44:"Classes/MailChimp/MailChimpApi/Campaigns.php";s:4:"e946";s:40:"Classes/MailChimp/MailChimpApi/Ecomm.php";s:4:"0a54";s:40:"Classes/MailChimp/MailChimpApi/Error.php";s:4:"7dcd";s:42:"Classes/MailChimp/MailChimpApi/Folders.php";s:4:"17b3";s:42:"Classes/MailChimp/MailChimpApi/Gallery.php";s:4:"8e43";s:41:"Classes/MailChimp/MailChimpApi/Helper.php";s:4:"4fd3";s:40:"Classes/MailChimp/MailChimpApi/Lists.php";s:4:"090b";s:41:"Classes/MailChimp/MailChimpApi/Mobile.php";s:4:"48b2";s:45:"Classes/MailChimp/MailChimpApi/Neapolitan.php";s:4:"e72d";s:42:"Classes/MailChimp/MailChimpApi/Reports.php";s:4:"a82d";s:44:"Classes/MailChimp/MailChimpApi/Templates.php";s:4:"8937";s:40:"Classes/MailChimp/MailChimpApi/Users.php";s:4:"8a8f";s:38:"Classes/MailChimp/MailChimpApi/Vip.php";s:4:"9705";s:35:"Classes/Provider/FlexFormValues.php";s:4:"c849";s:28:"Classes/Provider/Session.php";s:4:"8aa6";s:29:"Classes/Provider/Settings.php";s:4:"378b";s:26:"Classes/Scheduler/Base.php";s:4:"7120";s:29:"Classes/Scheduler/Request.php";s:4:"30c8";s:56:"Classes/Scheduler/SyncBackFromMailChimpFieldProvider.php";s:4:"dbd3";s:47:"Classes/Scheduler/SyncBackFromMailChimpTask.php";s:4:"0b8c";s:50:"Classes/Scheduler/SyncToMailChimpFieldProvider.php";s:4:"414c";s:41:"Classes/Scheduler/SyncToMailChimpTask.php";s:4:"dc08";s:30:"Classes/Service/FileUpload.php";s:4:"47b7";s:29:"Classes/Service/MailChimp.php";s:4:"dcad";s:61:"Classes/Service/FileUpload/FilePartiallyUploadedException.php";s:4:"3dd6";s:52:"Classes/Service/FileUpload/FileTooLargeException.php";s:4:"9896";s:56:"Classes/Service/FileUpload/InvalidExtensionException.php";s:4:"1611";s:54:"Classes/Service/FileUpload/NoFileUploadedException.php";s:4:"aa4f";s:38:"Classes/ViewHelpers/FormViewHelper.php";s:4:"152f";s:47:"Classes/ViewHelpers/RenderPartialViewHelper.php";s:4:"df5f";s:41:"Classes/ViewHelpers/WritableArguments.php";s:4:"95b7";s:56:"Classes/ViewHelpers/Form/AbstractFormFieldViewHelper.php";s:4:"4b55";s:47:"Classes/ViewHelpers/Form/CheckboxViewHelper.php";s:4:"9fba";s:45:"Classes/ViewHelpers/Form/ErrorsViewHelper.php";s:4:"d269";s:48:"Classes/ViewHelpers/Form/FormFieldViewHelper.php";s:4:"8a28";s:45:"Classes/ViewHelpers/Form/NumberViewHelper.php";s:4:"bb8a";s:44:"Classes/ViewHelpers/Form/RadioViewHelper.php";s:4:"f246";s:54:"Classes/ViewHelpers/Form/RemainingFieldsViewHelper.php";s:4:"963d";s:45:"Classes/ViewHelpers/Form/SelectViewHelper.php";s:4:"fba6";s:47:"Classes/ViewHelpers/Form/TextAreaViewHelper.php";s:4:"4866";s:48:"Classes/ViewHelpers/Form/TextfieldViewHelper.php";s:4:"e75b";s:45:"Classes/ViewHelpers/Form/UploadViewHelper.php";s:4:"d095";s:59:"Classes/ViewHelpers/Form/Address/AddressFieldViewHelper.php";s:4:"ea1b";s:59:"Classes/ViewHelpers/Form/Address/AddressLine1ViewHelper.php";s:4:"e3d4";s:59:"Classes/ViewHelpers/Form/Address/AddressLine2ViewHelper.php";s:4:"3d1b";s:51:"Classes/ViewHelpers/Form/Address/CityViewHelper.php";s:4:"382a";s:58:"Classes/ViewHelpers/Form/Address/CountryListViewHelper.php";s:4:"0851";s:52:"Classes/ViewHelpers/Form/Address/StateViewHelper.php";s:4:"69f5";s:54:"Classes/ViewHelpers/Form/Address/ZipCodeViewHelper.php";s:4:"36c7";s:51:"Classes/ViewHelpers/Form/Birthday/DayViewHelper.php";s:4:"bfda";s:53:"Classes/ViewHelpers/Form/Birthday/MonthViewHelper.php";s:4:"b724";s:40:"Configuration/FlexForms/Subscription.xml";s:4:"6840";s:38:"Configuration/TypoScript/constants.txt";s:4:"206d";s:34:"Configuration/TypoScript/setup.txt";s:4:"c0da";s:48:"Configuration/TypoScript/DefaultStyles/setup.txt";s:4:"1877";s:40:"Resources/Private/Language/locallang.xml";s:4:"0db2";s:48:"Resources/Private/Language/locallang_backend.xml";s:4:"2391";s:43:"Resources/Private/Language/Countries/de.php";s:4:"0ee3";s:48:"Resources/Private/Language/Countries/default.php";s:4:"c397";s:43:"Resources/Private/Partials/ActionField.html";s:4:"fd0d";s:44:"Resources/Private/Partials/AddressField.html";s:4:"3be4";s:45:"Resources/Private/Partials/BirthdayField.html";s:4:"1be7";s:47:"Resources/Private/Partials/CheckboxesField.html";s:4:"63f3";s:41:"Resources/Private/Partials/DateField.html";s:4:"dc71";s:45:"Resources/Private/Partials/DropdownField.html";s:4:"14d4";s:42:"Resources/Private/Partials/EmailField.html";s:4:"b685";s:48:"Resources/Private/Partials/EmailFormatField.html";s:4:"1389";s:38:"Resources/Private/Partials/Errors.html";s:4:"6245";s:36:"Resources/Private/Partials/Form.html";s:4:"96d8";s:45:"Resources/Private/Partials/ImageurlField.html";s:4:"3728";s:53:"Resources/Private/Partials/InterestGroupingField.html";s:4:"4026";s:43:"Resources/Private/Partials/NumberField.html";s:4:"8067";s:42:"Resources/Private/Partials/PhoneField.html";s:4:"98d8";s:42:"Resources/Private/Partials/RadioField.html";s:4:"4915";s:41:"Resources/Private/Partials/TextField.html";s:4:"2fff";s:40:"Resources/Private/Partials/UrlField.html";s:4:"7a7d";s:40:"Resources/Private/Partials/ZipField.html";s:4:"3f35";s:46:"Resources/Private/Templates/Backend/Index.html";s:4:"aab4";s:51:"Resources/Private/Templates/Subscriptions/Edit.html";s:4:"f861";s:52:"Resources/Private/Templates/Subscriptions/Index.html";s:4:"f861";s:54:"Resources/Private/Templates/Subscriptions/Process.html";s:4:"db4d";s:57:"Resources/Private/Templates/Subscriptions/Subscribed.html";s:4:"75fe";s:59:"Resources/Private/Templates/Subscriptions/Unsubscribed.html";s:4:"c274";s:35:"Resources/Public/Images/loading.gif";s:4:"e423";s:43:"Resources/Public/JavaScripts/jquery.form.js";s:4:"fbe0";s:47:"Resources/Public/JavaScripts/jquery.form.min.js";s:4:"66d5";s:38:"Resources/Public/JavaScripts/jquery.js";s:4:"2665";s:42:"Resources/Public/JavaScripts/jquery.min.js";s:4:"0187";s:39:"Resources/Public/JavaScripts/t3chimp.js";s:4:"80c3";s:40:"Resources/Public/Stylesheets/t3chimp.css";s:4:"9864";s:14:"doc/manual.sxw";s:4:"d2e7";}',
	'suggests' => array(
	),
);

?>