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
			<?php 
			require("_admin_menu.php"); 
			require_once( "_my_function.php" );
			?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h2 class="sub-header">สถิติการเบิก-จ่ายในเดือน <?php echo toMonthFromInt($_POST["sM1"]); echo " ".$_POST['sY1']?></h2>
				<div class="col-sm-12">
					<canvas id="myChart" width="400" height="100"></canvas>
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
	<script src="js/Chart.min.js"></script>
	<?php
	require( "_config.php" );
	$y = $_POST[ "sY1" ];
	$y = $y - 543;
	$m = $_POST[ "sM1" ];
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

	$sql = "select a.id_name as id, b.name as name,sum(req_number) as req,sum(app_number) as app
from material.request_approve as a
left join material.register as b on a.id_name=b.id
where date(a.req_date) between '$y-$m-01' and '$y-$m-31'
group by id_name
order by req desc";
	$result = $conn->query( $sql );
	$data = null;
	$data1 = null;
	$data2 = null;

	if ( $result->num_rows > 0 ) {
		//found				
		$data = array();
		$data1 = array();
		$data3 = array();
		$i = 0;
		while ( $row = $result->fetch_assoc() ) {
			if($row[ "req" ]==0){
				continue;
			}
			$data[ $i ] = $row[ "name" ];
			$data1[ $i ] = $row[ "req" ];
			$data2[ $i ] = $row[ "app" ];
			$i++;
			//echo $row[ "name" ].",";
			//echo $row[ "req" ].",";
			//echo $row[ "app" ].",";
		}
	} else {
		//not found
	}
	$conn->close();
	?>
	<script>
		var ctx = document.getElementById( "myChart" ).getContext( '2d' );
		var myChart = new Chart( ctx, {
			type: 'bar',
			data: {
				//labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
				<?php
		if(count($data)==1){
			echo 'labels: ["'.$data[0].'"],';
		}else{
			echo 'labels: ["'.$data[0].'"';
			for($i=1; $i<count($data); $i++){
				echo ',"'.$data[$i].'"';
			}
			echo '],';
		}
		?>
				datasets: [ {
					label: 'จำนวนขอเบิก',
					//data: [ 12, 19, 3, 5, 2, 3 ],
					<?php
		if(count($data1)==1){
			echo 'data: ["'.$data1[0].'"],';
		}else{
			echo 'data: ["'.$data1[0].'"';
			for($i=1; $i<count($data1); $i++){
				echo ',"'.$data1[$i].'"';
			}
			echo '],';
		}
		?>
					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				},
						  {
					label: 'จำนวนจ่าย',
					//data: [ 12, 19, 3, 5, 2, 3 ],
					<?php
		if(count($data1)==1){
			echo 'data: ["'.$data2[0].'"],';
		}else{
			echo 'data: ["'.$data2[0].'"';
			for($i=1; $i<count($data2); $i++){
				echo ',"'.$data2[$i].'"';
			}
			echo '],';
		}
		?>
					backgroundColor: 'rgba(54, 162, 235, 0.2)',
					borderColor: 'rgba(54, 162, 235, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [ {
						ticks: {
							beginAtZero: true
						}
					} ]
				}
			}
		} );
	</script>
</body>

</html>