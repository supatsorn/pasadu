<?php
require( "_config.php" );

$user = "root";
$password = "";
$host = $_H;
$db = $_DB_LOGIN;

$u_user = $_POST[ "user" ];
$u_pass = $_POST[ "password" ];

// Create connection
$conn = new mysqli( $host, $user, $password, $db );
// Check connection
if ( $conn->connect_error ) {
	die( "DB Connection failed: " . $conn->connect_error );
}
mysqli_set_charset( $conn, "utf8" );

$sql = "SELECT $_TB_LOGIN_ID_F,$_TB_LOGIN_NAME_F, $_TB_LOGIN_USERNAME_F,$_TB_LOGIN_PASSWORD_F, $_TB_LOGIN_POSITION_F, $_TB_LOGIN_ROLE_F, head_id FROM $_TB_LOGIN where $_TB_LOGIN_USERNAME_F='$u_user' and $_TB_LOGIN_PASSWORD_F='$u_pass' and login=1";
$result = $conn->query( $sql );

if ( $result->num_rows > 0 ) {
	//found
	session_start();
	$sid = session_id();
	$role = 0;
	// output data of each row
	while ( $row = $result->fetch_assoc() ) {
		//echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["upassword"]. "<br>";
		$_SESSION[ '$sid_name' ] = $row[ "$_TB_LOGIN_NAME_F" ];
		$_SESSION[ '$sid_position' ] = $row[ "$_TB_LOGIN_POSITION_F" ];
		$_SESSION[ '$sid_uid' ] = $row[ "$_TB_LOGIN_ID_F" ];
		$role = $row[ "$_TB_LOGIN_ROLE_F" ];
		$_SESSION[ '$sid_head_id' ] = $row[ "head_id" ];
		//$_SESSION["name"]=$row["name"];
	}
	$_SESSION[ '$sid_role' ] = $role + 0;
	$conn->close();
	
	if ( $_SESSION[ '$sid_role' ] == 3 ) {
		include_once("_include_root_login_log.php");
		header( "Location: ./root.php?menu=1" );
		exit;
	} else if ( $_SESSION[ '$sid_role' ] == 2 ) {
		header( "Location: ./admin.php?menu=1" );
		exit;
	} else {
		header( "Location: ./user.php?menu=1" );
		exit;
	}
} else {
	//not found
	$conn->close();
	header( "Location: ./index.php?t=fail" );
	exit;
	//echo "0 results";
}
//$conn->close();

?>