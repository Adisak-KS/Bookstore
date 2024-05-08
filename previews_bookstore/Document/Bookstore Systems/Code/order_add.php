<?php
require_once('connection.php');

if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['mmb_id'])) {
    $mmb_id = $_SESSION['mmb_id'];
    $paymentMethod = $_POST['payment'];
    $shippingMethod = $_POST['shipping'];
    $discountCoin = $_POST['discountOutput'];
    $delivery_address = $_POST['delivery_address'];
    $ord_coin = $_POST['ord_coin'];

    if ($_POST['delivery_address'] == 'addr_temporary') {
        $delivery_address = $_POST['mmb_firstname'] . " " . $_POST['mmb_lastname'] . " " . $_POST['addr_detail'] . " " . $_POST['addr_provin'] . " " . $_POST['addr_amphu'] . " " . $_POST['addr_postal'] . " " . $_POST['addr_phone'];
    } else {
        $delivery_address = $_POST['delivery_address'];
    }

    // INSERT INTO bk_ord_orders table
    $orderDate = date('Y-m-d H:i:s');
    $totalPrice = $_POST['totalPrice'];
    $orderStatus = "รอการชำระเงิน";  // You can set the initial status as needed
    $orderDetail = "-";  // You can customize this

    $insertOrderSQL = "INSERT INTO bk_ord_orders (ord_date, ord_amount, ord_address, shp_id, ord_payment, ord_status, mmb_id, ord_detail, ord_coin) 
                    VALUES ('$orderDate', $totalPrice, '$delivery_address', '$shippingMethod', '$paymentMethod', '$orderStatus', $mmb_id, '$orderDetail', $ord_coin)";

    if (mysqli_query($proj_connect, $insertOrderSQL)) {
        $orderId = mysqli_insert_id($proj_connect); // Get the last inserted order ID

        // INSERT INTO bk_ord_item table
        foreach ($_SESSION['strProductID'] as $i => $productID) {
            $productID = $_SESSION['strProductID'][$i];
            $quantity = $_SESSION['strQty'][$i];

            if (!empty($productID)) {
                // Update stock before updating and placing the order
                $checkStockSQL = "SELECT * FROM bk_prd_product WHERE prd_id = $productID";
                $checkStockResult = mysqli_query($proj_connect, $checkStockSQL);

                if ($checkStockResult) {
                    $row = mysqli_fetch_assoc($checkStockResult);
                    $currentStock = $row['prd_qty'];

                    if ($currentStock >= $quantity) {
                        // Update stock before placing the order
                        $updateStockSQL = "UPDATE bk_prd_product SET prd_qty = prd_qty - $quantity WHERE prd_id = $productID";
                        mysqli_query($proj_connect, $updateStockSQL);

                        // Continue with the order placement
                        $sql = "SELECT * FROM bk_prd_product WHERE prd_id = $productID";
                        $result = mysqli_query($proj_connect, $sql);
                        $row = mysqli_fetch_assoc($result);

                        $prd_name = $row['prd_name'];
                        $prd_detail = $row['prd_detail'];
                        $prd_img = $row['prd_img'];
                        $productPrice = $row['prd_price'];
                        $productCoins = $row['prd_coin'];
                        $prd_discount = $row['prd_discount'];

                        // Calculate total after discounts
                        $totalPrice = ($productPrice * $quantity) - (($productPrice * $quantity) * ($prd_discount / 100));

                        $insertOrderItemSQL = "INSERT INTO bk_ord_item (ord_id, ordi_name, ordi_detail, ordi_image, ordi_quan, ordi_total, ordi_coin) 
                               VALUES ($orderId, '$prd_name', '$prd_detail', '$prd_img', $quantity, $totalPrice, ($productCoins * $quantity))";
                        $ChkinsertOrderItemSQL = mysqli_query($proj_connect, $insertOrderItemSQL);

                        if ($ChkinsertOrderItemSQL) {
                            // รันเสร็จสมบูรณ์
                        } else {
                            // มีปัญหาในการรัน
                            echo "Error: " . $insertOrderItemSQL . "<br>" . mysqli_error($proj_connect);
                            exit();
                        }
                    } else {
                        // Clear the cart after successful order
                        unset($_SESSION['strProductID']);
                        unset($_SESSION['strQty']);
                        unset($_SESSION['intLine']);

                        $_SESSION['total_items'] = 0;

                        echo "สินค้าไม่เพียงพอ!";
                        $_SESSION['status'] = "ไม่สามารถทำรายการได้ เนื่องจากสินค้าไม่เพียงพอ";
                        $_SESSION['status_code'] = "ผิดพลาด";
                        header('Location: cart.php');
                        exit(); // ใส่ exit เพื่อให้โปรแกรมหยุดทำงานทันที
                    }
                } else {
                    echo "Error checking product stock: " . mysqli_error($proj_connect);
                }
            }
        }

        // Check if mmb_coin is sufficient before updating
        $checkCoinSQL = "SELECT mmb_coin FROM bk_auth_member WHERE mmb_id = $mmb_id";
        $checkCoinResult = mysqli_query($proj_connect, $checkCoinSQL);

        if ($checkCoinResult) {
            $row = mysqli_fetch_assoc($checkCoinResult);
            $currentCoin = $row['mmb_coin'];

            if ($currentCoin >= $discountCoin) {
                // UPDATE bk_auth_member's mmb_coin after a successful order
                // อัปเดตค่า mmb_coin ในตาราง bk_auth_member
                $updateMemberCoinSQL = "UPDATE bk_auth_member SET mmb_coin = mmb_coin - $discountCoin WHERE mmb_id = $mmb_id";
                mysqli_query($proj_connect, $updateMemberCoinSQL);

                // เตรียมข้อมูลสำหรับบันทึกลงในตาราง bk_mmb_coin_history
                $cnh_income = 0; // รายได้จากการเปลี่ยนแปลงเหรียญ (ในที่นี้คือ 0 เนื่องจากเป็นการหักเหรียญ)
                $cnh_outcome = $discountCoin; // จำนวนเหรียญที่ถูกหัก
                $cnh_coin = $mmb_coin - $discountCoin; // จำนวนเหรียญทั้งหมดหลังจากการเปลี่ยนแปลง
                $cnh_detail = "ใช้เหรียญเป็นส่วนลดในการสั่งซื้อ"; // รายละเอียดการเปลี่ยนแปลง

                if ($cnh_outcome > 0) {
                    // ทำการบันทึกประวัติลงในตาราง bk_mmb_coin_history
                    $insertCoinHistorySQL = "INSERT INTO bk_mmb_coin_history (mmb_id, cnh_income, cnh_outcome, cnh_coin, cnh_detail, cnh_date) 
                         VALUES ('$mmb_id', '$cnh_income', '$cnh_outcome', '$cnh_coin', '$cnh_detail', CURRENT_TIMESTAMP)";
                    mysqli_query($proj_connect, $insertCoinHistorySQL);
                }
                // Clear the cart after successful order
                unset($_SESSION['strProductID']);
                unset($_SESSION['strQty']);
                unset($_SESSION['intLine']);

                $_SESSION['total_items'] = 0;

                echo "สั่งซื้อสำเร็จ!";
                $_SESSION['status'] = "สั่งซื้อสำเร็จ โปรดชำระเงิน";
                $_SESSION['status_code'] = "สำเร็จ";
                header('Location: payment.php?ord_id=' . $orderId);
            } else {

                $_SESSION['total_items'] = 0;

                echo "แต้มส่วนลดไม่ถูกต้อง!";
                $_SESSION['status'] = "แต้มส่วนลดไม่ถูกต้อง โปรดตรวจสอบเหรียญของคุณก่อนทำรายการใหม่";
                $_SESSION['status_code'] = "ผิดพลาด";
                header('Location: cart.php');
            }
        } else {
            echo "Error checking member's coin: " . mysqli_error($proj_connect);
        }
    } else {
        echo "Error: " . $insertOrderSQL . "<br>" . mysqli_error($proj_connect);
    }
}

mysqli_close($proj_connect);
