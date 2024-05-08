<?php
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletebtn'])) {
    $shp_id = $_POST['shp_id'];

    // เตรียม SQL query สำหรับลบข้อมูลในตาราง bk_ord_shipping
    $delete_query = "DELETE FROM bk_ord_shipping WHERE shp_id = '$shp_id'";

    // ทำการ execute SQL query
    if (mysqli_query($proj_connect, $delete_query)) {
        $_SESSION['status'] = "ลบข้อมูลการจัดส่งสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบข้อมูลการจัดส่ง";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: shipping_show.php');
}
?>
