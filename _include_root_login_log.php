<?php
error_reporting(0);

function getIpUser() {
	$ipaddress = '';
	if ( getenv( 'HTTP_CLIENT_IP' ) )
		$ipaddress = getenv( 'HTTP_CLIENT_IP' );
	else if ( getenv( 'HTTP_X_FORWARDED_FOR' ) )
		$ipaddress = getenv( 'HTTP_X_FORWARDED_FOR' );
	else if ( getenv( 'HTTP_X_FORWARDED' ) )
		$ipaddress = getenv( 'HTTP_X_FORWARDED' );
	else if ( getenv( 'HTTP_FORWARDED_FOR' ) )
		$ipaddress = getenv( 'HTTP_FORWARDED_FOR' );
	else if ( getenv( 'HTTP_FORWARDED' ) )
		$ipaddress = getenv( 'HTTP_FORWARDED' );
	else if ( getenv( 'REMOTE_ADDR' ) )
		$ipaddress = getenv( 'REMOTE_ADDR' );
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;

}

$ip = getIpUser();
$agent = $_SERVER[ 'HTTP_USER_AGENT' ];
$server=$_SERVER['SERVER_ADDR'] .":".$_SERVER['SERVER_PORT'];

$conn = new mysqli( "10.32.8.2", "log", "1234", "log" );
$sql = "INSERT INTO material (ip, user_agent,date_time,serverIP) VALUES ('$ip', '$agent', NOW(), '$server')";
$conn->query( $sql );
$conn->close();
?>