<?php

########################################################################
# Extension Manager/Repository config file for ext "t3chimp".
#
# Auto generated 26-10-2012 14:48
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
	'version' => '0.4.2',
	'dependencies' => 'extbase,fluid,t3jquery,static_info_tables',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
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
			'typo3' => '4.5.0-0.0.0',
			'extbase' => '1.3.0-0.0.0',
			'fluid' => '1.3.0-0.0.0',
			't3jquery' => '2.0.0-0.0.0',
			'static_info_tables' => '2.3.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:108:{s:6:"README";s:4:"31ee";s:16:"ext_autoload.php";s:4:"5f98";s:21:"ext_conf_template.txt";s:4:"bc1f";s:12:"ext_icon.gif";s:4:"8b14";s:17:"ext_localconf.php";s:4:"507a";s:14:"ext_tables.php";s:4:"3db1";s:24:"ext_typoscript_setup.txt";s:4:"2bf7";s:40:"Classes/Controller/BackendController.php";s:4:"cce7";s:46:"Classes/Controller/SubscriptionsController.php";s:4:"7f76";s:26:"Classes/Core/Bootstrap.php";s:4:"938a";s:32:"Classes/Domain/Model/Country.php";s:4:"efad";s:47:"Classes/Domain/Repository/CountryRepository.php";s:4:"c689";s:22:"Classes/Hook/Cache.php";s:4:"e256";s:27:"Classes/MailChimp/Field.php";s:4:"6ebe";s:26:"Classes/MailChimp/Form.php";s:4:"50af";s:36:"Classes/MailChimp/Field/Abstract.php";s:4:"7ca3";s:34:"Classes/MailChimp/Field/Action.php";s:4:"2f8d";s:35:"Classes/MailChimp/Field/Address.php";s:4:"5508";s:36:"Classes/MailChimp/Field/Birthday.php";s:4:"0289";s:38:"Classes/MailChimp/Field/Checkboxes.php";s:4:"dc05";s:32:"Classes/MailChimp/Field/Date.php";s:4:"b523";s:36:"Classes/MailChimp/Field/Dropdown.php";s:4:"5460";s:33:"Classes/MailChimp/Field/Email.php";s:4:"4800";s:36:"Classes/MailChimp/Field/Imageurl.php";s:4:"2b56";s:44:"Classes/MailChimp/Field/InterestGrouping.php";s:4:"7c10";s:34:"Classes/MailChimp/Field/Number.php";s:4:"6674";s:40:"Classes/MailChimp/Field/PatternBased.php";s:4:"ee39";s:33:"Classes/MailChimp/Field/Phone.php";s:4:"0fd4";s:33:"Classes/MailChimp/Field/Radio.php";s:4:"43f2";s:32:"Classes/MailChimp/Field/Text.php";s:4:"edeb";s:31:"Classes/MailChimp/Field/Url.php";s:4:"745c";s:31:"Classes/MailChimp/Field/Zip.php";s:4:"f98a";s:41:"Classes/MailChimp/Field/Helper/Choice.php";s:4:"8c61";s:48:"Classes/MailChimp/Field/Helper/CountryChoice.php";s:4:"6607";s:46:"Classes/MailChimp/Field/Helper/MultiChoice.php";s:4:"4cc6";s:35:"Classes/Provider/FlexFormValues.php";s:4:"29dc";s:28:"Classes/Provider/Session.php";s:4:"ccdb";s:29:"Classes/Provider/Settings.php";s:4:"e12e";s:30:"Classes/Service/FileUpload.php";s:4:"57ab";s:29:"Classes/Service/MailChimp.php";s:4:"5277";s:61:"Classes/Service/FileUpload/FilePartiallyUploadedException.php";s:4:"a4ea";s:52:"Classes/Service/FileUpload/FileTooLargeException.php";s:4:"7541";s:56:"Classes/Service/FileUpload/InvalidExtensionException.php";s:4:"8628";s:54:"Classes/Service/FileUpload/NoFileUploadedException.php";s:4:"831a";s:61:"Classes/Service/MailChimp/EmailAlreadySubscribedException.php";s:4:"c5f8";s:63:"Classes/Service/MailChimp/EmailAlreadyUnsubscribedException.php";s:4:"9f79";s:53:"Classes/Service/MailChimp/EmailNotExistsException.php";s:4:"d8a7";s:39:"Classes/Service/MailChimp/Exception.php";s:4:"d5ed";s:53:"Classes/Service/MailChimp/InvalidEmailException.phtml";s:4:"f4a9";s:60:"Classes/Service/MailChimp/ListAlreadySubscribedException.php";s:4:"a73a";s:56:"Classes/Service/MailChimp/ListInvalidOptionException.php";s:4:"585a";s:56:"Classes/Service/MailChimp/ListNotSubscribedException.php";s:4:"950d";s:38:"Classes/ViewHelpers/FormViewHelper.php";s:4:"e153";s:47:"Classes/ViewHelpers/RenderPartialViewHelper.php";s:4:"f53c";s:41:"Classes/ViewHelpers/WritableArguments.php";s:4:"c427";s:56:"Classes/ViewHelpers/Form/AbstractFormFieldViewHelper.php";s:4:"4e41";s:47:"Classes/ViewHelpers/Form/CheckboxViewHelper.php";s:4:"3419";s:45:"Classes/ViewHelpers/Form/ErrorsViewHelper.php";s:4:"673d";s:48:"Classes/ViewHelpers/Form/FormFieldViewHelper.php";s:4:"c203";s:45:"Classes/ViewHelpers/Form/NumberViewHelper.php";s:4:"8057";s:44:"Classes/ViewHelpers/Form/RadioViewHelper.php";s:4:"3873";s:54:"Classes/ViewHelpers/Form/RemainingFieldsViewHelper.php";s:4:"e77b";s:45:"Classes/ViewHelpers/Form/SelectViewHelper.php";s:4:"4220";s:48:"Classes/ViewHelpers/Form/TextfieldViewHelper.php";s:4:"615a";s:45:"Classes/ViewHelpers/Form/UploadViewHelper.php";s:4:"3193";s:59:"Classes/ViewHelpers/Form/Address/AddressFieldViewHelper.php";s:4:"0bad";s:59:"Classes/ViewHelpers/Form/Address/AddressLine1ViewHelper.php";s:4:"3cbe";s:59:"Classes/ViewHelpers/Form/Address/AddressLine2ViewHelper.php";s:4:"ec00";s:51:"Classes/ViewHelpers/Form/Address/CityViewHelper.php";s:4:"716e";s:58:"Classes/ViewHelpers/Form/Address/CountryListViewHelper.php";s:4:"878a";s:52:"Classes/ViewHelpers/Form/Address/StateViewHelper.php";s:4:"fa58";s:54:"Classes/ViewHelpers/Form/Address/ZipCodeViewHelper.php";s:4:"3eaa";s:51:"Classes/ViewHelpers/Form/Birthday/DayViewHelper.php";s:4:"b6c8";s:53:"Classes/ViewHelpers/Form/Birthday/MonthViewHelper.php";s:4:"b229";s:40:"Configuration/FlexForms/Subscription.xml";s:4:"b4a9";s:34:"Configuration/TypoScript/setup.txt";s:4:"ed31";s:48:"Configuration/TypoScript/DefaultStyles/setup.txt";s:4:"7fbc";s:40:"Resources/Private/Language/locallang.xml";s:4:"d986";s:48:"Resources/Private/Language/locallang_backend.xml";s:4:"0b0d";s:43:"Resources/Private/Partials/ActionField.html";s:4:"d610";s:44:"Resources/Private/Partials/AddressField.html";s:4:"428f";s:45:"Resources/Private/Partials/BirthdayField.html";s:4:"98a6";s:47:"Resources/Private/Partials/CheckboxesField.html";s:4:"a351";s:41:"Resources/Private/Partials/DateField.html";s:4:"30d0";s:45:"Resources/Private/Partials/DropdownField.html";s:4:"9957";s:42:"Resources/Private/Partials/EmailField.html";s:4:"1675";s:38:"Resources/Private/Partials/Errors.html";s:4:"6245";s:36:"Resources/Private/Partials/Form.html";s:4:"8708";s:45:"Resources/Private/Partials/ImageurlField.html";s:4:"cd5e";s:53:"Resources/Private/Partials/InterestGroupingField.html";s:4:"f87f";s:43:"Resources/Private/Partials/NumberField.html";s:4:"f614";s:42:"Resources/Private/Partials/PhoneField.html";s:4:"9f5f";s:42:"Resources/Private/Partials/RadioField.html";s:4:"4f4a";s:41:"Resources/Private/Partials/TextField.html";s:4:"47ee";s:40:"Resources/Private/Partials/UrlField.html";s:4:"636c";s:40:"Resources/Private/Partials/ZipField.html";s:4:"b6c7";s:46:"Resources/Private/Templates/Backend/Index.html";s:4:"2292";s:52:"Resources/Private/Templates/Subscriptions/Index.html";s:4:"d624";s:54:"Resources/Private/Templates/Subscriptions/Process.html";s:4:"b557";s:57:"Resources/Private/Templates/Subscriptions/Subscribed.html";s:4:"75fe";s:59:"Resources/Private/Templates/Subscriptions/Unsubscribed.html";s:4:"c274";s:35:"Resources/Public/Images/loading.gif";s:4:"e423";s:43:"Resources/Public/JavaScripts/jquery.form.js";s:4:"bcd0";s:47:"Resources/Public/JavaScripts/jquery.form.min.js";s:4:"1aaa";s:39:"Resources/Public/JavaScripts/t3chimp.js";s:4:"801e";s:40:"Resources/Public/Stylesheets/t3chimp.css";s:4:"9864";s:22:"Vendor/MCAPI.class.php";s:4:"9b81";s:14:"doc/manual.sxw";s:4:"79c4";}',
	'suggests' => array(
	),
);

?>