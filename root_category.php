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
				<h2 class="sub-header text-center">จัดการหมวดวัสดุ</h2>
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
					<form class="form-horizontal" action="?menu=3" method="post">
						<div class="table-responsive">
							<table class="table-striped table-hover" align="center">
								<tbody>
									<?php
									require( "_config.php" );
									require( "_my_function.php" );
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

									$sql = "select * from category order by name asc";
									$result = $conn->query( $sql );

									if ( $result->num_rows > 0 ) {
										//found				
										while ( $row = $result->fetch_assoc() ) {
											echo "<tr>";
											echo "<td>" . $row[ "name" ] . "</td>";
											echo '<td align="center"><button class="btn btn-warning" name="c_' . $row[ "id" ] . '" id="c_' . $row[ "id" ] . '" type="submit" value="' . $row[ "id" ] . '">แก้ไข</button></td>';
											echo "</tr>";
										}
									} else {
										//not found
									}
									$conn->close();
									?>
									<tr>
										<td><input type="text" class="form-control" name="name" id="name" placeholder="เพิ่มชื่อหมวดหมู">
										</td>
										<td><input type="hidden" name="check" value="1"><button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
										</td>
									</tr>
								</tbody>
							</table>
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