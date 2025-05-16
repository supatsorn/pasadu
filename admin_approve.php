<?php
include( "_include_check_admin.php" );
require_once("_text.php");
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];

$showStatus = false;
if ( isset( $_POST[ "check" ] ) ) {
	$number = array();
	$note= array();
	//หา id + number วัสดุที่จ่าย
	foreach ( $_POST as $key => $value ) {
		$pos = strpos( $key, "number_" );
		if ( $pos === 0 ) {
			$tmp = substr( $key, 7 );
			$number[ $tmp ] = $value;
		}
	}
	//หา id + number วัสดุที่จ่าย
	foreach ( $_POST as $key => $value ) {
		$pos = strpos( $key, "note_" );
		if ( $pos === 0 ) {
			$tmp = substr( $key, 5 );
			$note[ $tmp ] = $value;
		}
	}
	$date = date( 'Y-m-d H:i:s' );
	require_once( "_config.php" );
	// Create connection
	$conn = new mysqli( $_H, $_U, $_P, $_DB );
	// Check connection
	if ( $conn->connect_error ) {
		die( "Connection failed: " . $conn->connect_error );
	}
	include_once( "_include_mysql_set_char.php" );
	foreach ( $number as $key => $value ) {
		$sql = "UPDATE request_approve SET app_number=$number[$key], app_date='$date',app_note='$note[$key]' where id=$key";
		if ( $conn->query( $sql ) === TRUE ) {
			$showStatus = true;
		} else {
			$showStatus = false;
			echo "<br>Error: " . $sql . "<br>" . $conn->error;
		}
	}
	$conn->close();
	if ( $showStatus ) {
		header( "Location: ./admin_check_request.php?menu=5&chk=ok" );
		exit;
		return;
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
			<?php require("_admin_menu.php"); require_once( "_my_function.php" );?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

				<h3 class="sub-header text-center">รายการขอเบิกของ <?php echo $_GET['name']; ?> ใน<?php echo toDateThaiFull($_GET['d']); ?></h3>
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
					<form action="?menu=5&d=<?php echo $_GET['d']; ?>&name=<?php echo $_GET['name']; ?>&uid=<?php echo $_GET['uid']; ?>" method="post">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>หมวดวัสดุ</th>
									<th>รหัสรายการ</th>
									<th>รายการ</th>
									<th>คงเหลือ</th>
									<th>หน่วยนับ</th>
									<th>สถานะ</th>
									<th>จำนวนขอเบิก</th>
									<th>จำนวนจ่าย</th>
									<th>หมายเหตุ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								require( "_config.php" );
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
								//clear table
								$sql = "TRUNCATE TABLE balance";
								if ( $conn->query( $sql ) === TRUE ) {
									//add balance tmp table
									$sql = "insert into balance (id,code,name,unit,number_low,allow,reg_date,category,balance) select c.*,COALESCE(SUM(number), 0) as balance
from material.register as c
left join
(SELECT a.id_name,cast(a.number as SIGNED) as number
FROM material.add_data as a UNION ALL
SELECT b.id_name,b.app_number*-1
FROM material.request_approve as b UNION ALL
select d.id,d.number_low*-1
from material.register as d) as t
on c.id=t.id_name
group by c.name
order by c.name";
									if ( $conn->query( $sql ) === TRUE ) {
										//query data
										$sql = "select z.id as pk,a.name as name,a.unit as unit,a.allow as allow,a.balance as balance,z.req_number as req, c.name as category,a.code as code 
from material.request_approve as z
inner join material.balance as a on a.id=z.id_name
left join category as c on a.category=c.id
where z.app_number is null and z.head_app=1 and z.req_id_user=" . $_GET[ "uid" ] . " and date(z.req_date)='" . $_GET[ "d" ] . "'
order by c.id,a.code asc";
										$result = $conn->query( $sql );

										if ( $result->num_rows > 0 ) {
											//found				
											while ( $row = $result->fetch_assoc() ) {
												echo "<tr>";
												echo "<td>" . $row[ "category" ] . "</td>";
												echo "<td>" . $row[ "code" ] . "</td>";
												echo "<td>" . $row[ "name" ] . "</td>";
												echo "<td>" . $row[ "balance" ] . "</td>";
												echo "<td>" . $row[ "unit" ] . "</td>";
												if ( $row[ "allow" ] == 1 ) {
													echo "<td>อนุญาตให้เบิก</td>";
												} else {
													echo "<td><b>ไม่อนุญาต</b>ให้เบิก</td>";
												}
												echo "<td>" . $row[ "req" ] . "</td>";
												echo '<td><input type="text" name="number_' . $row[ "pk" ] . '" class="form-control col-xs-1 col-sm-1 col-md-1 col-lg-1" placeholder="จำนวนจ่าย" value="0" id="number_' . $row[ "pk" ] . '"></td>';
												echo '<td><input type="text" name="note_' . $row[ "pk" ] . '" class="form-control col-xs-2" placeholder="หมายเหตุ" id="note_' . $row[ "pk" ] . '"></td>';
												echo "</tr>";
											}
										} else {
											//not found
										}
									} else {
										//error add balance
										echo "Error: " . $sql . "<br>" . $conn->error;
									}
								} else {
									//error clear table
									echo "Error: " . $sql . "<br>" . $conn->error;
								}

								$conn->close();
								?>
							</tbody>
						</table>
						<div class="form-group">
							<input type="hidden" name="check" value="1"/>
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary">บันทึกข้อมูลการอนุมัติจ่าย</button>
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
		var req_num = [];
		$( "form" ).keypress( function ( e ) {
			//Enter key
			if ( e.which == 13 ) {
				return false;
			}
		} );
		// เอาไว้เช็คว่าเบิกเกินหรือไม่
		/*$( 'form' ).on( 'submit', function ( event ) {
			event.preventDefault();
			$("[id^=number_]").each(function () {
    			req_num.push($(this).val());
  			});
  			alert(req_num);
			this.submit(); //now submit the form
		} );*/
	</script>
</body>

</html>