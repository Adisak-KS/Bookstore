<?php
// เชื่อมต่อกับฐานข้อมูล
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $mmb_id = $_POST['mmb_id'];
    $prd_id = $_POST['prd_id'];
    $datetime = $_POST['datetime'];
    $cmm_detail = $_POST['cmm_detail'];
    
    $mysql_datetime = date("Y-m-d H:i:s", strtotime($datetime));

    // SQL query สำหรับการเพิ่มข้อมูลลงในตาราง comment
    $sql = "INSERT INTO comment (mmb_id, prd_id, cmm_date, cmm_detail) VALUES ('$mmb_id', '$prd_id', '$mysql_datetime', '$cmm_detail')";

    // ทำการเพิ่มข้อมูลลงในฐานข้อมูล
    $result = mysqli_query($proj_connect, $sql);

    if ($result) {
        $_SESSION['status'] = "เพิ่มความเห็นสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "เพิ่มความเห็นล้มเหลว";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    header('Location: comment.php');
}
?>
