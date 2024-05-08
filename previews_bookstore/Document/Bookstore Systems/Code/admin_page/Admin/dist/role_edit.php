<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['editbtn'])) {
    $stf_id = $_POST['stf_id'];
    $sle_id = $_POST['sle_id'];

    //$_SESSION['stf_id'] = $stf_id;

    // เข้ารหัส stf_id ก่อนเก็บลงในฐานข้อมูล
    $hashed_stf_id = base64_encode($stf_id);

    // ตรวจสอบถ้าผู้ดูแลเลือก Admin ให้เพิ่มข้อมูลลงในตาราง admin
    if (isset($_POST['admin'])) {
        $sql_admin = "INSERT INTO bk_auth_admin (stf_id) VALUES ('$hashed_stf_id')";
        mysqli_query($proj_connect, $sql_admin);
    } else {
        // ถ้าไม่เลือก Admin ให้ตรวจสอบว่าถ้ามีข้อมูลในตาราง admin ให้ลบข้อมูลออก
        $sql_admin = "DELETE FROM bk_auth_admin WHERE stf_id = '$hashed_stf_id'";
        mysqli_query($proj_connect, $sql_admin);
    }

    // ตรวจสอบถ้าผู้ดูแลเลือก Sale ให้เพิ่มข้อมูลลงในตาราง sale
    if (isset($_POST['sale'])) {
        $sql_sale = "INSERT INTO bk_auth_sale (stf_id) VALUES ('$hashed_stf_id')";
        mysqli_query($proj_connect, $sql_sale);
    } else {
        // ถ้าไม่เลือก Sale ให้ตรวจสอบว่าถ้ามีข้อมูลในตาราง sale ให้ลบข้อมูลออก
        $sql_sale = "DELETE FROM bk_auth_sale WHERE sle_id = '$sle_id'";
        mysqli_query($proj_connect, $sql_sale);
    }

    // หลังจากดำเนินการเสร็จสิ้น สามารถเปลี่ยนเส้นทางหน้าตามความต้องการ
    $_SESSION['status'] = "เปลี่ยนแปลงตำแหน่งสำเร็จ";
    $_SESSION['status_code'] = "แจ้งเตือน";
    header('Location: role_edit_form.php');
} else {
    $_SESSION['status'] = "ไม่พบข้อมูล โปรดลองอีกครั้ง";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: staff_show.php');
}
