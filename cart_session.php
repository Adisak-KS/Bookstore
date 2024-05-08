<?php
ob_start();
session_start();



$qty = $_POST['qty'];
$previous_url = $_SERVER['HTTP_REFERER'];
if (!isset($_SESSION['mmb_id'])) {
	$_SESSION['status'] = "กรุณาเข้าสู่ระบบก่อนทำรายการ";
	$_SESSION['status_code'] = "ผิดพลาด";
	header("location:	$previous_url");
}
else{

if (!isset($_SESSION["intLine"]))    //เช็คว่าแถวเป็นค่าว่างมั๊ย ถ้าว่างให้ทำงานใน {}
{
	$_SESSION["intLine"] = 0;
	$_SESSION["strProductID"][0] = $_POST["id"];   //รหัสสินค้า
	$_SESSION["strQty"][0] = $qty;                   //จำนวนสินค้า

	//header("location:	$previous_url");
} else {
	//$total_items = $_SESSION["intLine"] + 1;

	$key = array_search($_POST["id"], $_SESSION["strProductID"]);
	if ((string)$key != "") {
		$_SESSION["strQty"][$key] = $_SESSION["strQty"][$key] + $qty;
	} else {
		$_SESSION["intLine"] = $_SESSION["intLine"] + 1;
		$intNewLine = $_SESSION["intLine"];
		$_SESSION["strProductID"][$intNewLine] = $_POST["id"];
		$_SESSION["strQty"][$intNewLine] = $qty;
	}
	//header("location:	$previous_url");
}
//$_SESSION['total_items'] = array_sum($_SESSION["strQty"]);
$uniqueItems = count(array_unique($_SESSION["strProductID"]));

// เก็บผลลัพธ์ใน $_SESSION['total_items']
$_SESSION['total_items'] = $uniqueItems;
header("location:	$previous_url");
}