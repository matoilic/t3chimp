<?php

########################################################################
# Extension Manager/Repository config file for ext "t3chimp".
#
# Auto generated 24-10-2011 13:46
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
	'version' => '0.1.0',
	'dependencies' => 'extbase,fluid',
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
	'author_email' => 'milic@bsmediavision.ch',
	'author_company' => 'BS MediaVision AG',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.5.0-0.0.0',
			'extbase' => '1.3.0-0.0.0',
			'fluid' => '1.3.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:13:{s:21:"ext_conf_template.txt";s:4:"604b";s:12:"ext_icon.gif";s:4:"e940";s:17:"ext_localconf.php";s:4:"ba13";s:13:"subscribe.php";s:4:"7e27";s:73:"Classes/Domain/Repository/Tx_T3chimp_Domain_Repository_ListRepository.php";s:4:"7f1d";s:34:"Configuration/FlexForms/Filter.xml";s:4:"a4cb";s:34:"Configuration/TypoScript/setup.txt";s:4:"8459";s:48:"Configuration/TypoScript/DefaultStyles/setup.txt";s:4:"f6dd";s:22:"Lib/AjaxDispatcher.php";s:4:"c014";s:19:"Lib/MCAPI.class.php";s:4:"9b81";s:33:"Lib/Controller/BaseController.php";s:4:"7b49";s:40:"Resources/Private/Language/locallang.xml";s:4:"f20c";s:40:"Resources/Public/Stylesheets/t3chimp.css";s:4:"a25e";}',
	'suggests' => array(
	),
);

?>