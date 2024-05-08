<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['addbtn'])) {
    // รับค่าจากฟอร์ม
    $publ_name = $_POST['publ_name'];
    $publ_detail = $_POST['publ_detail'];

    // คำสั่ง SQL เพื่อตรวจสอบว่ามีชื่อสินค้าที่ซ้ำกันในฐานข้อมูลหรือไม่
    $sql_check_product = "SELECT * FROM bk_prd_publisher WHERE publ_name = '$publ_name'";
    $result_check_product = mysqli_query($proj_connect, $sql_check_product);

    $location = 'publisher_show.php';

    // ตรวจสอบว่ามีชื่อสินค้าที่ซ้ำกันหรือไม่
    if (mysqli_num_rows($result_check_product) > 0) {
        // ถ้ามีชื่อสินค้าที่ซ้ำกันในฐานข้อมูล ให้แสดงข้อความว่า "ชื่อสินค้านี้มีอยู่ในระบบแล้ว"
        echo "ชื่อซ้ำ";
        $_SESSION['status'] = "ชื่อสำนักพิมพ์นี้มีอยู่ในระบบแล้ว โปรลองอีกครั้ง";
        $_SESSION['status_code'] = "warning";
        header('Location: ' . $location);
    } else {

        // คำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง product
        $query = "INSERT INTO bk_prd_publisher (publ_name, publ_detail)
    VALUES ('$publ_name', '$publ_detail')";
        $query_run = mysqli_query($proj_connect, $query);

        if ($query_run) {
            echo "Saved";
            $_SESSION['status'] = "เพิ่มสำนักพิมพ์สำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
            header('Location: ' . $location);
        } else {
            $_SESSION['status'] = "เพิ่มสำนักพิมพ์ไม่สำเร็จ";
            $_SESSION['status_code'] = "ผิดพลาด";
            header('Location: ' . $location);
        }
    }
} else {
    $_SESSION['status'] = "ข้อมูลไม่ครบ";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: ' . $location);
}
