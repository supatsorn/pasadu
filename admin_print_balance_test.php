<?php
include( "_include_check_admin.php" );
require_once("_text.php");
$name = $_SESSION[ '$sid_name' ];
$pos = $_SESSION[ '$sid_position' ];
$date="";
$year="";
if ( !isset( $_POST[ "date" ] ) ) {
	return;
	exit;
}
else{
	$date = $_POST[ "date" ];	
	$d = date_parse_from_format("Y-m-d", $date);
	if($d["month"]>9){
		$year=$d["year"]+544;
	}else{
		$year=$d["year"]+543;
	}
}
require_once( "_my_function.php" );
require_once dirname(__FILE__).'/mpdf/vendor/autoload.php';
$mpdf = new mPDF();
ob_start();
?>

<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo $_HTML_TEXT_TITLE; ?></title>
	<style type="text/css">
		@page {
			size: portrait;
			margin-top:20mm;
			margin-right: 15mm;
			margin-bottom: 15mm;
			margin-left: 25mm;
		}
		body {
			font-size: 14pt;
			font-family: "THSarabun";
		}
				
		table .mytable{
    		border:solid #000 !important;
    		border-width:1px 0 0 1px !important;
		}
		.mytable th, .mytable td {
    		border:solid #000 !important;
    		border-width:0 1px 1px 0 !important;
		}
		
		.mytable tbody td {
			padding-left: 0.2cm;
			padding-right: 0.1cm;
		}
		p{
			margin: 0;
			padding: 0;
		}
	</style>
</head>

<body>
	<div class="my">
		<p align="center" style="font-size: 18pt;"><b><?php echo $_HTML_TEXT_COURT_NAME ?></b></p>
		<p align="center" style="font-size: 18pt;"><b>รายงานวัสดุคงเหลือ</b></p>
		<p align="center" style="font-size: 18pt;"><b>ณ <?php echo toDateThaiHalfFull($date); ?> ประจำปีงบประมาณ <?php echo $year; ?></b></p>		
		<table width="100%" class="mytable" cellspacing="0" border="1" bordercolor="black">
			<thead>
				<tr>
					<th style="width: 1.5cm;">ลำดับที่</th>
					<th>หมวดวัสดุ</th>
					<th>รายการ</th>
					<th>หน่วยนับ</th>
					<th>คงเหลือ</th>
					<th>ราคาต่อหน่วย</th>
					<th>จำนวนเงิน</th>
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
				include( "_include_mysql_set_char.php" );
				$sql = "select c.*,COALESCE(SUM(number1), 0) as balance,d.name as category_name,e.unit_price as price,e.note as note
from material.register as c
left join
(SELECT a.id_name,cast(a.number as SIGNED) as number1
FROM material.add_data as a where a.buy_date <='$date' UNION ALL
SELECT b.id_name,b.app_number*-1
FROM material.request_approve as b where app_date <='$date') as t
on c.id=t.id_name
left join material.category as d on c.category=d.id
left join (select * from material.add_data where id in(select max(id) from material.add_data group by id_name)) as e on c.id=e.id_name
group by c.name
order by c.category,c.code";
				//echo $sql;
				$result = $conn->query( $sql );
				$sum_all=0;
				if ( $result->num_rows > 0 ) {
					//found
					$i = 1;
					while ( $row = $result->fetch_assoc() ) {
						$sum=$row[ "balance" ]*$row[ "price" ];
						echo "<tr>";
						echo "<td align=\"center\">" . $i++ . "</td>";
						echo "<td>" . $row[ "category_name" ] . "</td>";
						echo "<td>" . $row[ "name" ] . "</td>";						
						echo "<td>" . $row[ "unit" ] . "</td>";
						echo "<td align=\"right\">" . $row[ "balance" ] . "</td>";
						//echo "<td align=\"right\">" . $row[ "price" ] . "</td>";
						echo "<td align=\"right\">" . number_format($row[ "price" ], 0, '.', ',') . "</td>";
						echo "<td align=\"right\">" . number_format($sum, 0, '.', ',') . "</td>";
						echo "<td align=\"right\">" . $row[ "note" ] . "</td>";						
						echo "</tr>";
						$sum_all+=$sum;
					}
				} else {
					//not found
				}
				$conn->close();
				?>
				<tr>
					<td colspan="6"></td>
					<td><?php echo number_format($sum_all, 0, '.', ','); ?></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<br/><br/>		
		<p>&nbsp;</p>
	</div>
</body>

</html>
<?php
$content = ob_get_clean();
$mpdf->WriteHTML($content);
$mpdf->Output();
?>