<?php
require_once __DIR__ . '/../../../connection.php';
session_start();
$location = 'shipping_show.php';
if (isset($_POST['addbtn'])) {
    // รับค่าจากฟอร์ม
    $shp_name = $_POST['shp_name'];
    $shp_detail = $_POST['shp_detail'];
    $shp_price = $_POST['shp_price'];
 

    // คำสั่ง SQL เพื่อตรวจสอบว่ามีชื่อสินค้าที่ซ้ำกันในฐานข้อมูลหรือไม่
    $sql_check_product = "SELECT * FROM bk_ord_shipping WHERE shp_name = '$shp_name'";
    $result_check_product = mysqli_query($proj_connect, $sql_check_product);

    // ตรวจสอบว่ามีชื่อสินค้าที่ซ้ำกันหรือไม่
    if (mysqli_num_rows($result_check_product) > 0) {
        // ถ้ามีชื่อสินค้าที่ซ้ำกันในฐานข้อมูล ให้แสดงข้อความว่า "ชื่อสินค้านี้มีอยู่ในระบบแล้ว"
        echo "ชื่อซ้ำ";
        $_SESSION['status'] = "ช่องทางชำระนี้มีอยู่ในระบบแล้ว โปรลองอีกครั้ง";
        $_SESSION['status_code'] = "warning";
        header('Location: ' . $location);       
    } else {

        // คำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง shipping
        $query = "INSERT INTO bk_ord_shipping (shp_name, shp_detail, shp_price)
    VALUES ('$shp_name', '$shp_detail', '$shp_price')";
        $query_run = mysqli_query($proj_connect, $query);

        if ($query_run) {
            echo "Saved";
            $_SESSION['status'] = "เพิ่มสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
            header('Location: ' . $location);
        } else {
            $_SESSION['status'] = "เพิ่มไม่สำเร็จ";
            $_SESSION['status_code'] = "ผิดพลาด";
            header('Location: ' . $location);
        }
    }
} else {
    $_SESSION['status'] = "ข้อมูลไม่ครบ";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: ' . $location);
}
?>