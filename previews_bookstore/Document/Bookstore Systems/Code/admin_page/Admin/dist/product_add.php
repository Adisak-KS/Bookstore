<?php
require_once __DIR__ . '/../../../connection.php';
//session_start();

if (isset($_POST['addbtn'])) {
    // รับค่าจากฟอร์ม
    $prd_name = $_POST['prd_name'];
    $prd_detail = $_POST['prd_detail'];
    $prd_price = $_POST['prd_price'];
    $prd_discount = $_POST['prd_discount'];
    $prd_coin = $_POST['prd_coin'];
    $prd_preorder = $_POST['prd_preorder'];
    $prd_qty = $_POST['prd_qty'];
    $pty_id = $_POST['pty_id'];
    $publ_id = $_POST['publ_id'];

    // คำสั่ง SQL เพื่อตรวจสอบว่ามีชื่อสินค้าที่ซ้ำกันในฐานข้อมูลหรือไม่
    $sql_check_product = "SELECT * FROM bk_prd_product WHERE prd_name = '$prd_name'";
    $result_check_product = mysqli_query($proj_connect, $sql_check_product);

    // ตรวจสอบว่ามีชื่อสินค้าที่ซ้ำกันหรือไม่
    if (mysqli_num_rows($result_check_product) > 0) {
        // ถ้ามีชื่อสินค้าที่ซ้ำกันในฐานข้อมูล ให้แสดงข้อความว่า "ชื่อสินค้านี้มีอยู่ในระบบแล้ว"
        echo "ชื่อซ้ำ";
        $_SESSION['status'] = "ชื่อสินค้านี้มีอยู่ในระบบแล้ว โปรลองอีกครั้ง";
        $_SESSION['status_code'] = "warning";
        header('Location: product_show.php');       
    } else {

        // คำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง product
        $query = "INSERT INTO bk_prd_product (prd_name, prd_detail, prd_price, prd_discount, prd_coin, prd_qty, prd_preorder, pty_id, publ_id)
    VALUES ('$prd_name', '$prd_detail', '$prd_price', '$prd_discount', '$prd_coin', '$prd_qty', '$prd_preorder', '$pty_id', '$publ_id')";
        $query_run = mysqli_query($proj_connect, $query);

        if ($query_run) {
            echo "Saved";
            $_SESSION['status'] = "เพิ่มสินค้าสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
            header('Location: product_show.php');
        } else {
            echo "INSERT INTO bk_prd_product (prd_name, prd_detail, prd_price, prd_coin, prd_qty, prd_preorder, pty_id, publ_id)
            VALUES ('$prd_name', '$prd_detail', '$prd_price', '$prd_coin', '$prd_qty', '$prd_preorder', '$pty_id', '$publ_id')";
            $_SESSION['status'] = "เพิ่มสินค้าไม่สำเร็จ";
            $_SESSION['status_code'] = "ผิดพลาด";
            header('Location: product_show.php');
        }
    }
} else {
    $_SESSION['status'] = "ข้อมูลไม่ครบ";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: product_show.php');
}
?>