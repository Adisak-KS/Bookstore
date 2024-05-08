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
								<div class="col-lg-3 col-md-4">
									<div class="myaccount-tab-menu nav" role="tablist">
										<a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-user"></i>
											ข้อมูลส่วนตัว</a>
										<a href="my-account-address.php"><i class="fa fa-cart-arrow-down"></i>
											ที่อยู่</a>
										<a href="#download" data-bs-toggle="tab"><i class="fa fa-cloud-download"></i>
											บัตรเครดิต</a>
										<a href="#payment-method" data-bs-toggle="tab"><i class="fa fa-credit-card"></i>
											ประวัติการสั่งซื้อ</a>
										<a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i>
											สิ่งที่อยากได้</a>
										<a href="#tran-point" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
											โอนเหรียญ</a>
										<a href="#" data-bs-toggle="tab"><i class="fa fa-sign-out"></i>
											ประวัติการโอนเหรียญ</a>
										<a href="login.html"><i class="fa fa-sign-out"></i> ออกจากระบบ</a>
									</div>
								</div>
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
													<form id="uploadForm" method="POST" action="upload_profile_member.php" enctype="multipart/form-data">
														<input type="hidden" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id']; ?>">
														<div class="form-group">

															<input type="text" name="mmb_id_display" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
														</div>
														<div class="form-group">
															<label> รูปประจำตัว </label>
															<br>
															<a href="profile/<?php echo $mmb_row_result['mmb_profile']; ?>" target="_blank"><img src="profile/<?php echo $mmb_row_result['mmb_profile']; ?>" style="max-width: 200px; max-height: 200px;"></a>
															<br>
														</div>
														<input type="file" name="image" accept="image/*">
														<input type="submit" name="upload" value="เปลี่ยนรูปประจำตัว">
													</form>
													<br>
													<form action="update_profile.php" method="POST">
														<div class="row">
															<div class="col-lg-6">
																<input type="text" id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
																<div class="single-input-item">
																	<label for="first-name" class="required">ชื่อจริง</label>
																	<input type="text" id="mmb_firstname" name="mmb_firstname" value="<?php echo $mmb_row_result['mmb_firstname'] ?>" required maxlength="20">
																</div>
															</div>
															<div class="col-lg-6">
																<div class="single-input-item">
																	<label for="last-name" class="required">นามสกุล</label>
																	<input type="text" id="mmb_lastname" name="mmb_lastname" value="<?php echo $mmb_row_result['mmb_lastname'] ?>" required maxlength="20">
																</div>
															</div>
														</div>
														<div class="single-input-item">
															<label for="display-name" class="required">ชื่อผู้ใช้</label>
															<input type="text" id="mmb_username" name="mmb_username" value="<?php echo $mmb_row_result['mmb_username'] ?>" required maxlength="20">
														</div>
														<div class="single-input-item">
															<label for="email" class="required">อีเมล</label>
															<input type="email" id="mmb_email" name="mmb_email" value="<?php echo $mmb_row_result['mmb_email'] ?>" required maxlength="20">
														</div>
														<div class="single-input-item">
															<button type="submit" id="updatebtn" name="updatebtn" class="btn btn-sqr">บันทึกข้อมูล</button>
														</div>
													</form>

													<form action="change_password.php" method="POST" onsubmit="return validateChangePasswordForm()">
														<input type="hidden" id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>">
														<fieldset>
															<legend>เปลี่ยนรหัสผ่าน</legend>
															<div class="single-input-item">
																<label for="current-pwd" class="required">รหัสผ่านเดิม</label>
																<input type="password" id="current-pwd" name="current-pwd" placeholder="รหัสผ่านเดิม" required>
															</div>
															<div class="row">
																<div class="col-lg-6">
																	<div class="single-input-item">
																		<label for="new-pwd" class="required">รหัสผ่านใหม่</label>
																		<input type="password" id="new-pwd" name="new-pwd" placeholder="รหัสผ่านใหม่" maxlength="20" required>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="single-input-item">
																		<label for="confirm-pwd" class="required">ยืนยันรหัสผ่านใหม่</label>
																		<input type="password" id="confirm-pwd" name="confirm-pwd" placeholder="ยืนยันรหัสผ่านใหม่" maxlength="20" required>
																	</div>
																</div>
															</div>
														</fieldset>
														<div class="single-input-item">
															<button type="submit" class="btn btn-sqr">เปลี่ยนรหัสผ่าน</button>
														</div>
													</form>

													<script>
														function validateChangePasswordForm() {

															var currentpwd = document.getElementById("current-pwd").value;
															var pwd = document.getElementById("new-pwd").value;
															var cpassword = document.getElementById("confirm-pwd").value;

															// ตรวจสอบค่าว่าง
															if (currentpwd.trim() === "" ||
																pwd.trim() === "" ||
																cpassword.trim() === "") {
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
										<!-- Single Tab Content End -->

										<!-- ที่อยู่ -->
										<div class="tab-pane fade" id="orders" role="tabpanel">
											<?php
											$sql_script = "SELECT * FROM bk_mmb_address WHERE mmb_id = " . $mmb_row_result['mmb_id'] . " ORDER BY addr_active DESC";
											$addr_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
											$addr_totalrows_result = mysqli_num_rows($addr_result);
											$addr_num = 0;
											while ($addr_row_result = mysqli_fetch_assoc($addr_result)) {
											?>
												<div class="myaccount-content">
													<h5>
														<?php
														if ($addr_row_result['addr_active'] == 1) {
															echo 'ที่อยู่หลัก';
														} else {
															echo 'ที่อยู่';
														}
														?>
													</h5>
													<div class="account-details-form">
														<form action="member_address_update.php" method="POST">
															<div class="row">
																<div class="col-lg-6">
																	<input type="text" id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
																	<input type="text" name="addr_id" id="addr_id" value="<?= $addr_row_result['addr_id'] ?>" hidden>
																	<div class="single-input-item">
																		<label for="first-name" class="required">ชื่อ</label>
																		<input type="text" name="addr_name" value="<?php echo $addr_row_result['addr_name'] ?>" placeholder="ชื่อ" required>
																	</div>
																</div>
																<div class="col-lg-6">
																	<input type="text" id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
																	<input type="text" name="addr_id" id="addr_id" value="<?= $addr_row_result['addr_id'] ?>" hidden>
																	<div class="single-input-item">
																		<label for="first-name" class="required">นามสกุล</label>
																		<input type="text" name="addr_lastname" value="<?php echo $addr_row_result['addr_lastname'] ?>" placeholder="นามสกุล" required>
																	</div>
																</div>
															</div>
															<div class="col-lg-6">
																<input type="text" id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
																<input type="text" name="addr_id" id="addr_id" value="<?= $addr_row_result['addr_id'] ?>" hidden>
																<div class="single-input-item">
																	<label for="first-name" class="required">รายละเอียดที่อยู่</label>
																	<input type="text" name="addr_detail" value="<?php echo $addr_row_result['addr_detail'] ?>" placeholder="เลขที่ย้าน หมู่ที่ ถนน ตำบล/เขต" required>
																</div>
															</div>
															<?php
															// เมื่อกด submit และไม่มีการเลือกจังหวัดให้แสดงข้อความเตือน
															if (isset($_POST['submit']) && !$province_selected) {
																echo '<p style="color: red;">กรุณาเลือกจังหวัดอย่างน้อยหนึ่งจังหวัด</p>';
															}
															$prov_sql = "SELECT * FROM bk_province";
															$prov_result = mysqli_query($proj_connect, $prov_sql);
															?>
															<div class="col-lg-6">
																<div class="single-input-item">
																	<div class="country-select">
																		<label for="last-name" class="required">จังหวัด</label>
																		<select name="addr_provin">

																			<option value="<?= $addr_row_result['addr_provin'] ?>" selected><?= $addr_row_result['addr_provin'] ?></option>
																			<?php if (mysqli_num_rows($prov_result) > 0) {
																				// Loop เพื่อสร้าง option สำหรับแต่ละจังหวัด
																				while ($prov_row = mysqli_fetch_assoc($prov_result)) {
																			?>
																					<option value="<?= $prov_row['prov_name'] ?>"><?= $prov_row['prov_name'] ?></option>
																			<?php
																				}
																			} else {
																				echo "<option value=''>ไม่มีข้อมูล</option>";
																			}
																			?>
																		</select>
																	</div>
																</div>
															</div>

															<div class="single-input-item">
																<label for="display-name" class="required">อำเภอ</label>
																<input type="text" name="addr_amphu" value="<?php echo $addr_row_result['addr_amphu'] ?>" placeholder="Enter Amphur" required>
															</div>
															<div class="single-input-item">
																<label for="email" class="required">ไปรษณีย์</label>
																<input type="text" name="addr_postal" value="<?php echo $addr_row_result['addr_postal'] ?>" placeholder="Enter Postal Code" required>
															</div>
															<div class="single-input-item">
																<label for="email" class="required">เบอร์โทรติดต่อ</label>
																<input type="text" name="addr_phone" id="addr_phone" value="<?php echo $addr_row_result['addr_phone'] ?>" placeholder="Enter Phone Number" required>
															</div>
															<?php
															if ($addr_row_result['addr_active'] == 1) {
															?>
																<div class="col-lg-4 col-md-6 col-12">
																	<br>
																	<input type="radio" name="addr_active" id="addr_active" value="1" class="shipping" checked><label for="email" class="required"> ใช้เป็นที่อยู่หลัก</label>
																</div>
															<?php
															} else {
															?>
																<div class="col-lg-4 col-md-6 col-12">
																	<br>
																	<input type="radio" name="addr_active" id="addr_active" value="1" class="shipping"><label for="email" class="required"> ใช้เป็นที่อยู่หลัก</label>
																</div>
															<?php
															}
															?>
															<div class="single-input-item">
																<button type="submit" name="deleteaddrbtn" class="btn btn-sqr"> ลบ </button>
																<button type="submit" name="updateaddrbtn" class="btn btn-sqr"> แก้ไข </button>
															</div>
														</form>

													</div>
												</div>
											<?php } ?>


											<!-- เพิ่มที่อยู่ -->
											<!-- ตัวแปรรายชื่อจังหวัด -->

											<div class="account-details-form">

												<div class="account-details-form">
													<div class="modal-header">
														<h5>เพิ่มที่อยู่ใหม่</h5>
													</div>
													<form id="member_address_add_form" action="member_address_add.php" method="POST">
														<div class="single-input-item">
															<div class="single-input-item">
																<input type="text" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" hidden>
															</div>
															<div class="row">
																<div class="col-lg-6">
																	<div class="single-input-item">
																		<label for="first-name" class="required">ชื่อ</label>
																		<input type="text" name="addr_name" id="addr_name" placeholder="ชื่อ" required>
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="single-input-item">
																		<label for="first-name" class="required">นามสกุล</label>
																		<input type="text" name="addr_lastname" id="addr_lastname" placeholder="นามสกุล" required>
																	</div>
																</div>
															</div>
															<div class="single-input-item">
																<label>รายละเอียดที่อยู่</label>
																<textarea name="addr_detail" id="addr_detail" placeholder="เลขที่บ้าน หมู่ที่ ถนน ตำบล เขต" required></textarea>
															</div>
															<?php
															$prov_sql = "SELECT * FROM bk_province";
															$prov_result = mysqli_query($proj_connect, $prov_sql);
															?>
															<div class="single-input-item">
																<div class="country-select">
																	<label>จังหวัด</label>
																	<select name="addr_provin" required>
																		<option value="" disabled selected>กรุณาเลือกจังหวัด</option>
																		<?php
																		if (mysqli_num_rows($prov_result) > 0) {
																			// Loop เพื่อสร้าง option สำหรับแต่ละจังหวัด
																			while ($prov_row = mysqli_fetch_assoc($prov_result)) {
																		?>
																				<option value="<?= $prov_row['prov_name'] ?>"><?= $prov_row['prov_name'] ?></option>
																		<?php
																			}
																		} else {
																			echo "<option value='' disabled>ไม่มีข้อมูล</option>";
																		}
																		?>
																	</select>
																</div>
															</div>

															<div class="single-input-item">
																<label> อำเภอ </label>
																<input type="text" name="addr_amphu" id="addr_amphu" placeholder="ใส่อำเภอ" required>
															</div>
															<div class="single-input-item">
																<label> รหัสไปรษณีย์ </label>
																<input type="text" name="addr_postal" id="addr_postal" placeholder="ใส่รหัสไปรษณีย์" onblur="validatePostalCode()" required>
																<span id="postal_error" style="color: red;"></span>
															</div>

															<script>
																function validatePostalCode() {
																	var postalCodeInput = document.getElementById("addr_postal").value;
																	var postalCodePattern = /^[0-9]{5}$/; // ตรวจสอบรหัสไปรษณีย์ 5 หลักเป็นตัวเลขเท่านั้น

																	if (!postalCodePattern.test(postalCodeInput)) {
																		document.getElementById("postal_error").innerText = "กรุณากรอกรหัสไปรษณีย์ให้ถูกต้อง (5 หลักเป็นตัวเลข)";
																	} else {
																		document.getElementById("postal_error").innerText = "";
																	}
																}
															</script>
															<div class="single-input-item">
																<label> เบอร์ติดต่อ </label>
																<input type="text" name="addr_phone" id="addr_phone" class="single-input-item" placeholder="ใส่เบอร์โทรศัพท์" onblur="validatePhoneNumber()" required>
																<span id="phone_error" style="color: red;"></span>
															</div>

															<script>
																function validatePhoneNumber() {
																	var phoneInput = document.getElementById("addr_phone").value;
																	var phonePattern = /^[0-9]{10}$/; // ตรวจสอบเบอร์โทรศัพท์ 10 หลักเป็นตัวเลขเท่านั้น

																	if (!phonePattern.test(phoneInput)) {
																		document.getElementById("phone_error").innerText = "กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง (10 หลักเป็นตัวเลข)";
																	} else {
																		document.getElementById("phone_error").innerText = "";
																	}
																}
															</script>
														</div>
														<br>
														<div class="modal-footer">
															<button type="submit" name="addaddressbtn" class="btn btn-sqr" onclick="validateAndSubmit()">บันทึก</button>
														</div>
													</form>
													<script>
														function validateAndSubmit() {
															// ตรวจสอบข้อมูลที่ต้องการ validate
															var addr_detail = document.getElementById("addr_detail").value;
															var addr_provin = document.getElementById("addr_provin").value;
															var addr_amphu = document.getElementById("addr_amphu").value;
															var addr_postal = document.getElementById("addr_postal").value;
															var addr_phone = document.getElementById("addr_phone").value;

															// เขียนเงื่อนไขในการตรวจสอบข้อมูล
															if (addr_detail === "" || addr_provin === "" || addr_amphu === "" || addr_postal === "" || addr_phone === "") {
																alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
																return; // ยกเลิกการดำเนินการต่อ
															}

															// เพิ่มเงื่อนไขตรวจสอบความถูกต้องของรหัสไปรษณีย์ (5 ตัวเลข)
															var postalPattern = /^[0-9]{5}$/;
															if (!postalPattern.test(addr_postal)) {
																alert("กรุณากรอกรหัสไปรษณีย์ให้ถูกต้อง (5 ตัวเลข)");
																return; // ยกเลิกการดำเนินการต่อ
															}


															// เพิ่มเงื่อนไขตรวจสอบความถูกต้องของเบอร์โทรศัพท์ (9-14 ตัวและสามารถมี "+" "-" "*" ได้)
															var phonePattern = /^[0-9*+-]{9,14}$/;
															if (!phonePattern.test(addr_phone)) {
																alert("กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง");
																return; // ยกเลิกการดำเนินการต่อ
															}

															// เมื่อข้อมูลครบถ้วนทุกช่อง สามารถส่งฟอร์มได้
															document.getElementById("member_address_add_form").submit();
														}
													</script>
												</div>

											</div>
											<!-- จบเพิ่มที่อยู่ -->

										</div>
										<!-- ที่อยู่ -->

										<!-- Single Tab Content Start -->
										<div class="tab-pane fade" id="download" role="tabpanel">
											<div class="myaccount-content">
												<h5>Downloads</h5>
												<div class="myaccount-table table-responsive text-center">
													<table class="table table-bordered">
														<thead class="thead-light">
															<tr>
																<th>Product</th>
																<th>Date</th>
																<th>Expire</th>
																<th>Download</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Haven - Free Real Estate PSD Template</td>
																<td>Aug 22, 2018</td>
																<td>Yes</td>
																<td><a href="#" class="btn btn-sqr"><i class="fa fa-cloud-download"></i>
																		Download File</a></td>
															</tr>
															<tr>
																<td>HasTech - Profolio Business Template</td>
																<td>Sep 12, 2018</td>
																<td>Never</td>
																<td><a href="#" class="btn btn-sqr"><i class="fa fa-cloud-download"></i>
																		Download File</a></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- Single Tab Content End -->

										<!-- Single Tab Content Start -->
										<div class="tab-pane fade" id="payment-method" role="tabpanel">
											<div class="myaccount-content">
												<h5>Payment Method</h5>
												<p class="saved-message">You Can't Saved Your Payment Method yet.</p>
											</div>
										</div>
										<!-- Single Tab Content End -->

										<!-- Single Tab Content Start -->
										<div class="tab-pane fade" id="address-edit" role="tabpanel">
											<div class="myaccount-content">
												<h5>Billing Address</h5>
												<address>
													<p><strong>Erik Jhonson</strong></p>
													<p>1355 Market St, Suite 900 <br>
														San Francisco, CA 94103</p>
													<p>Mobile: (123) 456-7890</p>
												</address>
												<a href="#" class="btn btn-sqr"><i class="fa fa-edit"></i>
													Edit Address</a>
											</div>
										</div>
										<!-- Single Tab Content End -->

										<!-- Single Tab Content Start -->
										<div class="tab-pane fade" id="account-info" role="tabpanel">
											<div class="myaccount-content">
												<h5>Account Details</h5>
												<div class="account-details-form">
													<form action="#">
														<div class="row">
															<div class="col-lg-6">
																<div class="single-input-item">
																	<label for="first-name" class="required">First
																		Name</label>
																	<input type="text" id="first-name" placeholder="First Name" />
																</div>
															</div>
															<div class="col-lg-6">
																<div class="single-input-item">
																	<label for="last-name" class="required">Last
																		Name</label>
																	<input type="text" id="last-name" placeholder="Last Name" />
																</div>
															</div>
														</div>
														<div class="single-input-item">
															<label for="display-name" class="required">Display Name</label>
															<input type="text" id="display-name" placeholder="Display Name" />
														</div>
														<div class="single-input-item">
															<label for="email" class="required">Email Addres</label>
															<input type="email" id="email" placeholder="Email Address" />
														</div>
														<fieldset>
															<legend>Password change</legend>
															<div class="single-input-item">
																<label for="current-pwd" class="required">Current
																	Password</label>
																<input type="password" id="current-pwd" placeholder="Current Password" />
															</div>
															<div class="row">
																<div class="col-lg-6">
																	<div class="single-input-item">
																		<label for="new-pwd" class="required">New
																			Password</label>
																		<input type="password" id="new-pwd" placeholder="New Password" />
																	</div>
																</div>
																<div class="col-lg-6">
																	<div class="single-input-item">
																		<label for="confirm-pwd" class="required">Confirm
																			Password</label>
																		<input type="password" id="confirm-pwd" placeholder="Confirm Password" />
																	</div>
																</div>
															</div>
														</fieldset>
														<div class="single-input-item">
															<button class="btn btn-sqr">Save Changes</button>
														</div>
													</form>
												</div>
											</div>
										</div> <!-- Single Tab Content End -->
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