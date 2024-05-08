<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['deletebtn'])) {
    $prd_id = $_POST['prd_id'];

    // ทำการลบข้อมูลสินค้า
    $deleteQuery = "DELETE FROM bk_prd_product WHERE prd_id = '$prd_id'";
    $deleteResult = mysqli_query($proj_connect, $deleteQuery);

    if ($deleteResult) {
        // ทำการลบข้อมูลในตาราง bk_prd_comment ที่เกี่ยวข้องกับ prd_id นี้
        $deleteCommentQuery = "DELETE FROM bk_prd_comment WHERE prd_id = '$prd_id'";
        $deleteCommentResult = mysqli_query($proj_connect, $deleteCommentQuery);

        if ($deleteCommentResult) {
            $_SESSION['status'] = "ลบสินค้าสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบความคิดเห็นเกี่ยวกับสินค้า";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบสินค้า";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: product_show.php');
} else {
    header('Location: product_show.php');
}
?>
