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
	echo "<script>window.location.href = 'register.php';</script>";
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
							<li><a href="#" class="active">สมัครสมาชิก</a></li>
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
						<h2>สมัครสมาชิก</h2>
					</div>
				</div>
				<div class="offset-lg-3 col-lg-6 col-md-12 col-12">
					<div class="login-form">
						<form method="POST" id="register_form" action="registerchk.php" class="needs-validation" novalidate onsubmit="return validatePassword()">
							<div class="single-login">
								<label>ชื่อผู้ใช้ <span class="text-danger">*</span></label>
								<input type="text" name="mmb_username" class="form-control" id="mmb_username" minlength="6" maxlength="20" placeholder="ชื่อผู้ใช้" required>
								<div class="invalid-feedback">
									โปรดใส่ชื่อผู้ใช้ให้ถูกต้อง
								</div>
							</div>
							<div class="single-login">
								<label>รหัสผ่าน <span class="text-danger">*</span></label>
								<input type="password" name="mmb_password" class="form-control" id="mmb_password" maxlength="20" placeholder="รหัสผ่าน" required>
								<div class="invalid-feedback">
									โปรดใส่รหัสผ่าน
								</div>
							</div>
							<div class="single-login">
								<label>ยืนยันรหัสผ่าน <span class="text-danger">*</span></label>
								<input type="password" name="cpassword" id="cpassword" class="form-control" maxlength="20" placeholder="ยืนยันรหัสผ่าน" required>
								<div class="invalid-feedback">
									โปรดยืนยันรหัสผ่าน
								</div>
							</div>
							<div class="single-login">
								<label>ชื่อจริง <span class="text-danger">*</span></label>
								<input type="text" name="mmb_firstname" id="mmb_firstname" class="form-control" maxlength="20" placeholder="ชื่อจริง" required>
								<div class="invalid-feedback">
									โปรดใส่ชื่อจริง
								</div>
							</div>
							<div class="single-login">
								<label>นามสกุล <span class="text-danger">*</span></label>
								<input type="text" name="mmb_lastname" id="mmb_lastname" class="form-control" maxlength="20" placeholder="นามสกุล" required>
								<div class="invalid-feedback">
									โปรดใส่นามสกุล
								</div>
							</div>
							<div class="single-login">
								<label>อีเมล <span class="text-danger">*</span></label>
								<input type="email" name="mmb_email" id="mmb_email" class="form-control" maxlength="20" placeholder="อีเมล" required>
								<div class="invalid-feedback">
									โปรดใส่อีเมล
								</div>
							</div>
							<div class="single-login single-login-2">
								<!-- <a href="#" onclick="submitForm()">สมัครสมาชิก</a> -->
								<button type="submit" name="addaddressbtn" class="btn btn-sqr">สมัครสมาชิก</button>
								<button type="button" name="addaddressbtn" class="btn btn-sqr-secondary" onclick="location.href='index.php';">ยกเลิก</button>
							</div>
							<div class="single-login single-login-2">
								<!-- <a href="index.php">ยกเลิก</a> -->

							</div>

						</form>

						<script>
							function submitForm() {
								// เรียกใช้ validateForm() เพื่อตรวจสอบข้อมูล
								if (validateForm()) {
									// ถ้าผ่านการ validate ให้ submit ฟอร์ม
									document.getElementById('register_form').submit();
								}
							}

							function validateForm() {
								var uname = document.getElementById("mmb_username").value;
								var pwd = document.getElementById("mmb_password").value;
								var cpassword = document.getElementById("cpassword").value;
								var fname = document.getElementById("mmb_firstname").value;
								var lname = document.getElementById("mmb_lastname").value;
								var email = document.getElementById("mmb_email").value;

								// ตรวจสอบค่าว่าง
								if (uname.trim() === "" ||
									pwd.trim() === "" ||
									cpassword.trim() === "" ||
									fname.trim() === "" ||
									lname.trim() === "" ||
									email.trim() === "") {
									alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
									return false;
								}

								// ตรวจสอบการยืนยันรหัสผ่าน
								if (pwd !== cpassword) {
									alert("ยืนยันรหัสผ่านไม่ตรงกัน");
									return false;
								}

								return true; // ส่งฟอร์มเมื่อข้อมูลถูกต้องทั้งหมด
							}
						</script>
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

	<script>
		function validatePassword() {
			var password = document.getElementById("mmb_password").value;

			// เช็คความยาวของรหัสผ่าน
			if (password.length < 8) {
				alert("รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร");
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวเลขอย่างน้อยหนึ่งตัว
			if (!/\d/.test(password)) {
				alert("รหัสผ่านต้องประกอบด้วยตัวเลขอย่างน้อย 1 ตัว");
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวอักษรตัวใหญ่อย่างน้อยหนึ่งตัว
			if (!/[A-Z]/.test(password)) {
				alert("รหัสผ่านต้องประกอบด้วยตัวอักษรตัวใหญ่อย่างน้อย 1 ตัว");
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวอักษรตัวเล็กอย่างน้อยหนึ่งตัว
			if (!/[a-z]/.test(password)) {
				alert("รหัสผ่านต้องประกอบด้วยตัวอักษรตัวเล็กอย่างน้อย 1 ตัว");
				return false;
			}

			// ถ้าผ่านการตรวจสอบทั้งหมด
			return true;
		}
	</script>
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