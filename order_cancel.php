<?php
require_once('connection.php');

if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีการรับ ord_id มาจาก URL หรือไม่
if (isset($_GET['ord_id'])) {
    $ord_id = $_GET['ord_id'];

    // ดึงข้อมูลจำนวนสินค้าที่ถูกยกเลิกจากตาราง bk_ord_item
    $cancelOrderSQL = "SELECT ordi_name, ordi_quan FROM bk_ord_item WHERE ord_id = $ord_id";
    $cancelOrderResult = mysqli_query($proj_connect, $cancelOrderSQL);

    if ($cancelOrderResult) {
        while ($row = mysqli_fetch_assoc($cancelOrderResult)) {
            $prd_name = $row['ordi_name'];
            $ordi_quan = $row['ordi_quan'];

            // ดึงข้อมูลจำนวนสินค้าใน stock จากตาราง bk_prd_product
            $productSQL = "SELECT prd_qty FROM bk_prd_product WHERE prd_name = $prd_name";
            $productResult = mysqli_query($proj_connect, $productSQL);

            if ($productResult) {
                $productRow = mysqli_fetch_assoc($productResult);
                $currentQty = $productRow['prd_qty'];

                // คำนวณจำนวนสินค้าใหม่
                $newQty = $currentQty + $ordi_quan;

                // อัปเดตจำนวนสินค้าในตาราง bk_prd_product
                $updateStockSQL = "UPDATE bk_prd_product SET prd_qty = $newQty WHERE prd_name = $prd_name";
                mysqli_query($proj_connect, $updateStockSQL);
            }
        }
        $_SESSION['total_items'] = 0;
        // อัปเดตสถานะใบสั่งซื้อเป็น 'cancel'
        $updateOrderStatusSQL = "UPDATE bk_ord_orders SET ord_status = 'cancel' WHERE ord_id = $ord_id";

        if (mysqli_query($proj_connect, $updateOrderStatusSQL)) {
            echo "อัปเดตสถานะใบสั่งซื้อเป็น 'ยกเลิก' เรียบร้อยแล้ว";
            $_SESSION['status'] = "ยกเลิกรายการสำเร็จ";
            $_SESSION['status_code'] = "success";
            header('Location: index.php');
        } else {
            echo "Error updating order status: " . mysqli_error($proj_connect);
            $_SESSION['status'] = "การทำรายการผิดพลาด โปรดลองอีกครั้ง";
            $_SESSION['status_code'] = "error";
            header('Location: index.php');
        }
    } else {
        echo "Error fetching canceled order details: " . mysqli_error($proj_connect);
        $_SESSION['status'] = "การทำรายการผิดพลาด โปรดลองอีกครั้ง";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');
    }
} else {
    echo "ไม่ได้รับ ord_id จาก URL";
    $_SESSION['status'] = "การทำรายการผิดพลาด โปรดลองอีกครั้ง";
    $_SESSION['status_code'] = "error";
    header('Location: index.php');
}

mysqli_close($proj_connect);
