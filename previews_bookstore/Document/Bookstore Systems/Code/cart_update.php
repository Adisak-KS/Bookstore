<?php
ob_start();
session_start();

if (isset($_SESSION['update_loop'])) {
    $L = $_SESSION['update_loop'];

    for ($i = 0; $i <= $L; $i++) {
        $qty_variable_name = 'qty' . $i;
        $product_id_variable_name = 'product_id' . $i; // เพิ่มชื่อตัวแปรสำหรับรหัสสินค้า
        $qty = isset($_POST[$qty_variable_name]) ? $_POST[$qty_variable_name] : '';
        $product_id = isset($_POST[$product_id_variable_name]) ? $_POST[$product_id_variable_name] : '';

        $_SESSION['strQty'][$i] = $qty;

        // ตรวจสอบและอัปเดต $_SESSION["strProductID"] ถ้ามีการเปลี่ยนแปลงรหัสสินค้า
        if ($product_id != '' && $product_id != $_SESSION['strProductID'][$i]) {
            $_SESSION['strProductID'][$i] = $product_id;
        }
    }
    //$_SESSION['total_items'] = array_sum($_SESSION["strQty"]);
    if (isset($_SESSION["strProductID"])) {
        $uniqueItems = count(array_unique($_SESSION["strProductID"]));

        // เก็บผลลัพธ์ใน $_SESSION['total_items']
        $_SESSION['total_items'] = $uniqueItems;
    } else {
        $_SESSION['total_items'] = 0;
    }
    header("location:cart.php");
} else {
    header("location:cart.php");
}
