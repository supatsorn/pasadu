<?php
include( "_include_check_admin.php" );
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
			<?php require("_admin_menu.php"); ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

				<h2 class="sub-header">กราฟรายงานสถิติ</h2>
				<div class="col-sm-12">
					<div class="col-sm-4"><button type="button" class="col-sm-12 btn btn-success" onClick="$('#myModal1').modal();">สถิติการเบิก-จ่ายในแต่ละเดือน</button>
					</div>
					<div class="col-sm-4"><button type="button" class="col-sm-12 btn btn-success" onClick="$('#myModal2').modal();">สถิติการเบิก-จ่ายในแต่ละไตรมาส</button>
					</div>
					<div class="col-sm-4"><button type="button" class="col-sm-12 btn btn-success" onClick="$('#myModal3').modal();">สถิติการเบิก-จ่ายในแต่ละปี</button>
					</div>
				</div>
				<br>
				<br>
				<br>
				<div class="col-sm-12">
					<div class="col-sm-4"><button type="button" class="col-sm-12 btn btn-success" onClick="$('#myModal4').modal();">สถิติการเบิก-ตามระบุ</button>
					</div>
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
					<h4 class="modal-title" id="myModalLabel"><b>สถิติการเบิก-จ่ายในแต่ละเดือน</b></h4>
				</div>
				<div class="modal-body">
					<div class="form-inline">
						<form id="f1" action="admin_report11.php?menu=9" method="post" target="_blank">
							ระบุ ปี เดือน ที่ต้องการ :
							<select name='sY1' id='sY1'>
								<?php
								$xYear = date( 'Y' ) + 543; // เก็บค่าปีปัจจุบันไว้ในตัวแปร
								echo '<option value="' . $xYear . '">' . $xYear . '</option>'; // ปีปัจจุบัน
								for ( $i = 1; $i <= 10; $i++ ) {
									echo '<option value="' . ( $xYear - $i ) . '">' . ( $xYear - $i ) . '</option>';
								}
								?>
							</select>
							<select name='sM1' id='sM1'>
								<option value="01">มกราคม</option>
								<option value="02">กุมภาพันธ์</option>
								<option value="03">มีนาคม</option>
								<option value="04">เมษายน</option>
								<option value="05">พฤษภาคม</option>
								<option value="06">มิถุนายน</option>
								<option value="07">กรกฎาคม</option>
								<option value="08">สิงหาคม</option>
								<option value="09">กันยายน</option>
								<option value="10">ตุลาคม</option>
								<option value="11">พฤศจิกายน</option>
								<option value="12">ธันวาคม</option>
							</select>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="$('#f1').submit();">ตกลง</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal 2-->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><b>สถิติการเบิก-จ่ายในแต่ละไตรมาส</b></h4>
				</div>
				<div class="modal-body">
					<div class="form-inline">
						<form id="f2" action="admin_report12.php?menu=9" method="post" target="_blank">
							ระบุ ปี ไตรมาส ที่ต้องการ :
							<select name='sY2' id='sY2'>
								<?php
								$xYear = date( 'Y' ) + 543; // เก็บค่าปีปัจจุบันไว้ในตัวแปร
								echo '<option value="' . $xYear . '">' . $xYear . '</option>'; // ปีปัจจุบัน
								for ( $i = 1; $i <= 10; $i++ ) {
									echo '<option value="' . ( $xYear - $i ) . '">' . ( $xYear - $i ) . '</option>';
								}
								?>
							</select>
							<select name='sM2' id='sM2'>
								<option value="1">ไตรมาสที่ 1</option>
								<option value="2">ไตรมาสที่ 2</option>
								<option value="3">ไตรมาสที่ 3</option>
								<option value="4">ไตรมาสที่ 4</option>
							</select>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="$('#f2').submit();">ตกลง</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal 3-->
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><b>สถิติการเบิก-จ่ายในแต่ละปี</b></h4>
				</div>
				<div class="modal-body">
					<div class="form-inline">
						<form id="f3" action="admin_report13.php?menu=9" method="post" target="_blank">
							ระบุปีที่ต้องการ :
							<select name='sY3' id='sY3'>
								<?php
								$xYear = date( 'Y' ) + 543; // เก็บค่าปีปัจจุบันไว้ในตัวแปร
								echo '<option value="' . $xYear . '">' . $xYear . '</option>'; // ปีปัจจุบัน
								for ( $i = 1; $i <= 10; $i++ ) {
									echo '<option value="' . ( $xYear - $i ) . '">' . ( $xYear - $i ) . '</option>';
								}
								?>
							</select>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="$('#f3').submit();">ตกลง</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal 4-->
	<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><b>สถิติการเบิก-ตามช่วงที่กำหนด</b></h4>
				</div>
				<div class="modal-body">
					<div class="form-inline">
						<form id="f4" action="admin_report21.php?menu=9" method="post" target="_blank">
							ตั้งแต่วันที่ : <input type="text" class="form-control" name="date_from" id="date_from" value="<?php echo date(" Y-m-d "); ?>">
							&nbsp;&nbsp;&nbsp;
							ถึงวันที่ : <input type="text" class="form-control" name="date_to" id="date_to" value="<?php echo date(" Y-m-d "); ?>">							
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" onClick="$('#f4').submit();">ตกลง</button>
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
		$( function () {
			$( "#date_from" ).datepicker( {
				dateFormat: 'yy-mm-dd'
			} );
			$( "#date_to" ).datepicker( {
				dateFormat: 'yy-mm-dd'
			} );
		} );
	</script>
</body>

</html>