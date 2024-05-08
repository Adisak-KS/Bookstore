<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบว่ามีการส่งค่า order0 หรือไม่
if (isset($_GET['prd_id0'])) {

    $locat = $_GET['location'];
    if ($locat == 'publ') {
        $location = 'Location: publisher_delete_form.php';
    } elseif ($locat == 'pty') {
        $location = 'Location: product_type_delete_form.php';
    }

    // วนลูปเพื่ออัปเดตค่าลำดับในตาราง bk_set_banner
    $index = 0;
    while (isset($_GET['prd_id' . $index])) {
        // ดึงค่า order, bnn_id, และ bnn_show ที่ถูกส่งมา
        $prd_id = $_GET['prd_id' . $index];

        // อัปเดตค่าลำดับและ bnn_show ในตาราง bk_set_banner ตาม bnn_id ที่ตรงกัน
        $deleteQuery  = "DELETE FROM bk_prd_product WHERE prd_id = $prd_id";
        $stmt  = mysqli_query($proj_connect, $deleteQuery);

        if ($stmt) {
            echo "ลบสินค้าสำเร็จ";
            $_SESSION['status'] = "ลบสินค้าสำเร็จ";
            $_SESSION['status_code'] = "success";
        } else {
            echo "เกิดข้อผิดพลาดในการลบสินค้าสำเร็จ";
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบสินค้าสำเร็จ";
            $_SESSION['status_code'] = "error";
        }
        $index++;
    }
    echo '1';
    header($location);
    exit();
}
