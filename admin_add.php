<?php
include( "_include_check_admin.php" );
require_once("_text.php");
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];
$showStatus = false;
$unit_arr = array();

/// process
if ( isset( $_GET[ "check" ] ) ) {
	$name_id = $_GET[ "name_id" ];
	$number = $_GET[ "number" ];
	$price_unit = $_GET[ "price_unit" ];
	$total = $number * $price_unit;
	$date_buy = $_GET[ "date_buy" ];
	/*if ( isset( $_GET[ "remark" ] ) )*/$note = $_GET[ "remark" ];
	require_once( "_config.php" );
	// Create connection
	$conn = new mysqli( $_H, $_U, $_P, $_DB );
	// Check connection
	if ( $conn->connect_error ) {
		die( "Connection failed: " . $conn->connect_error );
	}
	include_once( "_include_mysql_set_char.php" );
	$sql = "INSERT INTO add_data (id_name, number, unit_price,total_price,buy_date,note)
VALUES ($name_id, $number, $price_unit,$total,'$date_buy','$note')";

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
				<h2 class="sub-header">เพิ่มวัสดุ</h2>
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
					<form class="form-horizontal" action="#">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">รายการ</label>
							<div class="col-sm-4">
								<select name="name_id" id="name_option">
									<option value="-1">- เลือกรายการ -</option>
									<?php
									require_once( "_config.php" );
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
									include_once( "_include_mysql_set_char.php" );
									//mysqli_set_charset($conn, "utf8");

									$sql = "SELECT id,name,unit FROM register order by name asc";
									$result = $conn->query( $sql );

									if ( $result->num_rows > 0 ) {
										//found				
										while ( $row = $result->fetch_assoc() ) {
											$unit_arr[ $row[ "id" ] ] = $row[ "unit" ];
											echo '<option value="' . $row[ "id" ] . '">' . $row[ "name" ] . '</option>';
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
							<label for="unit" class="col-sm-3 control-label">หน่วยนับ</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="unit" id="unit" placeholder="หน่วยนับ" disabled>
							</div>
						</div>
						<div class="form-group">
							<label for="number" class="col-sm-3 control-label">จำนวน</label>
							<div class="col-sm-1">
								<input type="text" name="number" class="form-control col-xs-2" id="number" placeholder="จำนวน">
							</div>
						</div>
						<div class="form-group">
							<label for="price_unit" class="col-sm-3 control-label">ราคาต่อหน่วย</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="price_unit" id="price_unit" placeholder="ราคาต่อหน่วย">
							</div>
						</div>
						<div class="form-group">
							<label for="date_buy" class="col-sm-3 control-label">วันที่ซื้อ</label>
							<div class="col-sm-2">
								<input type="text" class="form-control" name="date_buy" id="date_buy" value="<?php echo date(" Y-m-d "); ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="remark" class="col-sm-3 control-label">หมายเหตุ</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="remark" id="remark" placeholder="หมายเหตุ" value="">
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" name="check" value="1"/>
							<input type="hidden" name="menu" value="3"/>
							<div class="col-sm-offset-2 col-sm-10">
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
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
	<script src="js/holder.js"></script>
	<script type="text/javascript">
		var unit_arr = <?php echo json_encode($unit_arr).";"; ?>
		$( '#name_option' ).change( function () {
			var a = $( this ).val();
			$( '#unit' ).val( unit_arr[ "" + a ] );
		} );
		$( "button[type=submit]" ).click( function ( e ) {
			if ( $( '#name_option' ).val() == -1 ) {
				return false;
			}
		} );
		$( "form" ).keypress( function ( e ) {
			//Enter key
			if ( e.which == 13 ) {
				return false;
			}
		} );
		$( function () {
			$( "#date_buy" ).datepicker( {
				dateFormat: 'yy-mm-dd'
			} );
		} );
	</script>
</body>

</html>