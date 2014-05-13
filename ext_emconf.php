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
	'version' => '2.1.0',
	'dependencies' => 'extbase,fluid',
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
			'php' => '5.3.7-0.0.0',
			'typo3' => '6.1.0-6.2.99',
            'extbase' => '6.1.0-6.2.99',
            'fluid' => '6.1.0-6.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => '',
	'suggests' => array(
	),
);

?>
