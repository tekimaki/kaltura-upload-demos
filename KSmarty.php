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
 * @package ksmarty
 * @subpackage functions
 */

if( file_exists( KAPP_EXTERNALS_PATH.'smarty/libs/Smarty.class.php' )) {
	// set SMARTY_DIR that we have the absolute path
	define( 'SMARTY_DIR', KAPP_EXTERNALS_PATH.'smarty/libs/' );
	// If we have smarty in our install, use that.
	$smarty_inc_file = SMARTY_DIR . 'Smarty.class.php';
} else {
	// assume it is in php's global include_path
	// don't set SMARTY_DIR if we are not using local copy
	$smarty_inc_file = 'Smarty.class.php';
}

require_once( $smarty_inc_file );

class KSmarty extends Smarty{
	
	public function __construct()
	{
		parent::__construct();

		// customize Smarty config
		// invalid property not sure why $this->mCompileRsrc = NULL;
		$this->config_dir = "configs/";
		$this->force_compile = FALSE;
		$this->debugging = FALSE;
		$this->assign( 'app_name', 'kaltura' );
		// $this->plugins_dir = array_merge( array( KAPP_SMARTYPLUGINS_PATH . "smarty_bit" ), $this->plugins_dir );
		$this->template_dir = KAPP_ROOT_PATH . "templates";
		$this->compile_dir = KAPP_TEMP_PATH . "templates_c";
		$this->error_reporting = 0;
		$this->verifyTempPath( KAPP_TEMP_PATH );
	}

	private function verifyTempPath( $path )
	{
		if (!is_dir($path)) {
			// echo " ".$path."\n";
			if( !mkdir( $path, 0755, TRUE ) ){
				echo ("Could not create temp directory!");
				die;
			}
		}
	}

	public function display( $pCenterTpl, $pBrowserTitle ){
		$this->assign( 'centerTpl', $pCenterTpl );
		$this->assign( 'browserTitle', $pBrowserTitle );
		parent::display( 'kapp.tpl' );
		exit;
	}

	/*
	public function fetch( $pTplFile, $pCacheId = NULL, $pCompileId = NULL, $pDisplay = FALSE ) {
		if( strpos( $pTplFile, ':' )) {
			list( $resource, $location ) = explode( ':', $pTplFile );
			if( $resource == 'resumepublisher' ) {
				list( $dir, $template ) = explode( '/', $location );
			}
		}

		return parent::fetch( $pTplFile, $pCacheId, $pCompileId, $pDisplay );
	}
	*/
}
