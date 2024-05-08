<?php
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deletebtn'])) {
    $prov_id = $_POST['prov_id'];

    // เตรียม SQL query สำหรับลบข้อมูลจังหวัด
    $delete_query = "DELETE FROM bk_province WHERE prov_id = $prov_id";

    // ทำการ execute SQL query
    if (mysqli_query($proj_connect, $delete_query)) {
        $_SESSION['status'] = "ลบข้อมูลจังหวัดสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบข้อมูลจังหวัด";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: province_show.php');
}
?>
