<?php /* -*- Mode: php; tab-width: 4; indent-tabs-mode: t; c-basic-offset: 4; -*- */
/* vim: :set fdm=marker : */

// set page title default
$pageTitle = 'Kaltura Upload Demos';
// set page tpl default
$viewTpl = 'view_dashboard.tpl';
// track valid session;
$validSession = FALSE;

// System init
require_once( 'kapp_bootstrap.php' );

global $gClient;
// Verify ks set
if( !empty( $_COOKIE['ks'] ) && $ks = $_COOKIE['ks'] ){
  // verify the KS is valid
  require_once( KAPP_EXTERNALS_PATH.'kalturaapilib/library/Client.php');
  $config = new KalturaConfiguration();
  $config->serviceUrl = 'http://www.kaltura.com/';
  $gClient = new KalturaClient($config);
  $gClient->setKS($ks);
  try{
	  $result = $gClient->session->get();
	  $validSession = TRUE;
	  $gKSmarty->assign( 'ks', $ks );
	  $gKSmarty->assign( 'partnerId', $result->partnerId );
	  $gKSmarty->assign( 'userId', $result->userId );
	  $conversionProfile = $client->conversionProfile->getdefault();
	  $gKSmarty->assign( 'conversionProfileId', $conversionProfile->id );
  }catch( Exception $e ){
	  echo 'Session Validation Failed: '.$e->getMessage();
  }
  // debug
  echo $result; die;
}

// Demo init
// open xml file
$xml = simplexml_load_file( './demos.xml' );
// get demo hashes and convert the xml to an array
$rows = xmlToArray( $xml->xpath( "/demos/demo" ) ); 
// tidy data
$demoViews = array();
foreach ($rows as $v) {
	$demoViews[$v['type']] = $v;
}
$gKSmarty->assign( 'demos', $demoViews );

// If particular demo is requested load it
if( !empty( $_REQUEST['view'] ) ){
	if( in_array( $_REQUEST['view'], array_keys($demoViews) ) ){
		$viewTpl = $demoViews[$_REQUEST['view']]['tpl'];	
		$pageTitle = $demoViews[$_REQUEST['view']]['page_title'];
		$gKSmarty->assign( 'uiconfId', $demoViews[$_REQUEST['view']]['uiconf_id'] );
	}else{
		// @TODO replace with graceful error handling
		echo 'Invalid view request';
		die;
	}
}

$gKSmarty->display( $viewTpl, htmlentities($pageTitle) );
