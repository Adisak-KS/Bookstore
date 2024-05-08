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
							<li><a href="#" class="active">แจ้งชำระเงิน</a></li>
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
						<h2>แจ้งชำระเงิน</h2>
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
				<form action="#">
					<div class="row">
						<div class="col-lg-6 col-md-12 col-12">
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>เวลาโอน<span class="text-danger">*</span></label>
											<input type="datetime-local" name="ntf_date" id="ntf_date" required>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="country-select">
											<label>ช่องทางการชำระเงิน<span class="text-danger">*</span></label>
											<?php
											$PaymentSQL = "SELECT * FROM bk_ord_payment WHERE pay_show = '1' ";
											$PaymentResult = mysqli_query($proj_connect, $PaymentSQL);
											?>
											<select name="payment_method">
												<?php
												// ตรวจสอบว่ามีข้อมูลหรือไม่
												if (mysqli_num_rows($PaymentResult) > 0) {
													// สร้างลูปเพื่อแสดงตัวเลือกการชำระเงิน
													while ($paymentData = mysqli_fetch_assoc($PaymentResult)) {
												?>
														<option value="<?= $paymentData['pay_id'] ?>"><?= $paymentData['pay_name'] ?></option>
												<?php
													}
												} else {
													echo '<option value="" disabled selected>ไม่มีข้อมูล</option>';
												}
												?>
											</select>

										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="country-select">
											<label>ราการสั่งซื้อที่ต้องการชำระเงิน<span class="text-danger">*</span></label>
											<?php
											$mmb_id = $_SESSION['mmb_id'];
											$OrderSQL = "SELECT * FROM bk_ord_orders WHERE mmb_id = '$mmb_id' AND ord_status = 'รอการชำระเงิน' ";
											$OrderResult = mysqli_query($proj_connect, $OrderSQL);
											?>
											<select name="ord_id" id="ord_id">
												<?php
												// ตรวจสอบว่ามีข้อมูลหรือไม่
												if (mysqli_num_rows($OrderResult) > 0) {
													// สร้างลูปเพื่อแสดงตัวเลือกการชำระเงิน
													while ($orderData = mysqli_fetch_assoc($OrderResult)) {
												?>
														<option value="<?= $orderData['ord_id'] ?>"><?= $orderData['ord_date'] . ' ยอดชำระ ' .  $orderData['ord_amount'] . 'บาท' ?></option>
												<?php
													}
												} else {
													echo '<option value="" disabled selected>ไม่มีข้อมูล</option>';
												}
												?>
											</select>

										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>จำนวนเงิน<span class="text-danger">*</span></label>
											<input type="number" name="ntf_amount" id="ntf_amount" placeholder="จำนวนเงินที่ชำระ" required>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>หลักฐานการโอน<span class="text-danger">*</span></label>
											<input type="file" placeholder="" required>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>

			</div>
			<div class="row">
				<br>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="buttons- mb-30">
						<ul>
							<!-- <button type="submit">อัปเดตตะกร้า</button> -->
							<li><a href="#" id="updateCartLink">ย้อนกลับ</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="wc-proceed-to-checkout">
						<ul>
							<!-- <button type="submit">อัปเดตตะกร้า</button> -->
							<li><a href="#" id="updateCartLink">แจ้งชำระเงิน</a></li>
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

</body>


</html>