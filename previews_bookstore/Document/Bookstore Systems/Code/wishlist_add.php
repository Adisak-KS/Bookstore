<?php
require_once('connection.php');

// ตรวจสอบว่ามีการส่ง prd_id และ mmb_id มาหรือไม่
if (isset($_GET['prd_id']) && isset($_GET['mmb_id'])) {
    $prd_id = $_GET['prd_id'];
    $mmb_id = $_GET['mmb_id'];

    // ตรวจสอบว่า prd_id และ mmb_id ไม่ว่าง
    if (!empty($prd_id) && !empty($mmb_id)) {
        // ตรวจสอบว่ารายการนี้มีใน wishlist ของสมาชิกนี้หรือไม่
        $check_query = "SELECT * FROM bk_mmb_wishlist WHERE prd_id = '$prd_id' AND mmb_id = '$mmb_id'";
        $check_result = mysqli_query($proj_connect, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // ถ้ามีแล้วให้ทำการลบรายการทิ้ง
            $delete_query = "DELETE FROM bk_mmb_wishlist WHERE prd_id = '$prd_id' AND mmb_id = '$mmb_id'";
            $delete_result = mysqli_query($proj_connect, $delete_query);

            if ($delete_result) {
                $_SESSION['status'] = "นำสินค้าออกจาก Wishlist สำเร็จ";
                $_SESSION['status_code'] = "สำเร็จ";
            } else {
                $_SESSION['status'] = "ไม่สามารถนำสินค้าออกจาก Wishlist ได้";
                $_SESSION['status_code'] = "ผิดพลาด";
            }
        } else {
            // ถ้ายังไม่มีให้ทำการเพิ่มข้อมูล
            $insert_query = "INSERT INTO bk_mmb_wishlist (prd_id, mmb_id) VALUES ('$prd_id', '$mmb_id')";
            $insert_result = mysqli_query($proj_connect, $insert_query);

            if ($insert_result) {
                $_SESSION['status'] = "เพิ่มสินค้าลงใน Wishlist สำเร็จ";
                $_SESSION['status_code'] = "สำเร็จ";
            } else {
                $_SESSION['status'] = "ไม่สามารถเพิ่มสินค้าใน Wishlist ได้";
                $_SESSION['status_code'] = "ผิดพลาด";
            }
        }
    } else {
        $_SESSION['status'] = "ข้อมูลไม่ครบถ้วน";
        $_SESSION['status_code'] = "ผิดพลาด";
    }
} else {
    $_SESSION['status'] = "ไม่มีข้อมูลที่ส่งมา";
    $_SESSION['status_code'] = "ผิดพลาด";
}

// ลิ้งค์กลับไปยังหน้าก่อนหน้า
$previous_page_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'ไม่มี URL ก่อนหน้านี้';
header('Location: '. $previous_page_url);
exit();
?>
