<?php
/**
 *  Copyright notice.
 *
 *  (c) 2012 DMK E-Business GmbH <dev@dmk-ebusiness.de>
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
 * @author Hannes Bochmann <dev@dmk-ebusiness.de>
 */
class tx_mksanitizedparameters_sanitizer_Alnum implements tx_mksanitizedparameters_interface_Sanitizer
{
    /**
     * (non-PHPdoc).
     *
     * @see tx_mksanitizedparameters_interface_Sanitizer::sanitizeValue()
     */
    public static function sanitizeValue($value)
    {
        return tx_mksanitizedparameters_util_RegularExpression::callPregReplace(
            '/[^'.self::getRegularExpressionForLetters().'[:digit:]]/',
            (string) $value
        );
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function sanitizeValueAllowingWhitespaces($value)
    {
        return tx_mksanitizedparameters_util_RegularExpression::callPregReplace(
            '/[^'.self::getRegularExpressionForLetters().'[:digit:] ]/',
            (string) $value
        );
    }

    /**
     * @return string
     */
    public static function getRegularExpressionForLetters()
    {
        return tx_mksanitizedparameters_sanitizer_Alpha::getRegularExpressionForLetters();
    }
}

if (defined('TYPO3_MODE') && $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mksanitizedparameters/sanitizer/class.tx_mksanitizedparameters_sanitizer_Alpha.php']) {
    include_once $GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/mksanitizedparameters/sanitizer/class.tx_mksanitizedparameters_sanitizer_Alpha.php'];
}
