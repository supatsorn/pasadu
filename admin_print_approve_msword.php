<?php
include( "_include_check_admin.php" );
require_once( "_text.php" );
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];

if ( !isset( $_GET[ "uid" ] ) ) {
	return;
	exit;
}
require_once( "_my_function.php" );
header( "Content-type: application/vnd.ms-word" );
header( "Content-Disposition: attachment; filename=print.doc" );
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>
		<?php echo $_HTML_TEXT_TITLE; ?>
	</title>
	<style type="text/css">
		@page my {
			size: A4 portrait;
			margin: 1.0cm 1.25cm 1.0cm 1.25cm;
		}
		
		body {
			font-size: 14pt;
			font-family: 'TH SarabunPSK', sans-serif;
		}
		
		table .mytable {
			border: solid #000 !important;
			border-width: 1px 0 0 1px !important;
		}
		
		.mytable th,
		.mytable td {
			border: solid #000 !important;
			border-width: 0 1px 1px 0 !important;
		}
		
		.mytable tbody td {
			padding-left: 0.2cm;
			padding-right: 0.1cm;
		}
		
		p {
			margin: 0;
			padding: 0;
		}
	</style>
</head>

<body>
	<div class="my">
		<p align="center" style="margin-bottom: 5mm; font-size: 20pt;"><b>ใบเบิกวัสดุ <?php echo $_HTML_TEXT_COURT_NAME ?></b>
		</p>
		<p align="center">ชื่อ
			<?php echo $_GET["name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $_GET["dep"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo toDateThaiHalfFull($_GET["req_d"]); ?>
		</p>
		<table width="100%" class="mytable" cellspacing="0" border="1" bordercolor="black">
			<thead>
				<tr>
					<th style="width: 1.5cm;">ลำดับที่</th>
					<th>หมวดวัสดุ</th>
					<th>รหัส</th>
					<th>รายการ</th>
					<th>หน่วยนับ</th>
					<th>จำนวนเบิก</th>
					<th>จำนวนจ่าย</th>
					<th>หมายเหตุ</th>
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
				$sql = "select b.name as n,a.req_number as rnumb,a.app_number as anumb,a.app_note as note,d.name as category_name,b.code as code,b.unit as unit
from material.request_approve as a
left join material.register as b on a.id_name=b.id
left join material.category as d on b.category=d.id
where a.req_id_user=" . $_GET[ "uid" ] . " and date(a.req_date)='" . $_GET[ "req_d" ] . "' and date(a.app_date)='" . $_GET[ "app_d" ] . "'
order by b.category,b.code asc";
				//echo $sql;
				$result = $conn->query( $sql );

				if ( $result->num_rows > 0 ) {
					//found
					$i = 1;
					while ( $row = $result->fetch_assoc() ) {
						echo "<tr>";
						echo "<td align=\"center\">" . $i++ . "</td>";
						echo "<td>" . $row[ "category_name" ] . "</td>";
						echo "<td>" . $row[ "code" ] . "</td>";
						echo "<td>" . $row[ "n" ] . "</td>";
						echo "<td>" . $row[ "unit" ] . "</td>";
						echo "<td align=\"center\">" . $row[ "rnumb" ] . "</td>";
						echo "<td align=\"center\">" . $row[ "anumb" ] . "</td>";
						echo "<td>" . $row[ "note" ] . "</td>";
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
		<?php
		require_once( "_config.php" );
		// Create connection
		$conn = new mysqli( $_H, $_U, $_P, $_DB );
		// Check connection
		if ( $conn->connect_error ) {
			die( "Connection failed: " . $conn->connect_error );
		}
		include( "_include_mysql_set_char.php" );
		$sql = "select u1.name as name,u1.position as pos from material.user as u left join material.user as u1 on u.head_id=u1.id where u.id=" . $_GET[ "uid" ];
		//echo $sql;
		$result = $conn->query( $sql );
		$h_name = "";
		$h_pos = "";
		if ( $result->num_rows > 0 ) {
			//found
			$i = 1;
			while ( $row = $result->fetch_assoc() ) {
				$h_name = $row[ "name" ];
				$h_pos = $row[ "pos" ];
			}
		} else {
			//not found
		}
		$conn->close();
		?>
		<table width="100%" border="0" style="text-align: center;">
			<tbody>
				<tr>
					<td align="left" width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ขออนุมัติเบิกวัสดุสำนักงานตามรายการข้างต้นเพื่อใช้ในงานราชการ</td>
					<td width="50%"></td>
				</tr>
				<tr>
					<td align="left">สำหรับ
						<?php echo $_GET["dep"]; ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>ลงชื่อ..................................................ผู้เบิก/ผู้รับ</td>
					<td></td>
				</tr>
				<tr>
					<td>(&nbsp;
						<?php echo $_GET["name"]; ?>&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>ตำแหน่ง&nbsp;
						<?php echo $_GET["pos"]; ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;พิจารณารายการขอเบิกวัสดุแล้ว เห็นควรขอเบิกตามรายการข้างต้น เพื่อใช้ในงานราชการ และแจ้งกลุ่มงานคลังเพื่อดำเนินการต่อไป</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>ลงชื่อ..................................................หัวหน้ากลุ่มงาน</td>
					<td></td>
				</tr>
				<tr>
					<td>(&nbsp;
						<?php echo $h_name; ?>&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td></td>
				</tr>
				<tr>
					<td>ตำแหน่ง&nbsp;
						<?php echo $h_pos; ?>
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<table width="100%" border="0" style="text-align: center;">
			<tbody>
				<tr>
					<td colspan="2" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;พิจารณารายการขอเบิกวัสดุแล้ว เห็นควรอนุมัติเบิกจ่ายให้ตามรายการที่เสนอ</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="2" align="left">หากรายการใดที่ขอเบิกไม่มีในวัสดุคงเหลือ ให้รอเบิกในรอบการจัดซื้อครั้งต่อไป</td>
					<td rowspan="3" style="vertical-align: top;font-size:18pt; border: solid #000; border-width: 1px 1px 0 1px;">เบิกจ่ายวัสดุสำนักงานแล้ว</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td width="50%">ลงชื่อ..................................................ผู้อนุมัติรายการเบิก</td>
					<td width="15%"></td>
				</tr>
				<tr>
					<td>(&nbsp;
						<?php echo $_HTML_TEXT_HEAD_FINANCE_NAME ?>&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td></td>
					<td rowspan="2" style="border: solid #000; border-width: 1px 1px 1px 1px; border-top: dotted #000;">(&nbsp;
						<?php echo $_HTML_TEXT_STOCK_NAME ?>&nbsp;)
						<br>(&nbsp;
						<?php echo $_HTML_TEXT_STOCK_POS ?>&nbsp;)</td>
				</tr>
				<tr>
					<td>ตำแหน่ง&nbsp;
						<?php echo $_HTML_TEXT_HEAD_FINANCE_POS; ?>
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<p>&nbsp;</p>
	</div>
</body>

</html>