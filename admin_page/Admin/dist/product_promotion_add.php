<?php
require_once __DIR__ . '/../../../connection.php';

$location = 'product_promotion_show.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $prp_name = $_POST['prp_name'];
    $prp_detail = $_POST['prp_detail'];
    $prp_discount = $_POST['prp_discount'];
    $prp_start = $_POST['prp_start'];
    $prp_end = $_POST['prp_end'];

    // คำสั่ง SQL เพื่อตรวจสอบว่ามีชื่อสินค้าที่ซ้ำกันในฐานข้อมูลหรือไม่
    $sql_check_product = "SELECT * FROM bk_promotion WHERE prp_name = '$prp_name'";
    $result_check_product = mysqli_query($proj_connect, $sql_check_product);

    

    // ตรวจสอบว่ามีชื่อสินค้าที่ซ้ำกันหรือไม่
    if (mysqli_num_rows($result_check_product) > 0) {
        // ถ้ามีชื่อสินค้าที่ซ้ำกันในฐานข้อมูล ให้แสดงข้อความว่า "ชื่อสินค้านี้มีอยู่ในระบบแล้ว"
        echo "ชื่อซ้ำ";
        $_SESSION['status'] = "ชื่อโปรโมชันนี้มีอยู่ในระบบแล้ว โปรลองอีกครั้ง";
        $_SESSION['status_code'] = "warning";
        header('Location: ' . $location);
    } else {

        // คำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง product
        $query = "INSERT INTO bk_promotion (prp_name, prp_detail, prp_discount, prp_start, prp_end)
    VALUES ('$prp_name', '$prp_detail', '$prp_discount', '$prp_start', '$prp_end')";
        $query_run = mysqli_query($proj_connect, $query);

        if ($query_run) {
            echo "Saved";
            $_SESSION['status'] = "เพิ่มโปรโมชันสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
            header('Location: ' . $location);
        } else {
            $_SESSION['status'] = "เพิ่มโปรโมชันไม่สำเร็จ";
            $_SESSION['status_code'] = "ผิดพลาด";
            header('Location: ' . $location);
        }
    }
} else {
    $_SESSION['status'] = "ข้อมูลไม่ครบ";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: ' . $location);
}
