<?php
// System init
require_once( 'kapp_bootstrap.php' );

use Kaltura\Client\Configuration as KalturaConfiguration;
use Kaltura\Client\Client as KalturaClient;

// Verify ks set
if( !empty( $_COOKIE['ks'] ) && !empty( $_COOKIE['partnerId'] ) && ($ks = $_COOKIE['ks']) && ($partnerId = $_COOKIE['partnerId']) ){
  // verify the KS is valid
  $config = new KalturaConfiguration($partnerId);
  $config->setServiceUrl('http://www.kaltura.com/');
  $gClient = new KalturaClient($config);
  $gClient->setKS($ks);
  try{
	  $result = $gClient->session->get( $ks );
  }catch( Exception $e ){
	  // remove the cookies
	  setcookie( 'ks' );
	  setcookie( 'partnerId' );
	  echo 'Session Validation Failed: '.$e->getMessage();
  }
  // debug
  // echo $result; die;
}elseif( !empty($_REQUEST['view']) ){
	header("Location: http://demo.kaltura.us/uploaders/index.php?error=loginrequired");
	exit;
}

/*
if view set
	if validate view
		if validate cookie
			display demo
		else invalid cookie
			clear cookie
			display error
	else invalid view
		display error
else
	display dashboard
*/	
			
