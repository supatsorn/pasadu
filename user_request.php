<?php
include( "_include_check_user_login.php" );
require_once( "_text.php" );
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];
$user_id = $_SESSION[ '$sid_uid' ];
$showStatus = false;

/// process
if ( isset( $_POST[ "check" ] ) ) {
	$number = array();
	//หา id + number วัสดุที่ขอเบิก
	foreach ( $_POST as $key => $value ) {
		$pos = strpos( $key, "number_" );
		if ( $pos === 0 ) {
			if ( $value != 0 ) {
				$tmp = substr( $key, 7 );
				$number[ $tmp ] = $value;
			}
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
	$sql = "INSERT INTO request_approve (id_name, req_number, req_id_user,req_date) VALUES ";
	$i = 0;
	foreach ( $number as $key => $value ) {
		if ( $i === 0 ) {
			$sql .= "($key, $number[$key], $user_id,'$date')";
		} else {
			$sql .= ",($key, $number[$key], $user_id,'$date')";
		}
		$i++;
	}
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
			<?php require("_user_menu.php"); ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

				<h2 class="sub-header">เบิกวัสดุ</h2>
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
					<form action="?menu=2" method="post" onsubmit="return confirm('ยืนยันการขอเบิกตามจำนวนดังกล่าวใช่หรือไม่?');">
						<table class="table table-striped table-hover">
							<thead>
								<tr class="warning">
									<th>หมวดวัสดุ</th>
									<th>รหัสรายการ</th>
									<th>รายการ</th>
									<th>คงเหลือ</th>
									<th>หน่วยนับ</th>
									<th class="col-xs-1">จำนวนเบิก</th>
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

								$sql = "select c.*,COALESCE(SUM(number), 0) as balance,d.name as category_name
from material.register as c
left join
(SELECT a.id_name,cast(a.number as SIGNED) as number
FROM material.add_data as a UNION ALL
SELECT b.id_name,b.app_number*-1
FROM material.request_approve as b UNION ALL
select d.id,d.number_low*-1
from material.register as d
) as t
on c.id=t.id_name
left join material.category as d on c.category=d.id
where c.allow=1
group by c.name
order by c.category,c.code";
								$result = $conn->query( $sql );

								if ( $result->num_rows > 0 ) {
									//found				
									while ( $row = $result->fetch_assoc() ) {
										echo "<tr>";
										echo "<td>" . $row[ "category_name" ] . "</td>";
										echo "<td>" . $row[ "code" ] . "</td>";
										echo "<td>" . $row[ "name" ] . "</td>";
										echo "<td>" . $row[ "balance" ] . "</td>";
										echo "<td>" . $row[ "unit" ] . "</td>";
										echo '<td><input type="text" name="number_' . $row[ "id" ] . '" class="form-control col-xs-2" placeholder="จำนวนขอเบิก" value="0" id="number_' . $row[ "id" ] . '"';
										if($row[ "balance" ]<1){
											echo " disabled";
										}
										echo '></td>';
										echo "</tr>";
									}
								} else {
									//not found
								}
								$conn->close();
								?>
							</tbody>
						</table>
						<div class="form-group">
							<input type="hidden" name="check" value="1"/>
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary">บันทึกข้อมูลขอเบิก</button>
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