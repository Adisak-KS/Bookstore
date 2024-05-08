<?php
require_once('connection.php');

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
	$status = $_SESSION['status'];
	$status_code = $_SESSION['status_code'];

	// เช็คว่ามีค่า upload_id ที่ส่งมาผ่าน URL
	if (isset($_GET['upload_id'])) {
		$upload_id = $_GET['upload_id'];

		// เพิ่มโค้ดที่ต้องการใช้งานกับค่า upload_id ได้ที่นี่
		// เช่น ใช้ $upload_id เพื่อดึงข้อมูลหรือประมวลผลต่อไป

		// เคลียร์ค่า session
		unset($_SESSION['status']);
		unset($_SESSION['status_code']);

		// แสดงหน้าต่างข้อความแจ้งเตือน
		echo "<script>alert('$status');</script>";
		echo "<script>window.location.href = '?upload_id=$upload_id';</script>";
		exit();
	}

	// เคลียร์ค่า session
	unset($_SESSION['status']);
	unset($_SESSION['status_code']);

	// แสดงหน้าต่างข้อความแจ้งเตือน
	echo "<script>alert('$status');</script>";
	echo "<script>window.location.href = 'login.php';</script>";
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
							<li><a href="#" class="active">เข้าสู่ระบบ</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumbs-area-end -->
	<!-- user-login-area-start -->
	<div class="user-login-area mb-70">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="login-title text-center mb-30">
						<h2>เข้าสู่ระบบ</h2>
					</div>
				</div>
				<div class="offset-lg-3 col-lg-6 col-md-12 col-12">
					<div class="login-form">
						<form method="POST" id="login_form" class="needs-validation" novalidate action="loginchk.php">
							<div class="single-login">
								<label>ชื่อผู้ใช้<span class="text-danger">*</span></label>
								<input type="text" id="login_input" name="login_input" maxlength="20" placeholder="ชื่อผู้ใช้" class="form-control" required>
								<div class="invalid-feedback">
									โปรดใส่ชื่อผู้ใช้
								</div>
							</div>
							<div class="single-login">
								<label>รหัสผ่าน<span class="text-danger">*</span></label>
								<input type="password" id="mmb_password" name="mmb_password" maxlength="20" placeholder="รหัสผ่าน" class="form-control" required>
								<div class="invalid-feedback">
									โปรดใส่รหัสผ่าน
								</div>
							</div>
							<hr>
							<!-- <div class="single-login single-login-2">
								<a href="#" onclick="submitLoginForm()">เข้าสู่ระบบ</a>
								<input id="rememberme" type="checkbox" name="rememberme" value="forever">
                    <span>จดจำ</span>
							</div> -->
							<div class="">
							
								<button type="submit" style="width: 100%;" name="addaddressbtn" class="btn btn-sqr">เข้าสู่ระบบ</button>
								<br><br>
								<a href="register.php"> สมัครสมาชิก</a>
							</div>
							
						
						<!-- <a href="#">ลืมรหัสผ่าน?</a> -->
				
							<!-- <div class="single-login"></div> -->
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- user-login-area-end -->
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

	<script>
		function submitLoginForm() {
			// ดึงค่าจากฟอร์ม
			var username = document.getElementById('login_input').value.trim();
			var password = document.getElementById('mmb_password').value.trim();

			// ตรวจสอบว่ามีค่าว่างหรือไม่
			if (username === '' || password === '') {
				alert('กรุณากรอกชื่อผู้ใช้และรหัสผ่าน');
			} else {
				// ถ้าข้อมูลถูกต้อง ให้ submit ฟอร์ม
				document.getElementById('login_form').submit();
			}
		}
	</script>

</body>

</html>