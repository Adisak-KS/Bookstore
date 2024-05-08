<?php
require_once('connection.php');

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
	$status = $_SESSION['status'];
	$status_code = $_SESSION['status_code'];

	// เคลียร์ค่า session
	unset($_SESSION['status']);
	unset($_SESSION['status_code']);

	$current_url = $_SERVER['REQUEST_URI'];

	// แสดงหน้าต่างข้อความแจ้งเตือน
	echo "<script>alert('$status');</script>";
	echo "<script>window.location.href = '$current_url';</script>";
	exit();
}

if (isset($_GET['fnd_id'])) {
	$_SESSION['fnd_id'] = $_GET['fnd_id'];
	$fnd_id = $_SESSION['fnd_id'];
} elseif (!isset($_GET['fnd_id'])) {
	$fnd_id = $_SESSION['fnd_id'];
}
else{
	$_SESSION['status'] = 'เกิดข้อผิดพลาด';
	$_SESSION['status_code'] = 'error';
	header('Location: index.php');
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
	<?php
	require_once('head.php');
	?>
	<script>
		// เมื่อโหลดหน้าเสร็จสิ้น
		window.addEventListener('load', function() {
			// ตรวจสอบว่ามี query parameters ใน URL หรือไม่
			if (window.location.search.length > 0) {
				// พบ query parameters ใน URL
				// รีดิเร็ก URL โดยไม่รวม query parameters
				window.history.replaceState({}, document.title, window.location.pathname);
			}
		});
	</script>
</head>

<body class="home-1">
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

	<!-- Add your site or application content here -->
	<!-- header-area-start -->
	<header>
		<?php
		require_once('header.php');
		?>
	</header>
	<!-- header-area-end -->
	<!-- breadcrumbs-area-start -->
	<div class="breadcrumbs-area mb-70">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumbs-menu">
						<ul>
							<li><a href="index.php">หน้าแรก</a></li>
							<li><a href="#" class="active">ชำระเงิน</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumbs-area-end -->
	<!-- entry-header-area-start -->
	<div class="entry-header-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="entry-header-title">
						<h2>ข้อมูลการชำระเงิน</h2>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- entry-header-area-end -->
	<!-- cart-main-area-start -->
	<div class="cart-main-area mb-70">
		<div class="container">
			<div class="row">
				<?php


				// Select data FROM bk_fnd_orders table based on fnd_id
				$selectfiderSQL = "SELECT * FROM bk_fnd_finder WHERE fnd_id = $fnd_id";
				$selectfinderResult = mysqli_query($proj_connect, $selectfiderSQL);
				$finderData = mysqli_fetch_assoc($selectfinderResult);

				// Select payment information FROM bk_fnd_payment table based on fnd_payment
				$pay_id = $finderData['pay_id'];
				$selectPaymentSQL = "SELECT * FROM bk_ord_payment WHERE pay_id = $pay_id";
				$selectPaymentResult = mysqli_query($proj_connect, $selectPaymentSQL);
				$paymentData = mysqli_fetch_assoc($selectPaymentResult);

				?>
				<table>
					<thead>
						<tr>
							<th class="product-name"></th>
							<th class="product-total"></th>
						</tr>
					</thead>
					<tbody>
						<tr class="cart_item">
							<td class="product-name">
								<h6>ยอดชำระ</h6>
								<strong class="product-quantity"></strong>
							</td>
							<td class="product-total">
								<span class="amount">
									<h6><?= number_format($finderData['fnd_totalprice'], 2) . ' ' ?> บาท</h6>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								<h7>ช่องทางการชำระเงิน</h7>
							</td>
							<td>
								<img src="pay_logo/<?= $paymentData['pay_logo']; ?>" alt="payment" width="75px">
								<h7><?= $paymentData['pay_name'] ?></h7>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<h6><?= $paymentData['pay_detail'] ?></h6>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><img src="pay_img/<?= $paymentData['pay_img'] ?>" width="200px" /></td>
						</tr>
					</tbody>
				</table>

			</div>
			<div class="row">
				<br>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="wc-proceed-to-checkout">
						<ul>
							<!-- <button type="submit">อัปเดตตะกร้า</button> -->
							<li><a href="#" id="updateCartLink" class="cancel-link" style="background: red;" onclick="confirmCancellation(<?= $finderData['fnd_id'] ?>)">ยกเลิกรายการ</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="wc-proceed-to-checkout">
						<ul>
							<!-- <button type="submit">อัปเดตตะกร้า</button> -->
							<li><a href="finder_notify.php?fnd_id=<?= $finderData['fnd_id'] ?>" id="updateCartLink">แจ้งชำระเงิน</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- cart-main-area-end -->
	<!-- footer-area-start -->
	<footer>
		<?php
		require_once('footer.php');
		?>
	</footer>
	<!-- footer-area-end -->


	<!-- all js here -->
	<!-- jquery latest version -->
	<script src="js/vendor/jquery-1.12.4.min.js"></script>


	<!-- bootstrap js -->
	<script src="js/bootstrap.min.js"></script>
	<!-- owl.carousel js -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- meanmenu js -->
	<script src="js/jquery.meanmenu.js"></script>
	<!-- wow js -->
	<script src="js/wow.min.js"></script>
	<!-- jquery.parallax-1.1.3.js -->
	<script src="js/jquery.parallax-1.1.3.js"></script>
	<!-- jquery.countdown.min.js -->
	<script src="js/jquery.countdown.min.js"></script>
	<!-- jquery.flexslider.js -->
	<script src="js/jquery.flexslider.js"></script>
	<!-- chosen.jquery.min.js -->
	<script src="js/chosen.jquery.min.js"></script>
	<!-- jquery.counterup.min.js -->
	<script src="js/jquery.counterup.min.js"></script>
	<!-- waypoints.min.js -->
	<script src="js/waypoints.min.js"></script>
	<!-- plugins js -->
	<script src="js/plugins.js"></script>
	<!-- main js -->
	<script src="js/main.js"></script>

	<!-- ยกเลิกรายการ -->
	<script>
		function confirmCancellation(fnd_id) {
			// ให้แสดง confirm box
			var confirmResult = confirm("คุณต้องการยกเลิกรายการนี้ใช่หรือไม่?");

			// ตรวจสอบผลลัพธ์จาก confirm box
			if (confirmResult) {
				// ถ้าผู้ใช้กด "ตกลง", ให้เรียกใช้ order_cancel.php
				window.location.href = "finder_cancel.php?fnd_id=" + fnd_id;
			} else {
				// ถ้าผู้ใช้กด "ยกเลิก", ไม่ต้องทำอะไร
			}
		}
	</script>

</body>


</html>