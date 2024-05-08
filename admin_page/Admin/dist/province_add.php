<?php
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addbtn'])) {
    $prov_name = $_POST['prov_name'];

    // เช็คว่ามีชื่อจังหวัดที่ต้องการเพิ่มอยู่แล้วหรือไม่
    $check_query = "SELECT * FROM bk_province WHERE prov_name = '$prov_name'";
    $check_result = mysqli_query($proj_connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // ถ้ามีข้อมูลซ้ำในตารางแล้ว
        $_SESSION['status'] = "ชื่อจังหวัดนี้มีอยู่ในระบบแล้ว";
        $_SESSION['status_code'] = "ผิดพลาด";
    } else {
        // ถ้าไม่มีข้อมูลซ้ำ ทำการเพิ่มข้อมูลในตาราง
        $insert_query = "INSERT INTO bk_province (prov_name) VALUES ('$prov_name')";
        if (mysqli_query($proj_connect, $insert_query)) {
            $_SESSION['status'] = "เพิ่มข้อมูลจังหวัดสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการเพิ่มข้อมูลจังหวัด";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: province_show.php');
}
?>
