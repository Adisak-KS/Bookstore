<?php
require_once('connection.php');

if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['mmb_id'])) {
    $mmb_id = $_SESSION['mmb_id'];
    $fnd_id = $_POST['fnd_id'];
    $paymentMethod = $_POST['payment'];
    $shippingMethod = $_POST['shipping'];
    $discountCoin = 0;
    $delivery_address = $_POST['delivery_address'];
    $fnd_coin = 0;

    
    if ($_POST['delivery_address'] == 'addr_temporary') {
        $delivery_address = $_POST['mmb_firstname'] . " " . $_POST['mmb_lastname'] . " " . $_POST['addr_detail'] . " " . $_POST['prov_name'] . " " . $_POST['addr_amphu'] . " " . $_POST['addr_postal'] . " " . $_POST['addr_phone'];
    } else {
        $delivery_address = $_POST['delivery_address'];
    }
    
    // INSERT INTO bk_ord_orders table
    $fndDate = date('Y-m-d H:i:s');
    $totalPrice = $_POST['totalPrice'];
    $fnd_status = "รอการชำระเงิน";  // You can set the initial status as needed
    echo "mmb_id: $mmb_id <br>";
    echo "paymentMethod: $paymentMethod <br>";
    echo "shippingMethod: $shippingMethod <br>";
    echo "discountCoin: $discountCoin <br>";
    echo "delivery_address: $delivery_address <br>";
    echo "fnd_coin: $fnd_coin <br>";
    echo "fndDate: $fndDate <br>";
    echo "totalPrice: $totalPrice <br>";
    echo "orderStatus: $fnd_status <br>";
}

// เตรียม SQL query สำหรับอัปเดตคอลัมน์ fnd_status ในตาราง bk_fnd_finder
$update_fnd_finder_query = "UPDATE bk_fnd_finder SET fnd_status = '$fnd_status', fnd_address = '$delivery_address', fnd_totalprice = '$totalPrice', pay_id = $paymentMethod, shp_id = $shippingMethod WHERE fnd_id = $fnd_id";

// ทำการ execute SQL query
if (mysqli_query($proj_connect, $update_fnd_finder_query)) {
    echo "อัปเดตข้อมูลสำเร็จ";
    $_SESSION['status'] = 'ดำเนินการสำเร็จ โปรดชำระเงิน';
    $_SESSION['status_code'] = 'สำเร็จ';
    header('Location: finder_payment.php?fnd_id=' . $fnd_id);
} else {
    echo "Error: " . $update_fnd_finder_query . "<br>" . mysqli_error($proj_connect);
    $_SESSION['status'] = $update_fnd_finder_query . "<br>" . mysqli_error($proj_connect);
    $_SESSION['status_code'] = 'Error';
    header('Location: my-account-finder-order.php');
}

mysqli_close($proj_connect);
