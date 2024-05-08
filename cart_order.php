<?php
require_once('connection.php');
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Order Details</title>
</head>

<body>
	<h1>Order Details</h1>

	<?php
	// ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['mmb_id'])) {
		// ดึงข้อมูลจาก session ที่กำหนดใน cart_session.php
		$mmb_id = $_SESSION['mmb_id'];
		$paymentMethod = $_POST['payment'];
		$shippingMethod = $_POST['shipping'];

		echo "<p><strong>Member ID (mmb_id):</strong> $mmb_id</p>";
		echo "<p><strong>Payment Method:</strong> $paymentMethod</p>";
		echo "<p><strong>Shipping Method:</strong> $shippingMethod</p>";

		// ราคาสินค้าทั้งหมด
		$totalProductPrice = 0;
		// ราคาเหรียญทั้งหมด
		$totalProductCoins = 0;

		// แสดงรายละเอียดของสินค้าที่สั่งซื้อ
		echo "<h2>Ordered Products</h2>";
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

				// นับรวมราคาสินค้าทั้งหมด
				$totalProductPrice += ($productPrice * $quantity);
				// นับรวมเหรียญทั้งหมด
				$totalProductCoins += ($productCoins * $quantity);

				echo "<tr>
						<td>$productName</td>
						<td>$quantity</td>
						<td>$productPrice</td>
						<td>$productCoins</td>
					</tr>";
			}
		}

		// ราคาส่ง
		$sql_shipping = "SELECT * FROM bk_ord_shipping WHERE shp_id = $shippingMethod";
		$shp_result = mysqli_query($proj_connect, $sql_shipping);
		$shp_row = mysqli_fetch_assoc($shp_result);
		$shippingPrice = $shp_row['shp_price'];

		// นับรวมราคาสุทธิ
		$totalPrice = $totalProductPrice + $shippingPrice;

		echo "</table>";

		echo "<h2>Total Price Summary</h2>";
		echo "<p><strong>Total Product Price:</strong> $totalProductPrice</p>";
		echo "<p><strong>Total Shipping Price:</strong> $shippingPrice</p>";
		echo "<p><strong>Total Price:</strong> $totalPrice</p>";
	} else {
		echo "<p>No order details available.</p>";
	}
	?>

</body>

</html>
