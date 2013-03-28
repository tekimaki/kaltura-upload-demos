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

use Kaltura\Client\Configuration as KalturaConfiguration;
use Kaltura\Client\Client as KalturaClient;

global $gClient;
// Verify ks set
if( !empty( $_COOKIE['ks'] ) && !empty( $_COOKIE['partnerId'] ) && ($ks = $_COOKIE['ks']) && ($partnerId = $_COOKIE['partnerId']) ){
  // verify the KS is valid
  $config = new KalturaConfiguration($partnerId);
  $config->setServiceUrl('http://www.kaltura.com/');
  $gClient = new KalturaClient($config);
  $gClient->setKS($ks);
  try{
	  $result = $gClient->session->get( $ks );
	  $validSession = TRUE;
	  $gKSmarty->assign( 'ks', $ks );
	  $gKSmarty->assign( 'partnerId', $partnerId );
	  $gKSmarty->assign( 'userId', $result->userId );
	  $conversionProfile = $gClient->conversionProfile->getDefault();
	  $gKSmarty->assign( 'conversionProfileId', $conversionProfile->id );
  }catch( Exception $e ){
	  echo 'Session Validation Failed: '.$e->getMessage();
  }
  // debug
  // echo $result; die;
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
		// print_r( $demoViews[$_REQUEST['view']]);
		$viewTpl = $demoViews[$_REQUEST['view']]['tpl'];	
		$pageTitle = $demoViews[$_REQUEST['view']]['title'];
		$gKSmarty->assign( 'pageTitle', $pageTitle );
		$gKSmarty->assign( 'uiconfId', $demoViews[$_REQUEST['view']]['uiconf_id'] );
	}else{
		// @TODO replace with graceful error handling
		echo 'Invalid view request';
		die;
	}
}

$gKSmarty->display( $viewTpl, htmlentities($pageTitle) );
