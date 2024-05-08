<?php
// เชื่อมต่อกับฐานข้อมูล
require_once('connection.php');

// ตรวจสอบว่ามีการเชื่อมต่อสำเร็จหรือไม่
if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['mmb_id'])) {
    // ดึงข้อมูลจาก session ที่กำหนดใน cart_session.php
    $mmb_id = $_SESSION['mmb_id'];
    $paymentMethod = $_POST['payment'];
    $shippingMethod = $_POST['shipping'];
    $discoutCoin = $_POST['discountOutput'];

    // ราคาสินค้าทั้งหมด
    $totalProductPrice = 0;
    // ราคาเหรียญทั้งหมด
    $totalProductCoins = 0;

    // วนลูปแสดงข้อมูลสินค้า
    foreach ($_SESSION['strProductID'] as $i => $productID) {
        $productID = $_SESSION['strProductID'][$i];
        $quantity = $_SESSION['strQty'][$i];

        // ตรวจสอบว่า $productID ไม่เป็นค่าว่าง
        if (!empty($productID)) {
            // ดึงข้อมูลสินค้าจากฐานข้อมูล
            $sql = "SELECT * FROM bk_prd_product WHERE prd_id = $productID";
            $result = mysqli_query($proj_connect, $sql);
            $row = mysqli_fetch_assoc($result);

            $productName = $row['prd_name'];
            $productPrice = $row['prd_price'];
            $productCoins = $row['prd_coin'];

            // นับรวมราคาสินค้าทั้งหมด
            $totalProductPrice += ($productPrice * $quantity);
            // นับรวมเหรียญทั้งหมด
            $totalProductCoins += ($productCoins * $quantity);
        }
    }

    // ราคาส่ง
    $sql_shipping = "SELECT * FROM bk_ord_shipping WHERE shp_id = $shippingMethod";
    $shp_result = mysqli_query($proj_connect, $sql_shipping);
    $shp_row = mysqli_fetch_assoc($shp_result);
    $shippingPrice = $shp_row['shp_price'];

    // นับรวมราคาสุทธิ
    $totalPrice = $totalProductPrice + $shippingPrice - $discoutCoin;

    // แสดงข้อมูลทั้งหมด
    echo "<h1>รายการสั่งซื้อ</h1>";

    echo "<h2>ข้อมูลลูกค้า</h2>";
    echo "<p><strong>Member ID (mmb_id):</strong> $mmb_id</p>";
    echo "<p><strong>Payment Method:</strong> $paymentMethod</p>";
    echo "<p><strong>Shipping Method:</strong> $shippingMethod</p>";

    echo "<h2>ที่อยู่จัดส่ง</h2>";
    $selectedAddrID = $_POST['delivery_address'];
    $addr_sql = "SELECT * FROM bk_mmb_address WHERE mmb_id = $mmb_id AND addr_id = $selectedAddrID";
    $addr_result = mysqli_query($proj_connect, $addr_sql);
    $addr_row = mysqli_fetch_assoc($addr_result);
    echo "<p><strong>Address ID:</strong> {$addr_row['addr_id']}</p>";
    echo "<p><strong>Address Detail:</strong> {$addr_row['addr_detail']}</p>";
    echo "<p><strong>Province:</strong> {$addr_row['addr_provin']}</p>";
    echo "<p><strong>Amphur:</strong> {$addr_row['addr_amphu']}</p>";
    echo "<p><strong>Postal Code:</strong> {$addr_row['addr_postal']}</p>";
    echo "<p><strong>Phone:</strong> {$addr_row['addr_phone']}</p>";

    echo "<h2>รายการสินค้า</h2>";
    echo "<table border='1'>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Coins</th>
                </tr>";

    // วนลูปแสดงข้อมูลสินค้า
    foreach ($_SESSION['strProductID'] as $i => $productID) {
        $productID = $_SESSION['strProductID'][$i];
        $quantity = $_SESSION['strQty'][$i];

        // ตรวจสอบว่า $productID ไม่เป็นค่าว่าง
        if (!empty($productID)) {
            // ดึงข้อมูลสินค้าจากฐานข้อมูล
            $sql = "SELECT * FROM bk_prd_product WHERE prd_id = $productID";
            $result = mysqli_query($proj_connect, $sql);
            $row = mysqli_fetch_assoc($result);

            $productName = $row['prd_name'];
            $productPrice = $row['prd_price'];
            $productCoins = $row['prd_coin'];

            echo "<tr>
                    <td>$productName</td>
                    <td>$quantity</td>
                    <td>$productPrice</td>
                    <td>$productCoins</td>
                </tr>";
        }
    }

    echo "</table>";

    echo "<h2>รายละเอียดการชำระเงิน</h2>";
    echo "<p><strong>Total Product Price:</strong> $totalProductPrice</p>";
    echo "<p><strong>Total Product Coins:</strong> $totalProductCoins</p>";
    echo "<p><strong>Shipping Price:</strong> $shippingPrice</p>";
    echo "<p><strong>Discount Amount:</strong> $discoutCoin</p>";
    echo "<p><strong>Total Price:</strong> $totalPrice</p>";
} else {
    echo "<p>ไม่มีข้อมูลสำหรับแสดง</p>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($proj_connect);
?>
