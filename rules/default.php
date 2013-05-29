<?php
defined('TYPO3_MODE') || die('Access denied.');

// $rulesForFrontend = array(
// 	tx_mksanitizedparameters_Rules::DEFAULT_RULES_KEY	=> array(FILTER_SANITIZE_STRING, FILTER_SANITIZE_MAGIC_QUOTES),
// 	tx_mksanitizedparameters_Rules::COMMON_RULES_KEY	=> array(
// 		// Extbase request token für Formulare
// 		// JSON String
// 		'__hmac' => FILTER_UNSAFE_RAW,
// 
//		// wird nur mkforms intern verwendet
//		// JSON String
//		'AMEOSFORMIDABLE_ADDPOSTVARS' => FILTER_UNSAFE_RAW,
// 
// 		// pid, uid und id sollten immer zahlen sein
// 		'id' => FILTER_SANITIZE_NUMBER_INT,
// 		'uid' => FILTER_SANITIZE_NUMBER_INT,
//	 	'pid' => FILTER_SANITIZE_NUMBER_INT,
// 	)
// );
 
$rulesForFrontend = 
	unserialize('a:2:{s:9:"__default";a:2:{i:0;i:513;i:1;i:521;}s:8:"__common";a:5:{s:6:"__hmac";i:516;s:27:"AMEOSFORMIDABLE_ADDPOSTVARS";i:516;s:2:"id";i:519;s:3:"uid";i:519;s:3:"pid";i:519;}}');

tx_mksanitizedparameters_Rules::addRulesForFrontend($rulesForFrontend);

// $rulesForBackend =  array(
// 	tx_mksanitizedparameters_Rules::COMMON_RULES_KEY	=> array(
// 		// pid, uid und id sollten immer zahlen sein
// 		'id' => FILTER_SANITIZE_NUMBER_INT,
// 		'uid' => FILTER_SANITIZE_NUMBER_INT,
//	 	'pid' => FILTER_SANITIZE_STRING,
// 	)
// );

$rulesForBackend = unserialize('a:1:{s:8:"__common";a:3:{s:2:"id";i:519;s:3:"uid";i:519;s:3:"pid";i:513;}}');
tx_mksanitizedparameters_Rules::addRulesForBackend($rulesForBackend);
