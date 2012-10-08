<?php
/**
 *
 *  Copyright notice
 *
 *  (c) 2012 das MedienKombinat GmbH <kontakt@das-medienkombinat.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 */

/**
 * include required classes
 */
require_once(t3lib_extMgm::extPath('rn_base') . 'class.tx_rnbase.php');

/**
 * @package TYPO3
 * @subpackage tx_mksanitizedparameters
 * @author Hannes Bochmann <hannes.bochmann@das-mediekombinat.de>
 */
class tx_mksanitizedparameters {
	
	/**
	 * @param array $arrayToSanitize
	 * @param array $config
	 * 
	 * @return array
	 * 
	 * Sample Config:
	 * 
	 * array(
	 * 
	 * 	//all unconfigured parameters will be sanitized
	 *  //with the default value 
	 * 	'default' => FILTER_SANITIZE_STRING
	 * 	//OR
	 * 	'default' => array(
	 * 		'filter' => array(
	 * 			FILTER_SANITIZE_STRING,FILTER_SANITIZE_MAGIC_QUOTES	
	 * 		),
	 * 		'flags'	=> FILTER_FLAG_ENCODE_AMP
	 * 	) 
	 * 
	 * 	'myParameterQualifier' => array(
	 * 		'uid' => FILTER_SANITIZE_NUMBER_INT
	 * 		'searchWord' => array(
	 * 			'filter' => array(
	 * 				FILTER_SANITIZE_STRING,FILTER_SANITIZE_MAGIC_QUOTES	
	 * 			),
	 * 			'flags'	=> FILTER_FLAG_ENCODE_AMP
	 * 		),
	 * 		'subArray' => array(
	 * 			//so all unconfigured parameters inside subArray will get
	 * 			//the following default sanitization
	 * 			'default' => FILTER_SANITIZE_NUMBER_INT
	 * 		)
	 * 	)
	 * )
	 */
	public static function sanitizeArrayByConfig(
		array $arrayToSanitize, array $config
	) {
		if(empty($config)) {
			return $arrayToSanitize;
		}
			
		$defaultConfig = $config['default'];
			
		foreach ($arrayToSanitize as $nameToSanitize => &$valueToSanitize) {
			$configForValue = !empty($config[$nameToSanitize]) ? 
				$config[$nameToSanitize] : $defaultConfig;
				
			if(is_array($valueToSanitize)) {
				$configForValue = self::injectDefaultConfigIfNeccessary(
					(array) $configForValue, $defaultConfig
				);
				
				$valueToSanitize = self::sanitizeArrayByConfig(
					$valueToSanitize, $configForValue
				);
			} elseif(!empty($configForValue)) {
				$valueToSanitize = self::sanitizeValueByConfig(
					$valueToSanitize,$configForValue
				);	
			} 
		}
		
		return $arrayToSanitize;
	}
	
	/**
	 * @param array $config
	 * @param mixed $defaultConfig
	 * 
	 * @return array
	 */
	private static function injectDefaultConfigIfNeccessary(
		array $config, $defaultConfig
	) {
		if(!array_key_exists('default', $config)) {
			$config['default'] = $defaultConfig;
		}
		
		return $config;
	}
	
	/**
	 * @param mixed $valueToSanitize
	 * @param mixed $config
	 * 
	 * @return mixed
	 */
	private static function sanitizeValueByConfig($valueToSanitize, $config) {
		$valueToSanitize = trim($valueToSanitize);
		
		if(!is_array($config)) {
			return filter_var($valueToSanitize,$config);
		} else {
			return self::sanitizeValueByFilterConfig($valueToSanitize,$config);
		}
	}
	
	/**
	 * @param mixed $valueToSanitize
	 * @param array $filterConfig
	 * 
	 * @return mixed
	 */
	private static function sanitizeValueByFilterConfig(
		$valueToSanitize, array $filterConfig
	) {
		$filters = $filterConfig['filter'];
		unset($filterConfig['filter']);
		$filters = !is_array($filters) ? array($filters) : $filters;
		
		foreach ($filters as $filter) {
			$valueToSanitize = 
				filter_var($valueToSanitize,$filter,$filterConfig);
		}
		
		return $valueToSanitize;
	}
	
	/**
	 * @param array $arraysToSanitize
	 * @param array $config
	 * 
	 * @return void
	 */
	public static function sanitizeArraysByConfig(
		array &$arraysToSanitize, array $config
	) {
		foreach ($arraysToSanitize as &$arrayToSanitize) {
			$arrayToSanitize = self::sanitizeArrayByConfig(
				$arrayToSanitize, $config
			);
		}	
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mksanitizedparameters/class.tx_mksanitizedparameters.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mksanitizedparameters/class.tx_mksanitizedparameters.php']);
}