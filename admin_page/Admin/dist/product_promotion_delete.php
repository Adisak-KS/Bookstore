<?php
require_once __DIR__ . '/../../../connection.php';
session_start();

if (isset($_POST['deletebtn'])) {
    $prp_id = $_POST['prp_id'];

    // ทำการลบข้อมูลสินค้า
    $deleteQuery = "DELETE FROM bk_promotion WHERE prp_id = '$prp_id'";
    $deleteResult = mysqli_query($proj_connect, $deleteQuery);

    if ($deleteResult) {
        $_SESSION['status'] = "ลบโปรโมชันสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบโปรโมชัน";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: product_promotion_show.php');
}
?>
