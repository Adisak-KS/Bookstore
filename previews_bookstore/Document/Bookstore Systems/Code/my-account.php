<?php
require_once('connection.php');

if (!isset($_SESSION['mmb_id'])) {
	$_SESSION['status'] = "ไม่พบผู้ใช้ โปรดเข้าสู่ระบบ";
	$_SESSION['status_code'] = "ผิดพลาด";
	header('Location: login.php');
}

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
	echo "<script>window.location.href = 'my-account.php';</script>";
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
	<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
							<li><a href="#" class="active">บัญชีของฉัน</a></li>
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
						<h2>บัญชีของฉัน</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- entry-header-area-end -->
	<!-- my account wrapper start -->
	<div class="my-account-wrapper mb-70">
		<div class="container">
			<div class="section-bg-color">
				<div class="row">
					<div class="col-lg-12">
						<!-- My Account Page Start -->
						<div class="myaccount-page-wrapper">
							<!-- My Account Tab Menu Start -->
							<div class="row">
								<?php
								require('my-account-menu.php');
								?>
								<!-- My Account Tab Menu End -->


								<!-- My Account Tab Content Start -->
								<div class="col-lg-9 col-md-8">
									<div class="tab-content" id="myaccountContent">


										<!-- โอนเหรียญ Start -->
										<div class="tab-pane fade" id="tran-point" role="tabpanel">
											<div class="myaccount-content">
												<h5>โอนเหรียญ</h5>
												<div class="welcome">
													<form action="process_transfer.php" method="POST" onsubmit="return confirm('คุณต้องการที่จะโอนเหรียญหรือไม่?')">
														<input id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
														<label for="recipient">โอนเหรียญไปยัง<span class="text-danger">*</span></label><br>
														<input type="text" id="recipient" name="recipient" required><br><br>

														<label for="amount">จำนวนที่โอน<span class="text-danger">*</span></label> <strong>คุณมี <?php echo $mmb_row_result['mmb_coin'] ?> เหรียญ</strong><br>
														<input type="number" id="amount" name="amount" min="1" max="<?php echo $mmb_row_result['mmb_coin'] ?>" required value="0"><br><br>

														<input type="submit" value="โอนเหรียญ">
													</form>
												</div>
											</div>
										</div>
										<!-- โอนเหรียญ End -->

										<!-- Single Tab Content Start -->
										<div class="tab-pane fade show active" id="dashboad" role="tabpanel">

											<div class="myaccount-content">

												<h5>ข้อมูลส่วนตัว</h5>
												<div class="account-details-form">
													<!-- แก้ไขรูป -->
													<form id="uploadForm" method="POST" action="upload_profile_member.php" enctype="multipart/form-data" class="needs-validation" novalidate>
														<input type="hidden" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id']; ?>">
														<div class="form-group">

															<input type="text" name="mmb_id_display" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
														</div>
														<div class="form-group">
															<label> รูปประจำตัว<span class="text-danger">*</span></label>
															<br>
															<a href="profile/<?php echo $mmb_row_result['mmb_profile']; ?>" target="_blank"><img src="profile/<?php echo $mmb_row_result['mmb_profile']; ?>" style="width: 200px; height: 200px;"></a>
															<br>
														</div>

														<div class="col-lg-6">
															<input type="file" class="form-control" name="image" accept="image/*" required>
															<div class="invalid-feedback">
																เลือกรูปภาพที่ต้องการอัปโหลด
															</div>
															<br>
															<input type="submit" class="btn btn-sqr" name="upload" value="เปลี่ยนรูปประจำตัว">
														</div>
													</form>
													<br>
													<form action="update_profile.php" method="POST" class="needs-validation" novalidate>
														<div class="row">
														<div class="col-lg-6">
															<div class="single-input-item">
																<label for="display-name" class="required">ชื่อผู้ใช้</label>
																<input type="text" id="mmb_username" disabled readonly name="mmb_username" value="<?php echo $mmb_row_result['mmb_username'] ?>" class="form-control" required minlength="6" maxlength="20">
																<div class="invalid-feedback">
																	โปรดใส่ชื่อผู้ใช้ให้ถูกต้อง
																</div>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="single-input-item">
																<label for="display-name" class="required">เหรียญที่คุณมี</label>
																<input type="text" id="mmb_coin" disabled readonly name="mmb_coin" value="<?php echo $mmb_row_result['mmb_coin'] ?>" class="form-control" required minlength="6" maxlength="20">
																<div class="invalid-feedback">
																</div>
															</div>
														</div>
														</div>
														<hr>
														<div class="row">
															<div class="col-lg-6">
																<input type="text" id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
																<div class="single-input-item">
																	<label for="first-name" class="required">ชื่อจริง<span class="text-danger">*</span></label>
																	<input type="text" id="mmb_firstname" name="mmb_firstname" value="<?php echo $mmb_row_result['mmb_firstname'] ?>" class="form-control" required maxlength="20">
																	<div class="invalid-feedback">
																		โปรดใส่ชื่อจริง
																	</div>
																</div>
															</div>
															<div class="col-lg-6">
																<div class="single-input-item">
																	<label for="last-name" class="required">นามสกุล<span class="text-danger">*</span></label>
																	<input type="text" id="mmb_lastname" name="mmb_lastname" value="<?php echo $mmb_row_result['mmb_lastname'] ?>" class="form-control" required maxlength="20">
																	<div class="invalid-feedback">
																		โปรดใส่นามสกุล
																	</div>
																</div>
															</div>
														</div>

														<div class="single-input-item">
															<label for="email" class="required">อีเมล<span class="text-danger">*</span></label>
															<input type="email" id="mmb_email" name="mmb_email" value="<?php echo $mmb_row_result['mmb_email'] ?>" class="form-control" required maxlength="20">
															<div class="invalid-feedback">
																โปรดใส่อีเมล
															</div>
														</div>
														<div class="single-input-item">
															<button type="submit" id="updatebtn" name="updatebtn" class="btn btn-sqr">บันทึกข้อมูล</button>
														</div>
													</form>

													<form action="change_password.php" method="POST" onsubmit="return validatePassword()" class="needs-validation" novalidate>
														<input type="hidden" id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>">
														<fieldset>
															<legend>เปลี่ยนรหัสผ่าน</legend>
															<div class="single-input-item">
																<label for="current-pwd" class="required">รหัสผ่านเดิม<span class="text-danger">*</span></label>
																<input type="password" id="current-pwd" name="current-pwd" placeholder="รหัสผ่านเดิม" class="form-control" required>
																<div class="invalid-feedback">
																	โปรดใส่รหัสผ่านเดิม
																</div>
															</div>
															<div class="row">
																<div class="col-lg-6">
																	<div class="single-input-item">
																		<label for="new-pwd" class="required">รหัสผ่านใหม่<span class="text-danger">*</span></label>
																		<input type="password" id="new-pwd" name="new-pwd" placeholder="รหัสผ่านใหม่" maxlength="20" class="form-control" required>
																		<div class="invalid-feedback">
																			โปรดใส่รหัสผ่านใหม่
																		</div>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="single-input-item">
																		<label for="confirm-pwd" class="required">ยืนยันรหัสผ่านใหม่<span class="text-danger">*</span></label>
																		<input type="password" id="confirm-pwd" name="confirm-pwd" placeholder="ยืนยันรหัสผ่านใหม่" maxlength="20" class="form-control" required>
																	</div>
																	<div class="invalid-feedback">
																		โปรดยืนยันรหัสผ่านใหม่
																	</div>
																</div>
															</div>
														</fieldset>
														<div class="single-input-item">
															<button type="submit" class="btn btn-sqr">เปลี่ยนรหัสผ่าน</button>
														</div>
													</form>


												</div>

											</div>
										</div>
										<!-- Single Tab Content End -->
									</div>
								</div> <!-- My Account Tab Content End -->
							</div>
						</div> <!-- My Account Page End -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- my account wrapper end -->
	<!-- footer-area-start -->
	<footer>
		<?php
		require_once('footer.php');
		?>
	</footer>
	<!-- footer-area-end -->

	<script>
		function validatePassword() {
			const password = document.getElementById("new-pwd").value;
			const currentpwd = document.getElementById("current-pwd").value;
			const pwd = document.getElementById("new-pwd").value;
			const cpassword = document.getElementById("confirm-pwd").value;

			var pwd_alert = 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร, ตัวเลขอย่างน้อย 1 ตัว, ตัวอักษรตัวใหญ่อย่างน้อย 1 ตัว และ ตัวอักษรตัวเล็กอย่างน้อย 1 ตัว'

			// เช็คความยาวของรหัสผ่าน
			if (password.length < 8) {
				alert(pwd_alert);
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวเลขอย่างน้อยหนึ่งตัว
			if (!/\d/.test(password)) {
				alert(pwd_alert);
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวอักษรตัวใหญ่อย่างน้อยหนึ่งตัว
			if (!/[A-Z]/.test(password)) {
				alert(pwd_alert);
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวอักษรตัวเล็กอย่างน้อยหนึ่งตัว
			if (!/[a-z]/.test(password)) {
				alert(pwd_alert);
				return false;
			}

			// ตรวจสอบค่าว่าง
			// if (currentpwd.trim() === "" ||
			// 	pwd.trim() === "" ||
			// 	cpassword.trim() === "") {
			// 	alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
			// 	return false;
			// }

			// ตรวจสอบการยืนยันรหัสผ่าน
			if (pwd !== cpassword) {
				alert("ยืนยันรหัสผ่านไม่ตรงกัน");
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