<?php
include( "_include_check_admin.php" );
require_once( "_text.php" );
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];
$showStatus = false;

/// process
if ( isset( $_GET[ "check" ] ) ) {
	if ( $_GET[ "check" ] == "update" ) {
		$id = $_GET[ "id" ];
		require( "_config.php" );
		// Create connection
		$conn = new mysqli( $_H, $_U, $_P, $_DB );
		// Check connection
		if ( $conn->connect_error ) {
			die( "Connection failed: " . $conn->connect_error );
		}
		include( "_include_mysql_set_char.php" );

		$sql = "update want set ack=1 where id=$id";
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
			<?php require("_admin_menu.php"); ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

				<h2 class="sub-header">รายการที่ผู้ใช้แจ้งความต้องการ</h2>
				<?php
				if ( $showStatus ) {
					?>
				<div class="text-center">
					<h4 class="text-success bg-info">บันทึกข้อมูลเรียบร้อย.</h4>
				</div>
				<?php
				}
				?>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr class="danger">
								<th>รายการ</th>
								<th>จำนวน</th>
								<th>หมายเหตุ</th>
								<th>วันที่แจ้ง</th>
								<th>ผู้แจ้ง</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							require( "_config.php" );
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

							$sql = "select w.*,u.name as user_name from material.want w left join material.user u on w.user_id=u.id order by w.ack asc,w.add_date asc,w.name asc";
							$result = $conn->query( $sql );

							if ( $result->num_rows > 0 ) {
								//found				
								while ( $row = $result->fetch_assoc() ) {
									echo "<tr>";
									echo "<td>" . $row[ "name" ] . "</td>";
									echo "<td>" . $row[ "number" ] . "</td>";
									echo "<td>" . $row[ "note" ] . "</td>";
									echo "<td>" . toDateThai( $row[ "add_date" ] ) . "</td>";
									echo "<td>" . $row[ "user_name" ] . "</td>";
									if ( $row[ "ack" ] == 0 ) {
										echo '<td><a target="_top" href="admin_user_want.php?menu=8&id=' . $row[ "id" ] . '&check=update" class="btn btn-success" role="button">รับทราบ</a></td>';
									} else {
										echo "<td></td>";
									}
									echo "</tr>";
								}
							} else {
								//not found
							}
							$conn->close();
							?>
						</tbody>
					</table>
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
</body>

</html>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Untitled Document</title>
</head>

<body>
</body>

</html>