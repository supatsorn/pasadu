<?php
include( "_include_check_root.php" );
require_once( "_text.php" );
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];
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

				<h2 class="sub-header">ข้อมูลผู้ใช้งานในระบบ</h2>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr class="bg-success">
								<th>ชื่อ-สกุล</th>
								<th>ตำแหน่ง</th>
								<th>กลุ่มงาน</th>
								<th>Username</th>
								<th>Password</th>
								<th>ระดับสิทธฺิ์</th>
								<th class="text-center">หัวหน้ากลุ่มงาน?</th>
								<th>สิทธิ์ใช้งาน</th>
								<th></th>
							</tr>
						</thead>
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

							$sql = "select * from user order by role desc,login desc,department asc,name asc";
							$result = $conn->query( $sql );

							if ( $result->num_rows > 0 ) {
								//found				
								while ( $row = $result->fetch_assoc() ) {
									echo "<tr>";
									echo "<td>" . $row[ "name" ] . "</td>";
									echo "<td>" . $row[ "position" ] . "</td>";
									echo "<td>" . $row[ "department" ] . "</td>";
									echo "<td>" . $row[ "username" ] . "</td>";
									echo "<td>" . $row[ "password" ] . "</td>";
									echo "<td>" . getRoleName( $row[ "role" ] ) . "</td>";
									if ( $row[ "role" ] == 1 ) {
										if ( $row[ "head_id" ] == $row[ "id" ] ) {
											echo "<td align=\"center\"><b>ใช่</td>";
										} else {
											echo "<td align=\"center\">ไม่</td>";
										}
									} else {
										echo "<td align=\"center\"> - </td>";
									}
									if ( $row[ "login" ] == 1 ) {
										echo "<td>อนุญาติ</td>";
									} else {
										echo "<td><b>ไม่อนุญาติ</b></td>";
									}
									echo '<td><a target="_top" href="root_edit_user.php?menu=1&uid=' . $row[ "id" ] . '" class="btn btn-info" role="button">แก้ไข</a></td>';				
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