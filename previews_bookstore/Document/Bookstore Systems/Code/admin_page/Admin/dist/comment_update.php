<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['editbtn'])) {
    // รับค่าจากฟอร์ม
    $cmm_id = $_POST['cmm_id'];
    $cmm_show = $_POST['cmm_show'];

    //$location = 'Location: comment_edit_form.php?edit_id=' . $cmm_id;
    $location = 'Location: comment_show.php';

    // ทำการอัปเดตข้อมูลในตาราง bk_prd_comment
    $update_comment_query = "UPDATE bk_prd_comment SET cmm_show = '$cmm_show' WHERE cmm_id = '$cmm_id'";

    // ทำการ execute SQL query
    if (mysqli_query($proj_connect, $update_comment_query)) {
        echo "อัปเดตข้อมูลเรียบร้อย";
        // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากการอัปเดตข้อมูล
        $_SESSION['status'] = "อัปเดตข้อมูลเรียบร้อย";
        $_SESSION['status_code'] = "สำเร็จ";
        header($location);
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($proj_connect);
        // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากเกิดข้อผิดพลาด
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($proj_connect);
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
    }
} else {
    echo "ไม่มีการส่งข้อมูลมาจากฟอร์ม";
    $_SESSION['status'] = "ไม่มีการส่งข้อมูลมาจากฟอร์ม";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: comment_show.php');
}

// ปิดการเชื่อมต่อ
mysqli_close($proj_connect);
