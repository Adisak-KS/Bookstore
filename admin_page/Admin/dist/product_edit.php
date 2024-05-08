<?php
require_once __DIR__ . '/../../../connection.php';


if (isset($_POST['editbtn'])) {
    $prd_id = $_POST['prd_id'];
    $prd_name = $_POST['prd_name'];
    $prd_detail = $_POST['prd_detail'];
    $prd_coin = $_POST['prd_coin'];
    $prd_price = $_POST['prd_price'];
    $prd_discount = $_POST['prd_discount'];
    $prd_qty = $_POST['prd_qty'];
    $prd_show = $_POST['prd_show'];
    $prd_preorder = $_POST['prd_preorder'];
    $pty_id = $_POST['pty_id'];
    $publ_id = $_POST['publ_id'];

    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // ตรวจสอบว่าชื่อสินค้าที่แก้ไขซ้ำกับชื่อสินค้าอื่นที่มีในฐานข้อมูลหรือไม่
    $checkDuplicateQuery = "SELECT prd_id FROM bk_prd_product WHERE prd_name = '$prd_name' AND prd_id != '$prd_id'";
    $checkDuplicateResult = mysqli_query($proj_connect, $checkDuplicateQuery);

    if (mysqli_num_rows($checkDuplicateResult) > 0) {
        // ถ้าชื่อสินค้าซ้ำ กำหนดข้อความแจ้งเตือน
        $_SESSION['status'] = "ชื่อสินค้าซ้ำกับสินค้าอื่นที่มีในระบบ โปรดลองชื่ออื่น";
        $_SESSION['status_code'] = "ผิดพลาด";

        // ส่งกลับไปยังหน้าแก้ไข
        header($location);
    } else {
        // ถ้าชื่อสินค้าไม่ซ้ำ ทำการอัปเดตข้อมูลสินค้า
        $updateQuery = "UPDATE bk_prd_product 
                        SET prd_name = '$prd_name', 
                            prd_detail = '$prd_detail',
                            prd_price = '$prd_price',
                            prd_discount = '$prd_discount',
                            prd_coin = '$prd_coin',
                            prd_qty = '$prd_qty',
                            prd_show = '$prd_show',
                            prd_preorder = '$prd_preorder',
                            pty_id = '$pty_id',
                            publ_id = '$publ_id'
                        WHERE prd_id = '$prd_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);

        if ($updateResult) {
            $_SESSION['status'] = "อัปเดตสินค้าสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตสินค้า";
            $_SESSION['status_code'] = "ผิดพลาด";
        }

        // ส่งกลับไปยังหน้าที่คุณต้องการ
        header($location);
    }
} elseif (isset($_POST['prp_add'])) {
    $prd_id = $_POST['prd_id'];
    $prp_ids = $_POST['prp_id'];

    // 1. ลบข้อมูลทั้งหมดที่มี prd_id เดียวกัน (ยกเว้นข้อมูลที่กำลังจะเพิ่ม)
    $delete_query = "DELETE FROM bk_prd_promotion WHERE prd_id = '$prd_id'";
    $delete_query_run = mysqli_query($proj_connect, $delete_query);

    if (!$delete_query_run) {
        // หากมีข้อผิดพลาดในการลบข้อมูล
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบข้อมูล";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
        exit(); // จบการทำงาน
    }

    // 2. เพิ่มข้อมูลใหม่ลงในตาราง bk_prd_promotion
    foreach ($prp_ids as $prp_id) {
        $insert_query = "INSERT INTO bk_prd_promotion (prd_id, prp_id) VALUES ('$prd_id', '$prp_id')";
        $insert_query_run = mysqli_query($proj_connect, $insert_query);

        if (!$insert_query_run) {
            // หากมีข้อผิดพลาดในการเพิ่มข้อมูล
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
            $_SESSION['status_code'] = "ผิดพลาด";
            header($location);
            exit(); // จบการทำงาน
        }
    }

    // สร้าง session หลังจากทำงานเสร็จ
    $_SESSION['status'] = "อัปเดตโปรโมชันสินค้าสำเร็จ";
    $_SESSION['status_code'] = "สำเร็จ";

    // ลิ้งก์ไปยังหน้า product_edit_form.php
    header($location);
    exit(); // จบการทำงาน

}
