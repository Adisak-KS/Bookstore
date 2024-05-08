<?php
require_once __DIR__ . '/../../../connection.php';
session_start();

if (isset($_POST['editbtn'])) {
    $stf_id = $_POST['stf_id'];
    $stf_active = $_POST['flexRadioDefault'];

    $location = 'role_edit_form.php';

    $update_query = "UPDATE bk_auth_staff SET stf_active = '$stf_active' WHERE stf_id = '$stf_id'";
    $update_query_run = mysqli_query($proj_connect, $update_query);

    if ($update_query_run) {
        $_SESSION['status'] = "อัปเดตสถานะเรียบร้อย";
        $_SESSION['status_code'] = "สำเร็จ";
        header('Location: ' . $location);
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตสถานะ";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: ' . $location);
    }
} else {
    $_SESSION['status'] = "ไม่พบข้อมูล";
    $_SESSION['status_code'] = "ผิดพลาด";
    if(isset($_SESSION['super_admin'])){
        header('Location: admin_show.php');
    }
    else{
        header('Location: staff_show.php');
    }

}
