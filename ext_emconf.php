<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "t3chimp".
 *
 * Auto generated 15-03-2013 23:20
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
	'version' => '1.0.2',
	'dependencies' => 'extbase,fluid,static_info_tables',
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
			'typo3' => '4.5.0-6.0.99',
			'extbase' => '1.3.0-0.0.0',
			'fluid' => '1.3.0-0.0.0',
			'static_info_tables' => '2.3.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:123:{s:16:"ext_autoload.php";s:4:"d2e0";s:21:"ext_conf_template.txt";s:4:"78e6";s:12:"ext_icon.gif";s:4:"8b14";s:17:"ext_localconf.php";s:4:"3363";s:14:"ext_tables.php";s:4:"6160";s:14:"ext_tables.sql";s:4:"05be";s:24:"ext_typoscript_setup.txt";s:4:"5e03";s:7:"GPL.txt";s:4:"c78c";s:6:"README";s:4:"a738";s:48:"Classes/Command/MaintenanceCommandController.php";s:4:"1520";s:40:"Classes/Controller/BackendController.php";s:4:"31ba";s:46:"Classes/Controller/SubscriptionsController.php";s:4:"a72d";s:26:"Classes/Core/Bootstrap.php";s:4:"e364";s:32:"Classes/Domain/Model/Country.php";s:4:"15b1";s:37:"Classes/Domain/Model/FrontendUser.php";s:4:"87f5";s:47:"Classes/Domain/Repository/CountryRepository.php";s:4:"0ea4";s:52:"Classes/Domain/Repository/FrontendUserRepository.php";s:4:"5d61";s:22:"Classes/Hook/Cache.php";s:4:"1c8f";s:25:"Classes/MailChimp/Api.php";s:4:"963a";s:31:"Classes/MailChimp/Exception.php";s:4:"f281";s:27:"Classes/MailChimp/Field.php";s:4:"441a";s:26:"Classes/MailChimp/Form.php";s:4:"feed";s:36:"Classes/MailChimp/Field/Abstract.php";s:4:"261d";s:34:"Classes/MailChimp/Field/Action.php";s:4:"da7f";s:35:"Classes/MailChimp/Field/Address.php";s:4:"650d";s:36:"Classes/MailChimp/Field/Birthday.php";s:4:"1508";s:38:"Classes/MailChimp/Field/Checkboxes.php";s:4:"ae41";s:32:"Classes/MailChimp/Field/Date.php";s:4:"58ea";s:36:"Classes/MailChimp/Field/Dropdown.php";s:4:"2a8a";s:33:"Classes/MailChimp/Field/Email.php";s:4:"f468";s:36:"Classes/MailChimp/Field/Imageurl.php";s:4:"15a7";s:44:"Classes/MailChimp/Field/InterestGrouping.php";s:4:"87e1";s:34:"Classes/MailChimp/Field/Number.php";s:4:"7db9";s:40:"Classes/MailChimp/Field/PatternBased.php";s:4:"95a8";s:33:"Classes/MailChimp/Field/Phone.php";s:4:"534c";s:33:"Classes/MailChimp/Field/Radio.php";s:4:"d82b";s:32:"Classes/MailChimp/Field/Text.php";s:4:"baca";s:31:"Classes/MailChimp/Field/Url.php";s:4:"b381";s:31:"Classes/MailChimp/Field/Zip.php";s:4:"88da";s:41:"Classes/MailChimp/Field/Helper/Choice.php";s:4:"dfd2";s:48:"Classes/MailChimp/Field/Helper/CountryChoice.php";s:4:"ebb8";s:46:"Classes/MailChimp/Field/Helper/MultiChoice.php";s:4:"90c2";s:35:"Classes/Provider/FlexFormValues.php";s:4:"d683";s:28:"Classes/Provider/Session.php";s:4:"c09e";s:29:"Classes/Provider/Settings.php";s:4:"7047";s:26:"Classes/Scheduler/Base.php";s:4:"a14b";s:29:"Classes/Scheduler/Request.php";s:4:"70de";s:56:"Classes/Scheduler/SyncBackFromMailChimpFieldProvider.php";s:4:"c3ea";s:47:"Classes/Scheduler/SyncBackFromMailChimpTask.php";s:4:"6bad";s:50:"Classes/Scheduler/SyncToMailChimpFieldProvider.php";s:4:"8789";s:41:"Classes/Scheduler/SyncToMailChimpTask.php";s:4:"e6b7";s:30:"Classes/Service/FileUpload.php";s:4:"c5b7";s:29:"Classes/Service/MailChimp.php";s:4:"3ae9";s:61:"Classes/Service/FileUpload/FilePartiallyUploadedException.php";s:4:"7591";s:52:"Classes/Service/FileUpload/FileTooLargeException.php";s:4:"585f";s:56:"Classes/Service/FileUpload/InvalidExtensionException.php";s:4:"4e37";s:54:"Classes/Service/FileUpload/NoFileUploadedException.php";s:4:"671e";s:56:"Classes/Service/MailChimp/AlreadySubscribedException.php";s:4:"70dd";s:61:"Classes/Service/MailChimp/EmailAlreadySubscribedException.php";s:4:"d61e";s:63:"Classes/Service/MailChimp/EmailAlreadyUnsubscribedException.php";s:4:"2153";s:53:"Classes/Service/MailChimp/EmailNotExistsException.php";s:4:"dcf8";s:39:"Classes/Service/MailChimp/Exception.php";s:4:"4b75";s:53:"Classes/Service/MailChimp/InvalidEmailException.phtml";s:4:"29e8";s:60:"Classes/Service/MailChimp/ListAlreadySubscribedException.php";s:4:"a378";s:56:"Classes/Service/MailChimp/ListInvalidOptionException.php";s:4:"6ff4";s:56:"Classes/Service/MailChimp/ListNotSubscribedException.php";s:4:"02b3";s:38:"Classes/ViewHelpers/FormViewHelper.php";s:4:"1a1d";s:47:"Classes/ViewHelpers/RenderPartialViewHelper.php";s:4:"d6aa";s:41:"Classes/ViewHelpers/WritableArguments.php";s:4:"164c";s:56:"Classes/ViewHelpers/Form/AbstractFormFieldViewHelper.php";s:4:"a3ca";s:47:"Classes/ViewHelpers/Form/CheckboxViewHelper.php";s:4:"62b8";s:45:"Classes/ViewHelpers/Form/ErrorsViewHelper.php";s:4:"ed8f";s:48:"Classes/ViewHelpers/Form/FormFieldViewHelper.php";s:4:"2679";s:45:"Classes/ViewHelpers/Form/NumberViewHelper.php";s:4:"1cf0";s:44:"Classes/ViewHelpers/Form/RadioViewHelper.php";s:4:"9d42";s:54:"Classes/ViewHelpers/Form/RemainingFieldsViewHelper.php";s:4:"f068";s:45:"Classes/ViewHelpers/Form/SelectViewHelper.php";s:4:"45af";s:48:"Classes/ViewHelpers/Form/TextfieldViewHelper.php";s:4:"0a43";s:45:"Classes/ViewHelpers/Form/UploadViewHelper.php";s:4:"045a";s:59:"Classes/ViewHelpers/Form/Address/AddressFieldViewHelper.php";s:4:"e469";s:59:"Classes/ViewHelpers/Form/Address/AddressLine1ViewHelper.php";s:4:"35ac";s:59:"Classes/ViewHelpers/Form/Address/AddressLine2ViewHelper.php";s:4:"e6b7";s:51:"Classes/ViewHelpers/Form/Address/CityViewHelper.php";s:4:"191c";s:58:"Classes/ViewHelpers/Form/Address/CountryListViewHelper.php";s:4:"633b";s:52:"Classes/ViewHelpers/Form/Address/StateViewHelper.php";s:4:"5fda";s:54:"Classes/ViewHelpers/Form/Address/ZipCodeViewHelper.php";s:4:"3827";s:51:"Classes/ViewHelpers/Form/Birthday/DayViewHelper.php";s:4:"19e2";s:53:"Classes/ViewHelpers/Form/Birthday/MonthViewHelper.php";s:4:"eb07";s:40:"Configuration/FlexForms/Subscription.xml";s:4:"b4a9";s:34:"Configuration/TypoScript/setup.txt";s:4:"2f44";s:48:"Configuration/TypoScript/DefaultStyles/setup.txt";s:4:"1877";s:40:"Resources/Private/Language/locallang.xml";s:4:"eb07";s:48:"Resources/Private/Language/locallang_backend.xml";s:4:"545d";s:43:"Resources/Private/Partials/ActionField.html";s:4:"d610";s:44:"Resources/Private/Partials/AddressField.html";s:4:"32e6";s:45:"Resources/Private/Partials/BirthdayField.html";s:4:"98a6";s:47:"Resources/Private/Partials/CheckboxesField.html";s:4:"a351";s:41:"Resources/Private/Partials/DateField.html";s:4:"30d0";s:45:"Resources/Private/Partials/DropdownField.html";s:4:"9957";s:42:"Resources/Private/Partials/EmailField.html";s:4:"1675";s:38:"Resources/Private/Partials/Errors.html";s:4:"6245";s:36:"Resources/Private/Partials/Form.html";s:4:"3da0";s:45:"Resources/Private/Partials/ImageurlField.html";s:4:"cd5e";s:53:"Resources/Private/Partials/InterestGroupingField.html";s:4:"6f66";s:43:"Resources/Private/Partials/NumberField.html";s:4:"f614";s:42:"Resources/Private/Partials/PhoneField.html";s:4:"9f5f";s:42:"Resources/Private/Partials/RadioField.html";s:4:"4f4a";s:41:"Resources/Private/Partials/TextField.html";s:4:"47ee";s:40:"Resources/Private/Partials/UrlField.html";s:4:"636c";s:40:"Resources/Private/Partials/ZipField.html";s:4:"b6c7";s:46:"Resources/Private/Templates/Backend/Index.html";s:4:"2292";s:52:"Resources/Private/Templates/Subscriptions/Index.html";s:4:"2360";s:54:"Resources/Private/Templates/Subscriptions/Process.html";s:4:"b557";s:57:"Resources/Private/Templates/Subscriptions/Subscribed.html";s:4:"75fe";s:59:"Resources/Private/Templates/Subscriptions/Unsubscribed.html";s:4:"c274";s:35:"Resources/Public/Images/loading.gif";s:4:"e423";s:43:"Resources/Public/JavaScripts/jquery.form.js";s:4:"aa7c";s:47:"Resources/Public/JavaScripts/jquery.form.min.js";s:4:"f454";s:38:"Resources/Public/JavaScripts/jquery.js";s:4:"2665";s:42:"Resources/Public/JavaScripts/jquery.min.js";s:4:"0187";s:39:"Resources/Public/JavaScripts/t3chimp.js";s:4:"cf3f";s:40:"Resources/Public/Stylesheets/t3chimp.css";s:4:"9864";s:14:"doc/manual.sxw";s:4:"2f85";}',
	'suggests' => array(
	),
);

?>