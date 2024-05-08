<?php
ob_start();
require_once('connection.php');

// ตรวจสอบว่า $_SESSION['ordi_name'] เป็น array หรือไม่
if (is_array($_SESSION['ordi_name'])) {
	unset($_SESSION['prd_id']);
	$_SESSION['total_items'] = 0;
	// วนลูปผ่าน $_SESSION['ordi_name']
	foreach ($_SESSION['ordi_name'] as $ordi_name) {
		// สร้างคำสั่ง SQL
		$sql = "SELECT prd_id 
                FROM bk_prd_product 
                WHERE prd_id IN (SELECT prd_id 
                                 FROM bk_prd_type 
                                 WHERE pty_id IN (SELECT pty_id 
                                                  FROM bk_prd_type 
                                                  WHERE pty_show = 1)
                                   AND prd_qty > 0 
                                   AND prd_show = 1) 
                  AND prd_name = '$ordi_name'";

		// ส่งคำสั่ง SQL ไปที่ฐานข้อมูล
		$result = mysqli_query($proj_connect, $sql);

		// ตรวจสอบผลลัพธ์
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			$prd_id = $row['prd_id'];

			// เก็บ prd_id ใน $_SESSION['prd_id']
			$_SESSION['prd_id'][] = $prd_id;
		}
	}
} else {
	// $_SESSION['ordi_name'] ไม่ใช่ array
	echo "Error: ordi_name is not an array";
	exit();
}


if (isset($_SESSION['prd_id'])) {
	$previous_url = 'cart.php';
	for ($n = 0; $n < $_POST['loop']; $n++) {
		if (!isset($_SESSION["intLine"]))    //เช็คว่าแถวเป็นค่าว่างมั๊ย ถ้าว่างให้ทำงานใน {}
		{
			$_SESSION["intLine"] = 0;
			$_SESSION["strProductID"][0] = $_SESSION['prd_id'][$n];   //รหัสสินค้า
			$_SESSION["strQty"][0] = $_SESSION['ordi_quan'][$n];                   //จำนวนสินค้า

			//header("location:	$previous_url");
		} else {
			//$total_items = $_SESSION["intLine"] + 1;

			$key = array_search($_SESSION['prd_id'][$n], $_SESSION["strProductID"]);
			if ((string)$key != "") {
				$_SESSION["strQty"][$key] = $_SESSION["strQty"][$key] + $_SESSION['ordi_quan'][$n];
			} else {
				$_SESSION["intLine"] = $_SESSION["intLine"] + 1;
				$intNewLine = $_SESSION["intLine"];
				$_SESSION["strProductID"][$intNewLine] = $_SESSION['prd_id'][$n];
				$_SESSION["strQty"][$intNewLine] = $_SESSION['ordi_quan'][$n];
			}
			//header("location:	$previous_url");
		}
	}

	$uniqueItems = count(array_unique($_SESSION['strProductID']));
	//$uniqueItems = count(array_unique($_SESSION['prd_id']));
	unset($_SESSION['prd_id']);
	unset($_SESSION['ordi_quan']);
	//$_SESSION['total_items'] = array_sum($_SESSION["strQty"]);
	//array_shift($_SESSION["strProductID"]);
	// เก็บผลลัพธ์ใน $_SESSION['total_items']
	//$_SESSION['total_items'] = $_SESSION['total_items'] + $uniqueItems;
	$_SESSION['total_items'] = $uniqueItems;
	$_SESSION['status'] = "ใส่ตะกร้าสำเร็จ";
	$_SESSION['status_code'] = "สำเร็จ";
	header("location:	$previous_url");
} else {
	$_SESSION['status'] = "ขออภัย ไม่พบสินค้าที่ต้องการซื้อซ้ำ";
	$_SESSION['status_code'] = "สำเร็จ";
	header("location: my-account-my_order.php");
}
 // ให้ $strProductIDs เก็บค่าทั้งหมดในอาร์เรย์เป็นสตริง
 $strProductIDs = implode(", ", $_SESSION["strProductID"]);

 // แสดงค่าทั้งหมดที่รวมเข้าไว้ใน $strProductIDs
 echo "ค่าทั้งหมดในอาร์เรย์: " . $strProductIDs;