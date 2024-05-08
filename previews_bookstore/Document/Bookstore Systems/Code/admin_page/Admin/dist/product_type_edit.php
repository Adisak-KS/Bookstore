<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['editbtn'])) {
    $pty_id = $_POST['pty_id'];
    $pty_name = $_POST['pty_name'];
    $pty_detail = $_POST['pty_detail'];
    $pty_show = $_POST['pty_show'];

    $location = 'Location: product_type_edit_form.php';

    // ตรวจสอบชื่อซ้ำก่อน
    $checkQuery = "SELECT pty_id FROM bk_prd_type WHERE pty_name = '$pty_name' AND pty_id != '$pty_id'";
    $checkResult = mysqli_query($proj_connect, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['status'] = "ชื่อประเภทสินค้าซ้ำกับข้อมูลที่มีอยู่แล้ว";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
        exit();
    } else {
        
        $updateQuery = "UPDATE bk_prd_type SET pty_name = '$pty_name', pty_detail = '$pty_detail', pty_show = '$pty_show' WHERE pty_id = '$pty_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);

        if ($updateResult) {
            $_SESSION['status'] = "อัปเดตประเภทสินค้าสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตประเภทสินค้า";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    }
    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header($location);
}
elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delbtn'])) {
    $pty_id = $_POST['pty_id'];

    // เตรียม SQL query สำหรับลบข้อมูลในตาราง bk_prd_type
    $delete_query = "DELETE FROM bk_prd_type WHERE pty_id = '$pty_id'";

    // ทำการ execute SQL query
    if (mysqli_query($proj_connect, $delete_query)) {
        $_SESSION['status'] = "ลบข้อมูลประเภทสินค้าสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบข้อมูลประเภทสินค้า";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: product_type_show.php');

}
