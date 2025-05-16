<?php

function toDateThai( $strDate ) {
	//Ex. "2008-08-14 13:42:44"
	$strYear = date( "Y", strtotime( $strDate ) ) + 543;
	$strMonth = date( "n", strtotime( $strDate ) );
	$strDay = date( "j", strtotime( $strDate ) );
	//$strHour= date("H",strtotime($strDate));
	//$strMinute= date("i",strtotime($strDate));
	//$strSeconds= date("s",strtotime($strDate));
	$strMonthCut = Array( "", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค." );
	$strMonthThai = $strMonthCut[ $strMonth ];
	//return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
	return "$strDay $strMonthThai $strYear";
}

function toDateThaiFull( $time ) {
	$thai_day_arr = array( "อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์" );
	$thai_month_arr = array( "0" => "", "1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม", "4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน", "7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม" );

	$thai_date_return = "วัน" . $thai_day_arr[ date( "w", strtotime($time) ) ];
	$thai_date_return .= "ที่ " . date( "j", strtotime($time) );
	$thai_date_return .= " เดือน " . $thai_month_arr[ date( "n", strtotime($time) ) ];
	$thai_date_return .= " พ.ศ. " . (date( "Y", strtotime( $time ) ) + 543);
	//$thai_date_return .= "  " . date( "H:i", $time ) . " น.";
	return $thai_date_return;
}

function toDateThaiHalfFull( $time ) {
	$thai_month_arr = array( "0" => "", "1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม", "4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน", "7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม" );

	$thai_date_return = "วันที่ " . date( "j", strtotime($time) );
	$thai_date_return .= " " . $thai_month_arr[ date( "n", strtotime($time) ) ];
	$thai_date_return .= " พ.ศ. " . (date( "Y", strtotime( $time ) ) + 543);
	//$thai_date_return .= "  " . date( "H:i", $time ) . " น.";
	return $thai_date_return;
}

function toMonthFromInt($a){
	$thai_month_arr = array( "0" => "", "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม" );
	return $thai_month_arr[ $a ];
}

function getRoleName($id){
	if($id==1){
		return "ผู้ใช้งาน";
	}
	if($id==2){
		return "ผู้อนุมัติจ่าย";
	}
	if($id==3){
		return "ผู้ดูแลระบบ";
	}
}
?>