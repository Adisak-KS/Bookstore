<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['deletebtn'])) {
    $publ_id = $_POST['publ_id'];

    // ทำการลบข้อมูลสำนักพิมพ์
    $deleteQuery = "DELETE FROM bk_prd_publisher WHERE publ_id = '$publ_id'";
    $deleteResult = mysqli_query($proj_connect, $deleteQuery);

    if ($deleteResult) {
        $_SESSION['status'] = "ลบสำนักพิมพ์สำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบสำนักพิมพ์";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: publisher_show.php');
}
?>
