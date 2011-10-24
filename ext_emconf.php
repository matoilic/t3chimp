<?php

########################################################################
# Extension Manager/Repository config file for ext "hacoshowroom".
#
# Auto generated 06-10-2011 16:56
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
	'version' => '0.1',
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
	'_md5_values_when_last_written' => 'a:82:{s:8:"Rakefile";s:4:"733d";s:21:"ext_conf_template.txt";s:4:"ce9b";s:12:"ext_icon.gif";s:4:"e940";s:17:"ext_localconf.php";s:4:"7543";s:14:"ext_tables.php";s:4:"a013";s:14:"ext_tables.sql";s:4:"ab35";s:25:"ext_tables_static+adt.sql";s:4:"8989";s:19:"google-compiler.jar";s:4:"4f01";s:26:"Classes/AjaxDispatcher.php";s:4:"52d3";s:37:"Classes/Controller/BaseController.php";s:4:"294e";s:39:"Classes/Controller/ImportController.php";s:4:"30ad";s:47:"Classes/Controller/ProductFiltersController.php";s:4:"f46c";s:41:"Classes/Controller/ProductsController.php";s:4:"03d4";s:46:"Classes/Controller/RecipeFiltersController.php";s:4:"1139";s:40:"Classes/Controller/RecipesController.php";s:4:"defe";s:32:"Classes/Domain/Model/Product.php";s:4:"98e3";s:37:"Classes/Domain/Model/ProductGroup.php";s:4:"5b2d";s:31:"Classes/Domain/Model/Recipe.php";s:4:"8bec";s:36:"Classes/Domain/Model/RecipeGroup.php";s:4:"1d4f";s:32:"Classes/Domain/Model/Section.php";s:4:"ebd0";s:52:"Classes/Domain/Repository/ProductGroupRepository.php";s:4:"3f6d";s:47:"Classes/Domain/Repository/ProductRepository.php";s:4:"793b";s:51:"Classes/Domain/Repository/RecipeGroupRepository.php";s:4:"d50c";s:46:"Classes/Domain/Repository/RecipeRepository.php";s:4:"bb4a";s:47:"Classes/Domain/Repository/SectionRepository.php";s:4:"759f";s:43:"Classes/ViewHelpers/JsonTableViewHelper.php";s:4:"95e4";s:37:"Classes/ViewHelpers/RawViewHelper.php";s:4:"7f99";s:34:"Configuration/FlexForms/Filter.xml";s:4:"03ce";s:29:"Configuration/TCA/Product.php";s:4:"0455";s:34:"Configuration/TCA/ProductGroup.php";s:4:"5157";s:28:"Configuration/TCA/Recipe.php";s:4:"b4e7";s:33:"Configuration/TCA/RecipeGroup.php";s:4:"5248";s:29:"Configuration/TCA/Section.php";s:4:"1a14";s:34:"Configuration/TypoScript/setup.txt";s:4:"8459";s:48:"Configuration/TypoScript/DefaultStyles/setup.txt";s:4:"f6dd";s:16:"Lib/TypoMail.php";s:4:"f261";s:27:"Lib/Import/BasicElement.php";s:4:"56f5";s:28:"Lib/Import/BasicImporter.php";s:4:"4c9b";s:23:"Lib/Import/IElement.php";s:4:"768e";s:24:"Lib/Import/SAXParser.php";s:4:"684e";s:30:"Lib/Import/TextListElement.php";s:4:"3c12";s:23:"Lib/Import/importer.php";s:4:"fb05";s:44:"Lib/Import/ProductImport/DatabaseElement.php";s:4:"e262";s:44:"Lib/Import/ProductImport/DocumentElement.php";s:4:"3915";s:40:"Lib/Import/ProductImport/ItemElement.php";s:4:"9692";s:44:"Lib/Import/ProductImport/ProductImporter.php";s:4:"ed7b";s:41:"Lib/Import/ProductImport/TableBuilder.php";s:4:"b6b5";s:43:"Lib/Import/RecipeImport/DatabaseElement.php";s:4:"c944";s:43:"Lib/Import/RecipeImport/DocumentElement.php";s:4:"0555";s:39:"Lib/Import/RecipeImport/ItemElement.php";s:4:"f040";s:42:"Lib/Import/RecipeImport/RecipeImporter.php";s:4:"72f9";s:43:"Lib/Import/RecipeImport/RichtextElement.php";s:4:"4724";s:39:"Lib/Import/RecipeImport/TextElement.php";s:4:"72fe";s:40:"Resources/Private/Language/locallang.xml";s:4:"e1cf";s:38:"Resources/Private/Partials/filter.html";s:4:"b36d";s:50:"Resources/Private/Partials/paginationTemplate.html";s:4:"e4fd";s:46:"Resources/Private/Partials/resultTemplate.html";s:4:"e28e";s:51:"Resources/Private/Templates/Import/importFailed.txt";s:4:"518d";s:54:"Resources/Private/Templates/Import/importSucceeded.txt";s:4:"ba30";s:45:"Resources/Private/Templates/Import/index.html";s:4:"1165";s:53:"Resources/Private/Templates/ProductFilters/index.html";s:4:"7807";s:47:"Resources/Private/Templates/Products/index.html";s:4:"478b";s:46:"Resources/Private/Templates/Products/show.html";s:4:"30dd";s:52:"Resources/Private/Templates/RecipeFilters/index.html";s:4:"7807";s:46:"Resources/Private/Templates/Recipes/index.html";s:4:"a9c2";s:45:"Resources/Private/Templates/Recipes/show.html";s:4:"b393";s:40:"Resources/Public/Images/arrow-closed.gif";s:4:"f303";s:38:"Resources/Public/Images/arrow-open.gif";s:4:"e699";s:32:"Resources/Public/Images/book.png";s:4:"96da";s:37:"Resources/Public/Images/figure-bg.gif";s:4:"e300";s:35:"Resources/Public/Images/spinner.gif";s:4:"30d8";s:44:"Resources/Public/JavaScripts/hacoshowroom.js";s:4:"0833";s:48:"Resources/Public/JavaScripts/hacoshowroom.min.js";s:4:"6fb0";s:42:"Resources/Public/JavaScripts/handlebars.js";s:4:"dd9b";s:46:"Resources/Public/JavaScripts/handlebars.min.js";s:4:"949d";s:45:"Resources/Public/JavaScripts/jquery.cookie.js";s:4:"343f";s:49:"Resources/Public/JavaScripts/jquery.cookie.min.js";s:4:"892c";s:43:"Resources/Public/JavaScripts/jquery.json.js";s:4:"baa3";s:47:"Resources/Public/JavaScripts/jquery.json.min.js";s:4:"90aa";s:47:"Resources/Public/JavaScripts/jquery.treeview.js";s:4:"3ecc";s:51:"Resources/Public/JavaScripts/jquery.treeview.min.js";s:4:"9a93";s:45:"Resources/Public/Stylesheets/hacoshowroom.css";s:4:"bb17";}',
	'suggests' => array(
	),
);

?>