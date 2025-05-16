<?php
include("_include_check_admin.php");
require_once("_text.php");
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];
$showStatus = false;

/// process
if ( isset( $_GET[ "check" ] ) ) {
	$name = $_GET[ "name" ];
	$unit = $_GET[ "unit" ];
	$code = $_GET[ "code" ];
	$allow = $_GET[ "allow" ];
	$category = $_GET[ "category" ];
	$number_low = $_GET[ "number_low" ];
	require( "_config.php" );
	// Create connection
	$conn = new mysqli( $_H, $_U, $_P, $_DB );
	// Check connection
	if ( $conn->connect_error ) {
		die( "Connection failed: " . $conn->connect_error );
	}
mysqli_query($conn,'SET character_set_results=utf8');
mysqli_query($conn,'SET names=utf8');  
mysqli_query($conn,'SET character_set_client=utf8');
mysqli_query($conn,'SET character_set_connection=utf8');   
mysqli_query($conn,'SET character_set_results=utf8');   
mysqli_query($conn,'SET collation_connection=utf8_general_ci');

	$sql = "INSERT INTO register (name, unit, number_low,allow,reg_date,category,code)
VALUES ('$name', '$unit', $number_low,$allow,NOW(),$category, '$code')";

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
				<h2 class="sub-header">ลงทะเบียนวัสดุ</h2>
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
									<input type="text" class="form-control" name="name" id="name" placeholder="ชื่อวัสดุ" autofocus>								
							</div>
						</div>
						<div class="form-group">
							<label for="unit" class="col-sm-3 control-label">หน่วยนับ</label>
							<div class="col-sm-2">
									<input type="text" class="form-control" name="unit" id="unit" placeholder="หน่วยนับ">								
							</div>
						</div>
						<div class="form-group">
							<label for="code" class="col-sm-3 control-label">รหัสรายการ</label>
							<div class="col-sm-2">
									<input type="text" class="form-control" name="code" id="code" placeholder="รหัสรายการ">								
							</div>
						</div>
						<div class="form-group">
							<label for="category" class="col-sm-3 control-label">หมวดวัสดุ</label>
							<div class="col-sm-4">
								<select name="category" id="category_option">
									<option value="0">- เลือกหมวด -</option>
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
									include( "_include_mysql_set_char.php" );
									//mysqli_set_charset($conn, "utf8");

									$sql = "SELECT id,name FROM category order by name asc";
									$result = $conn->query( $sql );

									if ( $result->num_rows > 0 ) {
										//found				
										while ( $row = $result->fetch_assoc() ) {
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
							<label for="number" class="col-sm-3 control-label">จำนวนเหลือต่ำสุดที่เบิกได้</label>
							<div class="col-sm-1">
								<input type="text" name="number_low" class="form-control col-xs-2" id="number_low" value="0" placeholder="จำนวน">
							</div>
						</div>
						<div class="form-group">
							<label for="price" class="col-sm-3 control-label">สถานะการให้เบิก</label>
							<div class="col-sm-5">
								<label class="radio-inline">
									<input type="radio" name="allow" id="inlineRadio1" value="1" checked>เบิก&nbsp;&nbsp;&nbsp;
								</label>
								<label class="radio-inline">
									<input type="radio" name="allow" id="inlineRadio2" value="0">งดเบิก
								</label>
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" name="check" value="1"/>
							<input type="hidden" name="menu" value="2"/>
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
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
		/*function textClick() {
			$( "#name2" ).prop( 'disabled', true );
			$( "#name" ).prop( 'disabled', false );
		}

		function selectClick() {
			$( "#name" ).prop( 'disabled', true );
			$( "#name2" ).prop( 'disabled', false );
		}

		function text2Click() {
			$( "#unit2" ).prop( 'disabled', true );
			$( "#unit" ).prop( 'disabled', false );
		}

		function select2Click() {
			$( "#unit" ).prop( 'disabled', true );
			$( "#unit2" ).prop( 'disabled', false );
		}*/
		$( "form" ).keypress( function ( e ) {
			//Enter key
			if ( e.which == 13 ) {
				return false;
			}
		} );
	</script>
</body>

</html>