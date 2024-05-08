<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['deletebtn'])) {
    $bnn_id = $_POST['bnn_id'];

    // ทำการลบข้อมูลสินค้า
    $deleteQuery = "DELETE FROM bk_set_banner WHERE bnn_id = '$bnn_id'";
    $deleteResult = mysqli_query($proj_connect, $deleteQuery);

    if ($deleteResult) {
        $_SESSION['status'] = "ลบแบนเนอร์สำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบแบนเนอร์";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: banner_show.php');
}
?>
