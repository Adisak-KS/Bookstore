<?php
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletebtn'])) {
    $pay_id = $_POST['pay_id'];

    // เตรียม SQL query สำหรับลบข้อมูลในตาราง bk_ord_payment
    $delete_query = "DELETE FROM bk_ord_payment WHERE pay_id = '$pay_id'";

    // ทำการ execute SQL query
    if (mysqli_query($proj_connect, $delete_query)) {
        $_SESSION['status'] = "ลบข้อมูลการชำระเงินสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบข้อมูลการชำระเงิน";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: payment_show.php');
}
?>
