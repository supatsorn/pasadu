<?php
include( "_include_check_root.php" );
require_once( "_text.php" );
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];

$showStatus = false;
/// update
if ( isset( $_POST[ "check" ] ) ) {
	$name = $_POST[ "name" ];
	$pos = $_POST[ "pos" ];
	$dep = $_POST[ "dep" ];
	$user = $_POST[ "user" ];
	$pass = $_POST[ "pass" ];
	$role = $_POST[ "role" ];
	$head = $_POST[ "head" ];
	$login = 1;
	if ( isset( $_POST[ "login" ] ) ) {
		$login = 1;
	} else {
		$login = 0;
	}
	require_once( "_config.php" );
	// Create connection
	$conn = new mysqli( $_H, $_U, $_P, $_DB );
	// Check connection
	if ( $conn->connect_error ) {
		die( "Connection failed: " . $conn->connect_error );
	}
	include_once( "_include_mysql_set_char.php" );
	$sql = "UPDATE user SET username='$user', password='$pass', name='$name',position='$pos',department='$dep',role=$role,head_id=$head,login=$login where id=" . $_GET[ "uid" ];
	//echo $sql;
	if ( $conn->query( $sql ) === TRUE ) {
		//echo "New record created successfully";
		$showStatus = true;
	} else {
		$showStatus = false;
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
}
//query to show
require_once( "_config.php" );
require_once( "_my_function.php" );
$user = $_U;
$password = $_P;
$host = $_H;
$db = $_DB;

// Create connection
$conn = new mysqli( $host, $user, $password, $db );
// Check connection
if ( $conn->connect_error ) {
	die( "DB Connection failed: " . $conn->connect_error );
}
mysqli_set_charset( $conn, "utf8" );

$sql = "select * from user where id=" . $_GET[ "uid" ];
$result = $conn->query( $sql );

$user = "";
$pass = "";
$name = "";
$pos = "";
$dep = "";
$role = "";
$head = "";
$login = "";
if ( $result->num_rows > 0 ) {
	//found				
	while ( $row = $result->fetch_assoc() ) {
		$user = $row[ "username" ];
		$pass = $row[ "password" ];
		$name = $row[ "name" ];
		$pos = $row[ "position" ];
		$dep = $row[ "department" ];
		$role = $row[ "role" ];
		$head = $row[ "head_id" ];
		$login = $row[ "login" ];
	}
} else {
	//not found
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="th">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>
		<?php echo $_HTML_TEXT_TITLE; ?>
	</title>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/my.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
			


				<a class="navbar-brand" href="#">
					<?php echo $_HTML_TEXT_PROJECT_NAME; ?>
				</a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="#">
						<?php echo $name;?>
					</a>
				</li>
				<li>
					<a href="#">
						<?php echo $pos;?>
					</a>
				</li>
				<li><a href="logout.php" class="glyphicon glyphicon-log-out">&nbsp;ออกจากระบบ</a>
				</li>
			</ul>
			<!--<div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>-->
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<?php require("_root_menu.php"); ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h2 class="sub-header">แก้ไขข้อมูลผู้ใช้งาน</h2>
				<?php
				if ( $showStatus ) {
					?>
				<div class="text-center">
					<h4 class="text-success bg-info">บันทึกข้อมูลเรียบร้อย.</h4>
				</div>
				<?php
				}
				?>
				<div>
					<form class="form-horizontal" action="?menu=1&uid=<?php echo $_GET[ "uid" ]; ?>" method="post">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">ชื่อ - นามสกุล</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="name" id="name" placeholder="ชื่อ - สกุล" value="<?php echo $name; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="pos" class="col-sm-3 control-label">ตำแหน่ง</label>
							<div class="col-sm-3">
								<input type="text" name="pos" class="form-control" id="pos" placeholder="ตำแหน่ง" value="<?php echo $pos; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="dep" class="col-sm-3 control-label">กลุ่มงาน</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="dep" id="dep" placeholder="กลุ่มงาน" value="<?php echo $dep; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="user" class="col-sm-3 control-label">Username</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="user" id="user" placeholder="Username" value="<?php echo $user; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="pass" class="col-sm-3 control-label">Password</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="pass" id="pass" placeholder="Password" value="<?php echo $pass; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="role" class="col-sm-3 control-label">ระดับสิทธฺิ์</label>
							<div class="col-sm-3">
								<select name="role" id="role">
									<option value="1" <?php if($role==1) echo " selected"; ?>>ผู้ใช้งาน</option>
									<option value="2" <?php if($role==2) echo " selected"; ?>>ผู้อนุมัติจ่าย</option>
									<option value="3" <?php if($role==3) echo " selected"; ?>>ผู้ดูแลระบบ</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="head" class="col-sm-3 control-label">หัวหน้ากลุ่ม</label>
							<div class="col-sm-5 col-xs-12 col-md-7">
								<select name="head" id="head">
									<?php
									if ( $head == 0 ) {
										echo '<option value="0" selected>*โปรดระบุหัวหน้ากลุ่มที่จะให้สิทธิ์อนุมัติการเบิก*</option>';
									}
									$user = $_U;
									$password = $_P;
									$host = $_H;
									$db = $_DB;

									// Create connection
									$conn = new mysqli( $host, $user, $password, $db );
									// Check connection
									if ( $conn->connect_error ) {
										die( "DB Connection failed: " . $conn->connect_error );
									}
									mysqli_set_charset( $conn, "utf8" );

									$sql = "select id,name from user";
									$result = $conn->query( $sql );
									if ( $result->num_rows > 0 ) {
										//found				
										while ( $row = $result->fetch_assoc() ) {
											if ( $head != $row[ "id" ] ) {
												echo '<option value="' . $row[ "id" ] . '">' . $row[ "name" ] . '</option>';
											} else {
												echo '<option value="' . $row[ "id" ] . '" selected>' . $row[ "name" ] . '</option>';
											}
										}
									} else {
										//not found
									}
									$conn->close();
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="login" class="col-sm-3 control-label">อนุญาติให้ใช้งาน</label>
							<div class="col-sm-1">
								<?php
								if ( $login == 1 ) {
									echo '<input type="checkbox" class="form-control" name="login" id="login" value="1" checked>';
								} else {
									echo '<input type="checkbox" class="form-control" name="login" id="login" value="0">';
								}
								?>
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" name="check" value="1">
							<div class="col-sm-offset-3 col-sm-9">
								<button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
	<script src="js/holder.js"></script>
	<script type="text/javascript">
		$( "form" ).keypress( function ( e ) {
			//Enter key
			if ( e.which == 13 ) {
				return false;
			}
		} );
	</script>
</body>

</html>