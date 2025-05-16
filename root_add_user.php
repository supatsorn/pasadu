<?php
include("_include_check_root.php");
require_once("_text.php");
$name=$_SESSION['$sid_name'];
$pos=$_SESSION['$sid_position'];

$showStatus=false;
/// process
if ( isset( $_POST[ "check" ] ) ) {
	$name = $_POST[ "name" ];
	$pos = $_POST[ "pos" ];
	$dep = "กลุ่มงาน".$_POST[ "dep" ];
	$user = $_POST[ "user" ];
	$pass = $_POST[ "pass" ];
	$role = $_POST[ "role" ];

	require_once( "_config.php" );
	// Create connection
	$conn = new mysqli( $_H, $_U, $_P, $_DB );
	// Check connection
	if ( $conn->connect_error ) {
		die( "Connection failed: " . $conn->connect_error );
	}
	include_once( "_include_mysql_set_char.php" );
	$sql = "INSERT INTO user (username, password, name,position,department,role)
VALUES ('$user', '$pass', '$name','$pos','$dep',$role)";

	if ( $conn->query( $sql ) === TRUE ) {
		//echo "New record created successfully";
		$showStatus = true;
	} else {
		$showStatus = false;
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}
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

    <title><?php echo $_HTML_TEXT_TITLE; ?></title>

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
          <a class="navbar-brand" href="#"><?php echo $_HTML_TEXT_PROJECT_NAME; ?></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><?php echo $name;?></a></li>
        <li><a href="#"><?php echo $pos;?></a></li>
        <li><a href="logout.php" class="glyphicon glyphicon-log-out">&nbsp;ออกจากระบบ</a></li>
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
				<h2 class="sub-header">เพิ่มผู้ใช้งาน</h2>
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
					<form class="form-horizontal" action="?menu=2" method="post">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">ชื่อ - นามสกุล</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="name" id="name" placeholder="ชื่อ - สกุล">
							</div>
						</div>
						<div class="form-group">
							<label for="pos" class="col-sm-3 control-label">ตำแหน่ง</label>
							<div class="col-sm-3">
								<input type="text" name="pos" class="form-control" id="pos" placeholder="ตำแหน่ง">
							</div>
						</div>
						<div class="form-group">
							<label for="dep" class="col-sm-3 control-label">กลุ่มงาน</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="dep" id="dep" placeholder="กลุ่มงาน">
							</div>
						</div>
						<div class="form-group">
							<label for="user" class="col-sm-3 control-label">Username</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="user" id="user" placeholder="Username">
							</div>
						</div>
						<div class="form-group">
							<label for="pass" class="col-sm-3 control-label">Password</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="pass" id="pass" placeholder="Password">
							</div>
						</div>
						<div class="form-group">
							<label for="role" class="col-sm-3 control-label">ระดับสิทธฺิ์</label>
							<div class="col-sm-3">
								<select name="role" id="role">
									<option value="-1">- เลือกรายการ -</option>
									<option value="1">ผู้ใช้งาน</option>
									<option value="2">ผู้อนุมัติจ่าย</option>
									<option value="3">ผู้ดูแลระบบ</option>
								</select>
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
		$( "button[type=submit]" ).click( function ( e ) {
			if ( $( '#role' ).val() == -1 ) {
				return false;
			}
		} );
		$( "form" ).keypress( function ( e ) {
			//Enter key
			if ( e.which == 13 ) {
				return false;
			}
		} );
	</script>
  </body>
</html>
