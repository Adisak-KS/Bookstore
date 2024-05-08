<?php
require_once('connection.php');

$rating_data = $_GET['rating_data'] ?? '';
$reviewMessage = $_GET['reviewMessage'] ?? '';
$mmb_id = $_GET['mmb_id'];
$prd_id = $_GET['prd_id'];

$location = 'Location: product-details.php?prd_id=' . base64_encode($prd_id);

// ตรวจสอบว่ามีค่าหรือไม่
if ($rating_data !== '') {
	// ตรวจสอบว่า mmb_id ได้ทำรีวิว prd_id นี้ไปแล้วหรือยัง
	$select_query = $proj_connect->prepare("SELECT * FROM bk_prd_comment WHERE prd_id = ? AND mmb_id = ?");
	$select_query->bind_param("ii", $prd_id, $mmb_id);
	$select_query->execute();
	$result = $select_query->get_result();

	if ($result->num_rows > 0) {
		// มีข้อมูล ทำการอัพเดท
		$update_query = $proj_connect->prepare("UPDATE bk_prd_comment 
                                               SET cmm_rating = ?, cmm_detail = ?, cmm_date = NOW(), cmm_show = 1
                                               WHERE prd_id = ? AND mmb_id = ?");
		$update_query->bind_param("ssii", $rating_data, $reviewMessage, $prd_id, $mmb_id);

		if ($update_query->execute()) {
			echo "รีวิวถูกอัพเดทเรียบร้อย";
			$_SESSION['status'] = 'รีวิวถูกอัพเดทเรียบร้อย';
			$_SESSION['status_code'] = 'SUCCESS';
			header($location);
		} else {
			echo "Error: " . $update_query->error;
			$_SESSION['status'] = "Error: " . $update_query->error;;
			$_SESSION['status_code'] = 'Error';
			header($location);
		}

		$update_query->close();
	} else {
		// ไม่มีข้อมูล ทำการเพิ่ม
		$insert_query = $proj_connect->prepare("INSERT INTO bk_prd_comment (prd_id, mmb_id, cmm_rating, cmm_detail, cmm_date)
                                               VALUES (?, ?, ?, ?, NOW())");
		$insert_query->bind_param("iiss", $prd_id, $mmb_id, $rating_data, $reviewMessage);

		if ($insert_query->execute()) {
			echo "รีวิวถูกบันทึกเรียบร้อย";
			$_SESSION['status'] = 'รีวิวถูกบันทึกเรียบร้อย';
			$_SESSION['status_code'] = 'SUCSSESS';
			header($location);
		} else {
			echo "Error: " . $insert_query->error;
			$_SESSION['status'] = "Error: " . $insert_query->error;;
			$_SESSION['status_code'] = 'Error';
			header($location);
		}

		$insert_query->close();
		$_SESSION['status'] = 'รีวิวถูกบันทึกเรียบร้อย';
		$_SESSION['status_code'] = 'SUCSSESS';
		header($location);
	}

	$select_query->close();
} else {
	echo "ไม่พบข้อมูลรีวิว";
	$_SESSION['status'] = "ไม่พบข้อมูลรีวิว";
	$_SESSION['status_code'] = 'Error';
	header($location);
}

// ปิดการเชื่อมต่อ
$proj_connect->close();
