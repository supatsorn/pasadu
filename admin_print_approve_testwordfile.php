<?php
include( "_include_check_admin.php" );
require_once("_text.php");
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];

if ( !isset( $_GET[ "uid" ] ) ) {
	return;
	exit;
}
header( "Content-type: application/vnd.ms-word" );
header( "Content-Disposition: attachment; filename=print.doc" );
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo $_HTML_TEXT_TITLE; ?></title>
	<style type="text/css">
		@page my {
			size: A4 portrait;
			margin: 1.0cm 1.25cm 1.0cm 1.25cm;
		}
		
		div.my {
			page: my;
		}
		
		body {
			font-size: 16pt;
			font-family: 'TH SarabunPSK', sans-serif;
		}
		
		.mytable tbody td {
			padding-left: 0.2cm;
			padding-right: 0.1cm;
		}
	</style>
</head>

<body>
	<div class="my">
		<p align="center" style="font-size: 22pt;"><b>ใบเบิกวัสดุ</b>
		</p>
		<p align="left"><b>เรียน ผู้อำนวยการสำนักงานประจำศาลแขวงชลบุรี</b>
		</p>
		<p align="left" style="padding-left: 5em;">ข้าพเจ้าขอเบิกวัสดุตามรายการที่แจ้งมาพร้อมนี้ เพื่อใช้ในกลุ่มงาน/ฝ่าย <?php echo $_GET[ "dep" ]; ?></p>
		<table width="100%" class="mytable" cellspacing="0" border="1" bordercolor="black">
			<thead>
				<tr>
					<th rowspan="2" scope="col" style="width: 1.5cm;">ลำดับที่</th>
					<th rowspan="2" scope="col">รายการ</th>
					<th colspan="2" scope="col">จำนวน</th>
					<th scope="col">หมายเหตุ</th>
				</tr>
				<tr>
					<!--<td style="width: 3.1cm;" align="center"><b>คงเหลือไว้ใช้งาน</b>
					</td>-->
					<td style="width: 2cm;" align="center"><b>ขอเบิก</b>
					</td>
					<td style="width: 2cm;" align="center"><b>จ่าย</b>
					</td>
					<td>&nbsp;</td>
				</tr>
			</thead>
			<tbody>
				<?php
				require_once( "_config.php" );
				// Create connection
				$conn = new mysqli( $_H, $_U, $_P, $_DB );
				// Check connection
				if ( $conn->connect_error ) {
					die( "Connection failed: " . $conn->connect_error );
				}
				include_once( "_include_mysql_set_char.php" );
				$sql = "select b.name as n,a.req_number as rnumb,a.app_number as anumb
from material.request_approve as a
left join material.register as b on a.id_name=b.id
where a.req_id_user=" . $_GET[ "uid" ] . " and date(a.req_date)='" . $_GET[ "req_d" ] . "' and date(a.app_date)='" . $_GET[ "app_d" ] . "'
order by b.name asc";
				//echo $sql;
				$result = $conn->query( $sql );

				require_once( "_my_function.php" );
				if ( $result->num_rows > 0 ) {
					//found
					$i = 1;
					while ( $row = $result->fetch_assoc() ) {
						echo "<tr>";
						echo "<td align=\"center\">" . $i++ . "</td>";
						echo "<td>" . $row[ "n" ] . "</td>";
						echo "<td align=\"center\">" . $row[ "rnumb" ] . "</td>";
						echo "<td align=\"center\">" . $row[ "anumb" ] . "</td>";
						echo "<td>&nbsp;</td>";
						echo "</tr>";
					}
				} else {
					//not found
				}
				$conn->close();
				?>
			</tbody>
		</table>
		<br/><br/>
		<table width="100%" border="0" style="text-align: center;">
			<tbody>
				<tr>
					<td colspan="2">ลงชื่อ..................................................ผู้เบิก/ผู้รับ</td>
				</tr>
				<tr>
					<td colspan="2">(&nbsp;<?php echo $_GET["name"]; ?>&nbsp;)</td>
				</tr>
				<tr>
					<td colspan="2">ตำแหน่ง&nbsp;<?php echo $_GET["pos"]; ?></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo toDateThaiHalfFull($_GET["req_d"]); ?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td width="50%">ลงชื่อ..................................................ผู้สั่งจ่าย</td>
					<td width="50%">ลงชื่อ..................................................ผู้จ่าย</td>
				</tr>
				<tr>
					<td>(นางเสาวภาพร  สิขิวัฒน์)</td>
					<td>(&nbsp;<?php echo $name; ?>&nbsp;)</td>
				</tr>
				<tr>
					<td>ตำแหน่ง ผู้อำนวยการสำนักงานประจำศาลแขวงชลบุรี</td>
					<td>ตำแหน่ง&nbsp;<?php echo $pos; ?></td>
				</tr>
				<tr>
					<td>วัน/เดือน/ปี .........................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><?php echo toDateThaiHalfFull($_GET["app_d"]); ?></td>
				</tr>
			</tbody>
		</table>
		<p>&nbsp;</p>
	</div>
</body>

</html>