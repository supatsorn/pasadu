<?php
include( "_include_check_user_login.php" );
require_once( "_text.php" );
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];
$showStatus = false;

/// process
if ( isset( $_POST[ "check" ] ) ) {
	$name = $_POST[ "name" ];
	$number = $_POST[ "number" ];
	$note = $_POST[ "note" ];
	$user = $_SESSION[ '$sid_uid' ];
	require( "_config.php" );
	// Create connection
	$conn = new mysqli( $_H, $_U, $_P, $_DB );
	// Check connection
	if ( $conn->connect_error ) {
		die( "Connection failed: " . $conn->connect_error );
	}
	mysqli_query( $conn, 'SET character_set_results=utf8' );
	mysqli_query( $conn, 'SET names=utf8' );
	mysqli_query( $conn, 'SET character_set_client=utf8' );
	mysqli_query( $conn, 'SET character_set_connection=utf8' );
	mysqli_query( $conn, 'SET character_set_results=utf8' );
	mysqli_query( $conn, 'SET collation_connection=utf8_general_ci' );

	$sql = "INSERT INTO want (name, number,note,user_id)
VALUES ('$name', $number, '$note', $user)";

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
			<?php require("_user_menu.php"); ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h2 class="sub-header">แจ้งความต้องการวัสดุ</h2>
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
					<form class="form-horizontal" action="#" method="post">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">ชื่อรายการ</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="name" id="name" placeholder="ชื่อวัสดุที่ต้องการ" autofocus>
							</div>
						</div>
						<div class="form-group">
							<label for="number" class="col-sm-3 control-label">จำนวน</label>
							<div class="col-sm-2">
								<input type="text" name="number" class="form-control col-xs-2" id="number" value="0" placeholder="จำนวน">
							</div>
						</div>
						<div class="form-group">
							<label for="price" class="col-sm-3 control-label">หมายเหตุ</label>
							<div class="col-sm-6">
								<textarea name="note" class="form-control"></textarea>
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" name="check" value="1"/>
							<input type="hidden" name="menu" value="4"/>
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-warning">บันทึกข้อมูล</button>
							</div>
						</div>
					</form>
				</div>
				<hr>
				<h4 class="text-center"><b>รายการที่แจ้งความต้องการที่ผ่านมา</b></h4>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr class="info">
								<th>รายการ</th>
								<th>จำนวน</th>
								<th>หมายเหตุ</th>
								<th>วันที่แจ้ง</th>
								<th>การตอบรับ</th>
								<th class="text-center">รายการที่เคยแจ้ง</th>
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

							$sql = "select * from material.want order by name asc,add_date asc";
							$result = $conn->query( $sql );

							if ( $result->num_rows > 0 ) {
								//found				
								while ( $row = $result->fetch_assoc() ) {
									echo "<tr>";
									echo "<td>" . $row[ "name" ] . "</td>";
									echo "<td>" . $row[ "number" ] . "</td>";
									echo "<td>" . $row[ "note" ] . "</td>";
									echo "<td>" . toDateThai( $row[ "add_date" ] ) . "</td>";
									if ( $row[ "ack" ] == 0 ) {
										echo "<td>ยังไม่รับ</td>";
									} else {
										echo "<td>รับทราบแล้ว</td>";
									}
									echo "<td align=\"center\">";
									if($_SESSION[ '$sid_uid' ]==$row[ "user_id" ]){
										echo "&#10004;";
									}
									echo "</td>";
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