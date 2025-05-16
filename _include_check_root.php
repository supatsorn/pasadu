<?php
// check admin system
session_start();
$sid = session_id();
if(!isset($_SESSION[ '$sid_role' ])){
	header( "Location: ./" );
	exit;
}
if ( $_SESSION[ '$sid_role' ] != 3 ) {
	header( "Location: ./" );
	exit;
}
?>