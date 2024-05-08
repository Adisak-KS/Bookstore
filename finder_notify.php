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
if (empty($_SESSION['mmb_id'])) {
	$_SESSION['status'] = 'ไม่พบรายการชำระเงิน';
	$_SESSION['status_code'] = 'error';
	header('Location: index.php');
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

$fnd_id = $fnd_id;
$FinderSQL = "SELECT * FROM bk_fnd_finder WHERE fnd_id = '$fnd_id'";
$FinderResult = mysqli_query($proj_connect, $FinderSQL);
$FinderRow = mysqli_fetch_assoc($FinderResult);

if (!($FinderRow['fnd_status'] == 'รอการชำระเงิน' || $FinderRow['fnd_status'] == 'การชำระเงินไม่ถูกต้อง')) {
	$_SESSION['status'] = 'ไม่พบรายการชำระเงิน';
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
				<form action="finder_notify_add.php" method="POST" enctype="multipart/form-data" name="notify_form" id="notify_form">
					<div class="row">
						<div class="col-lg-6 col-md-12 col-12">
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>เวลาโอน<span class="text-danger">*</span></label>
											<input type="datetime-local" name="fdnf_date" id="fdnf_date" required>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="country-select">
											<label>ช่องทางการชำระเงิน<span class="text-danger">*</span></label>
											<?php
											$PaymentSQL = "SELECT * FROM bk_ord_payment WHERE pay_show = '1' ";
											$PaymentResult = mysqli_query($proj_connect, $PaymentSQL);
											?>
											<select name="pay_id" id="pay_id">
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
										<div class="checkout-form-list">
											<label>จำนวนเงิน<span class="text-danger">*</span></label>
											<input type="number" name="fdnf_amount" id="fdnf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $FinderRow['fnd_totalprice'] ?>" readonly required>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
											<label>หลักฐานการโอน<span class="text-danger">*</span></label>
											<input type="file" required class="form-control" name="fnimg_image[]" id="fnimg_image" multiple accept="image/jpeg, image/jpg, image/png">
										</div>
									<input type="text" name="fnd_id" id="fnd_id" value="<?= $FinderRow['fnd_id'] ?>" hidden>
									<input type="text" name="mmb_id" id="mmb_id" value="<?= $FinderRow['mmb_id'] ?>" hidden>
								</div>
							</div>
						</div>
					</div>
				</form>

			</div>
			<div class="row">
				<br>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="wc-proceed-to-checkout">
						<ul>
							<!-- <button type="submit">อัปเดตตะกร้า</button> -->
							<li><a href="finder_payment.php?fnd_id=<?= $FinderRow['fnd_id'] ?>" style="background-color: gray;">ย้อนกลับ</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="wc-proceed-to-checkout">
						<ul>
							<!-- <button type="submit">อัปเดตตะกร้า</button> -->
							<li><a href="#" id="updateCartLink" onclick="submitPaymentForm()">แจ้งชำระเงิน</a></li>
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

	<!-- submit form -->
	<script>
		function submitPaymentForm() {
			var fdnf_date = document.getElementById('fdnf_date').value;
			var pay_id = document.getElementById('pay_id').value;
			var fdnf_amount = document.getElementById('fdnf_amount').value;
			var fnimg_image = document.getElementById('fnimg_image');

			// ตรวจสอบว่าข้อมูลถูกกรอกครบหรือไม่
			if (fdnf_date.trim() === '' || pay_id.trim() === '' || fdnf_amount.trim() === '') {
				alert('กรุณากรอกข้อมูลให้ครบถ้วน');
				return false; // ไม่ทำการ submit ฟอร์ม
			}

			// ตรวจสอบจำนวนไฟล์ที่ถูกเลือก
			var files = fnimg_image.files;
			var maxFiles = 3;

			if (files.length > maxFiles) {
				alert('คุณสามารถเลือกไฟล์ได้ไม่เกิน ' + maxFiles + ' ไฟล์');
				return false; // ไม่ทำการ submit ฟอร์ม
			}
			if (files.length == 0) {
				alert('กรุณาอัปโหลดหลักฐานการชำระเงิน ');
				return false; // ไม่ทำการ submit ฟอร์ม
			}

			// นำรหัส JavaScript ที่ใช้ในการ submit ฟอร์มมาวางที่นี่
			document.getElementById("notify_form").submit();
		}
	</script>


</body>


</html>