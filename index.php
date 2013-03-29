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

global $gClient;
// If particular demo is requested load it
if( !empty( $_REQUEST['view'] ) ){
	// Is the request valid
	if( in_array( $_REQUEST['view'], array_keys($demoViews) ) ){
		$view = $demoViews[$_REQUEST['view']];
		// Is the request at a unique url
		if( !empty( $view['url'] ) ){ 
			header('Location: http://demo.kaltura.us/uploaders/'.$view['url'] );
			exit;
		}
		// Is the user authenitcated
		require_once ( 'kauth_validate.php' );
		// Yes, continue
		$gKSmarty->assign( 'ks', $ks );
		$gKSmarty->assign( 'partnerId', $partnerId );
		$gKSmarty->assign( 'userId', $result->userId );
		$conversionProfile = $gClient->conversionProfile->getDefault();
		$gKSmarty->assign( 'conversionProfileId', $conversionProfile->id );
		$viewTpl = $view['tpl'];	
		$pageTitle = $view['title'];
		$gKSmarty->assign( 'pageTitle', $pageTitle );
		$gKSmarty->assign( 'uiconfId', $view['uiconf_id'] );
	}else{
		// @TODO replace with graceful error handling
		echo 'Invalid view request';
		die;
	}
}
// Errors
if( !$validSession && !empty( $_REQUEST['error'] ) ){
	$gKSmarty->assign( 'error', $_REQUEST['error'] );
}

$gKSmarty->display( $viewTpl, htmlentities($pageTitle) );
