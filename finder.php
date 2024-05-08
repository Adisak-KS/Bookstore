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
	$_SESSION['status'] = 'โปรดเข้าสู่ระบบก่อนทำรายการ';
	$_SESSION['status_code'] = 'error';
	header('Location: login.php');
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
							<li><a href="#" class="active">หาหนังสือตามสั่ง</a></li>
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
						<h2>หาหนังสือตามสั่ง</h2>
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
				<form action="finder_add.php" method="POST" enctype="multipart/form-data" name="finder_form" id="finder_form" class="needs-validation" novalidate>
					<div class="row">
						<div class="col-lg-6 col-md-12 col-12">
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อหนังสือ </label>
											<input type="text" name="fnd_name" id="fnd_name" placeholder="ชื่อหนังสือ" required>
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อผู้เขียน </label>
											<input type="text" name="fnd_author" id="fnd_author" placeholder="ชื่อผู้เขียน, ผู้แต่ง, ผู้วาด" required>
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>สำนักพิมพ์ </label>
											<input type="text" name="fnd_publisher" id="fnd_publisher" placeholder="สำนักพิมพ์ของหนังสือ" required>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>เล่มที่ </label>
											<input type="text" name="fnd_volumn" id="fnd_volumn" placeholder="หนังสือของคุณเล่มที่เท่าไหร่ ?" required>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>รูปภาพประกอบ </label>
										</div>
										<input type="file" class="form-control" required name="fnd_img" id="fnd_img" accept="image/*">

									</div>
									<input type="text" name="mmb_id" id="mmb_id" value="<?= $_SESSION['mmb_id'] ?>" hidden>
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
							<li><a href="index.php" style="background-color: gray; color: white;" class="btn-sqr">ย้อนกลับ</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-12">
					<div class="wc-proceed-to-checkout">
						<ul>
							<li><a href="#" id="submit">ดำเนินการต่อ</a></li>
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

	<!-- ถ้าไม่ใช้ jQuery -->
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			document.getElementById("submit").addEventListener("click", function() {
				// เพิ่มตรวจสอบข้อมูลที่นี่
				var fndName = document.getElementById("fnd_name").value;
				var fndAuthor = document.getElementById("fnd_author").value;
				var fndPublisher = document.getElementById("fnd_publisher").value;
				var fndVolumn = document.getElementById("fnd_volumn").value;
				var fndImg = document.getElementById("fnd_img").value;

				if (fndName === '' && fndAuthor === '' && fndPublisher === '' && fndVolumn === '' && fndImg === '') {
					alert("กรุณากรอกข้อมูลอย่างน้อย 1 อย่าง");
					return;
				}

				// ถ้าข้อมูลถูกต้อง ให้ส่งฟอร์ม
				document.getElementById("finder_form").submit();
			});
		});
	</script>




</body>


</html>