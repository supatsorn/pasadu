<?php
include( "_include_check_admin.php" );
require_once( "_text.php" );
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];

$showStatus = false;

if ( isset( $_POST[ "check" ] ) ) {
	require_once( "_config.php" );
	// Create connection
	$conn = new mysqli( $_H, $_U, $_P, $_DB );
	// Check connection
	if ( $conn->connect_error ) {
		die( "Connection failed: " . $conn->connect_error );
	}
	include_once( "_include_mysql_set_char.php" );
	if ( $_POST[ "check" ] == "add" ) {
		$name = $_POST[ "name" ];
		$sql = "INSERT INTO category (name) values ('$name')";
		if ( $conn->query( $sql ) === TRUE ) {
			//echo "New record created successfully";
			$showStatus = true;
		} else {
			$showStatus = false;
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	if ( $_POST[ "check" ] == "update" ) {
		$name = $_POST[ "e_name" ];
		$id = $_POST[ "e_id" ];
		$sql = "UPDATE category SET name='$name' where id=$id";
		if ( $conn->query( $sql ) === TRUE ) {
			//echo "New record created successfully";
			$showStatus = true;
		} else {
			$showStatus = false;
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
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
			<?php require("_admin_menu.php"); ?>
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
					<form class="form-horizontal" action="?menu=4" method="post">
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
											echo "<td>" . $row[ "name" ] . '<input type="hidden" id="n_' . $row[ "id" ] . '" value="' . $row[ "name" ] . '"></td>';
											echo '<td align="center"><a href="#" class="btn btn-warning" onClick="edit(' . $row[ "id" ] . ');">แก้ไข</a><input type="hidden" id="c_' . $row[ "id" ] . '" value="' . $row[ "id" ] . '"></td>';
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
										<td><input type="hidden" name="check" value="add"><button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
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

	<!-- Modal -->
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><b>แก้ไขข้อมูล</b></h4>
				</div>
				<div class="modal-body">
					<div class="form-inline">
						<form id="f1" action="admin_category.php?menu=4" method="post">
							<div class="text-center">
								<input type="text" class="form-control" name="e_name" id="e_name">
								<input type="hidden" name="e_id" id="e_id">
								<input type="hidden" name="check" value="update">
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="$('#f1').submit();">บันทึกข้อมูล</button>
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
		$( "button[type=submit]" ).click( function ( e ) {
			if ( $( '#name' ).val() == "" ) {
				return false;
			}
		} );

		function edit( v ) {
			var id = "#c_" + v;
			var name = "#n_" + v;
			$( '#e_id' ).val( $( id ).val() );
			$( '#e_name' ).val( $( name ).val() );
			$( '#myModal1' ).modal();
		}
	</script>
</body>

</html>