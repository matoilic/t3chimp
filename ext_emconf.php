<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'T3Chimp MailChimp Integration',
	'description' => 'Integrates MailChimp into Typo3.',
	'category' => 'plugin',
	'shy' => 0,
	'version' => '2.3.1',
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
