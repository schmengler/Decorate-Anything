<?php

/**
 * Include this file to use the package
 * 
 * @package Decorate Anything
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @version 1.0
 */

if (version_compare(PHP_VERSION, '5.2.6', '<')) {
	throw new Exception('The Decorate Anything package needs PHP 5.2.6 or higher.');
}

/**
 * the class
 */
require_once realpath(dirname(__FILE__) . '/AbstractDecorator.php');
?>