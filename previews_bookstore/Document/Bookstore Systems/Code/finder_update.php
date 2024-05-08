<?php
require_once('connection.php');

if (isset($_GET['fdit_id'])) {
	echo $_GET['fdit_id'] . ' ' . $_GET['fdit_status'];
	$fdit_id = $_GET['fdit_id'];
	
	$select_fnd_id_query = "SELECT fnd_id FROM bk_fnd_item WHERE fdit_id = $fdit_id";
	$result = mysqli_query($proj_connect, $select_fnd_id_query);
	if ($result && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$fnd_id = $row['fnd_id'];
	}

	if ($_GET['fdit_status'] == 2) {
		$status = 'ยืนยัน';
		$fnd_status = 'เลือกช่องทางส่งและช่องทางชำระ';
		$_SESSION['status'] = 'ดำเนินการสำเร็จ โปรดเลือกช่องทางการขนส่ง และช่องทางชำระเงิน';
		$_SESSION['status_code'] = 'สำเร็จ';
		$location = 'Location: finder_cart.php?fnd_id=' . $fnd_id;
	} else {
		$status = 'ปฏิเสธ';
		$fnd_status = 'กำลังค้นหา';
		$_SESSION['status'] = 'ผู้ดูแลกำลังค้นหาให้ใหม่ โปรดรอการดำเนินการ';
		$_SESSION['status_code'] = 'สำเร็จ';
		$location = 'Location: my-account-finder-order.php';
	}
	

	// เตรียม SQL query
	$update_fnd_item_query = "UPDATE bk_fnd_item SET fdit_status = '$status' WHERE fdit_id = $fdit_id";

	// ทำการ execute SQL query
	if (mysqli_query($proj_connect, $update_fnd_item_query)) {
		// อัปเดตคอลัมน์ fdit_status ในตาราง bk_fnd_item สำเร็จ

		// เตรียม SQL query สำหรับอัปเดตคอลัมน์ fnd_status ในตาราง bk_fnd_finder
		$update_fnd_finder_query = "UPDATE bk_fnd_finder SET fnd_status = '$fnd_status' WHERE fnd_id = $fnd_id";

		// ทำการ execute SQL query
		if (mysqli_query($proj_connect, $update_fnd_finder_query)) {
			echo "อัปเดตข้อมูลสำเร็จ";

			header($location);
		} else {
			echo "Error: " . $update_fnd_finder_query . "<br>" . mysqli_error($proj_connect);
			$_SESSION['status'] = $update_fnd_finder_query . "<br>" . mysqli_error($proj_connect);
			$_SESSION['status_code'] = 'Error';
		}
	} else {
		echo "Error: " . $update_fnd_item_query . "<br>" . mysqli_error($proj_connect);
		$_SESSION['status'] = $update_fnd_item_query . "<br>" . mysqli_error($proj_connect);
		$_SESSION['status_code'] = 'Error';
	}

	// ปิดการเชื่อมต่อฐานข้อมูล
	mysqli_close($proj_connect);
}
