<?php /* -*- Mode: php; tab-width: 4; indent-tabs-mode: t; c-basic-offset: 4; -*- */
/* vim: :set fdm=marker : */
/**
 * $Header: $
 *
 * Copyright (c) 2010 will james will.james@kaltura.com
 *
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 *
 * $Id: $
 * @package demo
 * @subpackage functions
 */

/**
 * define shorthand directory separator constant
 */
if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

if (!defined('KAPP_ROOT_PATH'))
	define( 'KAPP_ROOT_PATH', empty( $_SERVER['VHOST_DIR'] ) ? dirname( __FILE__ ).'/' : $_SERVER['VHOST_DIR'].'/' );

if (!defined('KAPP_EXTERNALS_PATH'))
	define("KAPP_EXTERNALS_PATH", KAPP_ROOT_PATH . 'externals' . DS);

if (!defined('KAPP_TEMP_PATH'))
	define("KAPP_TEMP_PATH", KAPP_ROOT_PATH . 'temp' . DS);

if (!defined('KAPP_CONFIG_PATH'))
	define("KAPP_CONFIG_PATH", KAPP_ROOT_PATH . 'config' . DS);

require_once( KAPP_ROOT_PATH.'KSmarty.php' );

global $gKSmarty;
$gKSmarty = new KSmarty();

// utilities
function xmlToArray($xml) {
	$array = json_decode(json_encode($xml), TRUE);

	foreach ( array_slice($array, 0) as $key => $value ) {
		if ( empty($value) ) $array[$key] = NULL;
		elseif ( is_array($value) ) $array[$key] = xmlToArray($value);
	}

	return $array;
}
