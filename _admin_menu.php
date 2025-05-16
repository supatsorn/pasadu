<?php
//check new request
$hasNew = false;
$hasNew_want = false;
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
mysqli_set_charset( $conn, "utf8" );

$sql = "SELECT a.req_id_user as uid
FROM material.request_approve a
left join material.user b on a.req_id_user=b.id
where a.app_number is null
group by CONCAT(date(a.req_date),a.req_id_user)
order by a.req_date asc"; //where a.app_number is null
$result = $conn->query( $sql );

if ( $result->num_rows > 0 ) {
	//found
	$hasNew = true;
} else {
	//not found
	$hasNew = false;
}
//check want
$sql = "SELECT id FROM material.want where ack=0";
$result = $conn->query( $sql );

if ( $result->num_rows > 0 ) {
	//found
	$hasNew_want = true;
} else {
	//not found
	$hasNew_want = false;
}

$conn->close();
?>
<div class="col-sm-3 col-md-2 sidebar">
	<ul class="nav nav-sidebar">
		<li <?php if($_GET[ "menu"]==1) echo 'class="active"'; ?> ><a href="admin.php?menu=1">รายการคงเหลือ <?php if($_GET["menu"]==1) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<hr>
		<li <?php if($_GET[ "menu"]==2) echo 'class="active"'; ?> ><a href="admin_register.php?menu=2">ลงทะเบียนวัสดุ <?php if($_GET["menu"]==2) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<li <?php if($_GET[ "menu"]==3) echo 'class="active"'; ?> ><a href="admin_add.php?menu=3">เพิ่มวัสดุ <?php if($_GET["menu"]==3) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<li <?php if($_GET[ "menu"]==4) echo 'class="active"'; ?> ><a href="admin_category.php?menu=4">หมวดวัสดุ <?php if($_GET["menu"]==4) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<hr>
		<li <?php if($_GET[ "menu"]==5) echo 'class="active"'; ?> ><a href="admin_check_request.php?menu=5">อนุมัติจ่ายรายการขอเบิก <?php if($hasNew) echo '<img src="images/new-icon.gif"/>'; if($_GET["menu"]==5) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<li <?php if($_GET[ "menu"]==6) echo 'class="active"'; ?>><a href="admin_check_print_approve.php?menu=6">พิมพ์ใบเบิก <?php if($_GET["menu"]==6) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<li <?php if($_GET[ "menu"]==7) echo 'class="active"'; ?>><a href="admin_check_print_balance.php?menu=7">ออกรายงานคงเหลือ <?php if($_GET["menu"]==7) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<hr>
		<li <?php if($_GET[ "menu"]==8) echo 'class="active"'; ?>><a href="admin_user_want.php?menu=8">ความต้องการ <?php if($hasNew_want) echo '<img src="images/new-icon.gif"/>'; if($_GET["menu"]==8) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
		<li <?php if($_GET[ "menu"]==9) echo 'class="active"'; ?>><a href="admin_report.php?menu=9">กราฟสถิติ <?php if($_GET["menu"]==9) echo '<span class="sr-only">(current)</span>'; ?></a>
		</li>
	</ul>
	<!--<ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>-->
</div>