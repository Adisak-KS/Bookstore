<?php
// เชื่อมต่อฐานข้อมูล
require_once __DIR__ . '/../../../connection.php';
session_start();

$location = 'staff_show.php';
if (isset($_POST['delbtn'])) {
    $stf_id = $_POST['stf_id'];
    $location = 'role_edit_form.php';

    $stf_id = $_POST['stf_id'];

    // ลบข้อมูลจากตาราง sale
    $sale_delete_query = "DELETE FROM bk_auth_sale WHERE stf_id = '$stf_id'";
    $sale_delete_result = mysqli_query($proj_connect, $sale_delete_query);

    // ลบข้อมูลจากตาราง admin
    $admin_delete_query = "DELETE FROM bk_auth_admin WHERE stf_id = '$stf_id'";
    $admin_delete_result = mysqli_query($proj_connect, $admin_delete_query);

    // ลบข้อมูลจากตาราง staff
    $staff_delete_query = "DELETE FROM bk_auth_staff WHERE stf_id = '$stf_id'";
    $staff_delete_result = mysqli_query($proj_connect, $staff_delete_query);

    if ($staff_delete_result) {
        // ลบข้อมูลสำเร็จ

        if (isset($_SESSION['super_admin'])) {
            $location = 'admin_show.php';
        } else {
            $location = 'staff_show.php';
        }
        $_SESSION['status'] = "ลบข้อมูลสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
        header('Location: ' . $location);
    } else {
        // ไม่สามารถลบข้อมูลได้
        $_SESSION['status'] = "ไม่สามารถลบข้อมูลได้";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: ' . $location);
    }
} else {
    $_SESSION['status'] = "การส่งข้อมูลล้มเหลว";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: ' . $location);
}
