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
} elseif (isset($_SESSION['fnd_id'])) {
	$fnd_id = $_SESSION['fnd_id'];
}
$fndSQL = "SELECT f.*, s.shp_name
FROM bk_fnd_finder AS f
INNER JOIN bk_ord_shipping AS s ON f.shp_id = s.shp_id
WHERE f.fnd_id = '$fnd_id';
";
$fndResult = mysqli_query($proj_connect, $fndSQL);
$fndRow = mysqli_fetch_assoc($fndResult);
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
							<li><a href="#" class="active">รายละเอียดรายการหาหนังสือ</a></li>
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
						<h2>
							<?php
							if ($fndRow['fnd_status'] == 'รอการตรวจสอบ') {
								echo 'ผู้ดูแลกำลังค้นหาหนังสือตามสั่ง';
							} elseif ($fndRow['fnd_status'] == 'รอสมาชิกตรวจสอบ') {
								echo 'โปรดตรวจสอบผลการตามหาของคุณ';
							} elseif ($fndRow['fnd_status'] == 'กำลังค้นหา') {
								echo 'ผู้ดูแลกำลังค้นหาหนังสือตามสั่ง';
							} else {
								echo $fndRow['fnd_status'];
							}
							?></h2>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- entry-header-area-end -->
	<!-- cart-main-area-start -->
	<div class="cart-main-area mb-70">
		<div class="container">
			<?php
			if ($fndRow['fnd_status'] == 'อยู่ระหว่างการขนส่ง') {
			?>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12">
						<div class="myaccount-content" id="myaccountContent">
							<h5>ได้รับสินค้าแล้ว</h5>
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>คุณได้ตรวจสอบและได้รับสินค้าแล้ว? </label>
											<a href="finder_finish.php?fnd_id=<?= $fndRow['fnd_id'] ?>" class="btn btn-sqr" style="background-color: #f87c2c; color: white;"><i class="fa fa-gift"></i> ฉันได้รับสินค้าแล้ว</a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			if ($fndRow['fnd_address'] != '') {
			?>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12">
						<div class="myaccount-content" id="myaccountContent">
							<h5>รายละเอียดการจัดส่ง</h5>
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>ช่องทางการจัดส่ง </label>
											<input type="text" name="fdnf_amount" id="fdnf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $fndRow['shp_name'] ?>" readonly required>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>ที่อยู่จัดส่ง </label>
											<div class="single-input-item">
												<textarea name="" id="" readonly><?= $fndRow['fnd_address'] ?></textarea>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>เลขติดตามพัสดุ </label>
											<?php
											if ($fndRow['fnd_track'] != '-') {
											?>
												<a href="https://ems.thaiware.com/<?= $fndRow['fnd_track'] ?>">
													<p><?= $fndRow['fnd_track'] ?></p>
												</a>
											<?php
											} else {
											?>
												<p>ยังไม่ได้รับเลขติดตามพัสดุ</p>
											<?php
											}
											?>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			$ntfSQL = "SELECT * FROM bk_fnd_notification WHERE fnd_id = '$fnd_id'";
			$ntfResult = mysqli_query($proj_connect, $ntfSQL);
			$ntfRow = mysqli_fetch_assoc($ntfResult);

			if ($ntfRow > 0) {
			?>
				<div class="row">
					<form action="notify_add.php" method="POST" enctype="multipart/form-data" name="notify_form" id="notify_form">
						<div class="row">
							<?php


							$PaymentSQL = "SELECT * FROM bk_ord_payment WHERE pay_id = " . $ntfRow['pay_id'];
							$PaymentResult = mysqli_query($proj_connect, $PaymentSQL);
							$payRow = mysqli_fetch_assoc($PaymentResult);

							?>
							<div class="col-lg-6 col-md-12 col-12">
								<div class="myaccount-content" id="myaccountContent">
									<h5>รายละเอียดการชำระเงิน</h5>
									<div class="checkbox-form">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-12">
												<div class="checkout-form-list">
													<label>เวลาโอน </label>
													<input type="text" name="fdnf_amount" id="fdnf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $ntfRow['fdnf_date'] ?>" readonly required>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-12">
												<div class="checkout-form-list">
													<label>ช่องทางการชำระเงิน </label>

													<input type="text" name="fdnf_amount" id="fdnf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $payRow['pay_name'] ?>" readonly required>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-12">
												<div class="checkout-form-list">
													<label>จำนวนเงิน </label>
													<input type="number" name="fdnf_amount" id="fdnf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $ntfRow['fdnf_amount'] ?>" readonly required>
												</div>
											</div>
											<div class="row">
												<?php
												$imgSQL = "SELECT * FROM bk_fnd_ntf_image WHERE fdnf_id = " . $ntfRow['fdnf_id'];
												$imgResult = mysqli_query($proj_connect, $imgSQL);

												// Check if there are images
												if (mysqli_num_rows($imgResult) > 0) {
													while ($imgRow = mysqli_fetch_assoc($imgResult)) {
												?>
														<div class="col-lg-6 col-md-12 col-12">
															<div class="checkout-form-list">
																<label>หลักฐานการโอน </label>
																<img src="fnimg_image/<?= $imgRow['fnimg_image'] ?>" alt="" width="200px">
															</div>
														</div>
												<?php
													}
												} else {
													// Display a message if there are no images
													echo '<p>ไม่พบรูปภาพ</p>';
												}
												?>
											</div>

										</div>
									</div>

								</div>
							</div>
					</form>

				</div>
			<?php
			}
			?>
			<?php
			//คำสั่งตามหา

			if ($fndRow['fnd_status'] == 'กำลังค้นหา') {
			?>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12">
						<div class="myaccount-content" id="myaccountContent">
							<h5>ข้อมูลคำสั่งตามหาหนังสือของคุณ</h5>
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อหนังสือ </label>
											<input type="text" name="fnd_name" id="fnd_name" readonly value="<?= $fndRow['fnd_name'] ?>">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อผู้เขียน </label>
											<input type="text" name="fnd_author" id="fnd_author" readonly value=<?= $fndRow['fnd_author'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>สำนักพิมพ์ </label>
											<input type="text" name="fnd_publisher" id="fnd_publisher" readonly value=<?= $fndRow['fnd_publisher'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>เล่มที่ </label>
											<input type="text" name="fnd_volumn" id="fnd_volumn" readonly value=<?= $fndRow['fnd_volumn'] ?>>
										</div>
									</div>
									<div class="col-lg-6 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>ภาพประกอบ </label>
											<?php
											if ($fndRow['fnd_img'] == '') {
												echo 'ไม่มีรูปภาพ';
											} else {
											?>
												<img src="fnd_img/<?= $fndRow['fnd_img'] ?>" alt="" width="200px">
											<?php
											}
											?>
										</div>
									</div>
									<input type="text" name="mmb_id" id="mmb_id" value="<?= $_SESSION['mmb_id'] ?>" hidden>
								</div>
							</div>
						</div>
						<div class="wc-proceed-to-checkout">
							<div class="myaccount-content" id="myaccountContent">
								<ul>
									<!-- <button type="submit">อัปเดตตะกร้า</button> -->
									<li><a href="finder_cancel.php" style="background-color: red;">ยกเลิกรายการหาหนังสือ</a></li>
								</ul>
							</div>
						</div>
					</div>

				</div>
			<?php
			}
			?>
			<?php
			if ($fndRow['fnd_status'] == 'จัดส่งสำเร็จ' || $fndRow['fnd_status'] == 'รอการตรวจสอบการชำระเงิน') {

				$fditSQL = "SELECT * FROM bk_fnd_item
			WHERE fnd_id = '$fnd_id'
			ORDER BY fdit_id DESC
			LIMIT 1;
			";
				$fditResult = mysqli_query($proj_connect, $fditSQL);
				$fditRow = mysqli_fetch_assoc($fditResult);
			?>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12">
						<div class="myaccount-content" id="myaccountContent">
							<h5>หนังสือที่คุณตามหา</h5>
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อหนังสือ </label>
											<input type="text" name="fnd_name" id="fnd_name" readonly value="<?= $fditRow['fdit_name'] ?>">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อผู้เขียน </label>
											<input type="text" name="fnd_author" id="fnd_author" readonly value=<?= $fditRow['fdit_author'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>สำนักพิมพ์ </label>
											<input type="text" name="fnd_publisher" id="fnd_publisher" readonly value=<?= $fditRow['fdit_publisher'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>เล่มที่ </label>
											<input type="text" name="fnd_volumn" id="fnd_volumn" readonly value=<?= $fditRow['fdit_volumn'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>รายละเอียด </label>
											<textarea name="fdit_detail" id="fdit_detail" class="form-control" readonly cols="30" rows="4"><?= $fditRow['fdit_detail'] ?></textarea>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>ราคาสุทธิ </label>
											<input type="text" name="fnd_price" id="fnd_price" readonly value=<?= $fndRow['fnd_price'] ?>>
										</div>
									</div>
									<div class="col-lg-6 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>ภาพประกอบ </label>
											<img src="fdit_img/<?= $fditRow['fdit_img'] ?>" alt="" width="200px">
										</div>
									</div>
									<input type="text" name="mmb_id" id="mmb_id" value="<?= $_SESSION['mmb_id'] ?>" hidden>
									<?php
									if ($fditRow['fdit_status'] == 'รอการยืนยัน') {
									?>

										<!-- ตามหาใหม่ -->


										<div class="row">
											<br>
											<div class="col-lg-6 col-md-6 col-12">
												<div class="wc-proceed-to-checkout">
													<ul>
														<!-- <button type="submit">อัปเดตตะกร้า</button> -->
														<li><a href="finder_update.php?fdit_id=<?= $fditRow['fdit_id'] ?>&fdit_status=1" id="refnd" class="cancel-link" style="background: red;">ตามหาใหม่</a></li>
													</ul>
												</div>
											</div>
											<div class="col-lg-6 col-md-6 col-12">
												<div class="wc-proceed-to-checkout">
													<ul>
														<!-- <button type="submit">อัปเดตตะกร้า</button> -->
														<li style="float: right;"><a href="finder_update.php?fdit_id=<?= $fditRow['fdit_id'] ?>&fdit_status=2" id="confirm">ยืนยัน</a></li>
													</ul>
												</div>
											</div>
										</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
			<?php
			//คำสั่งตามหา

			if ($fndRow['fnd_status'] == 'รอการตรวจสอบ' || $fndRow['fnd_status'] == 'cancel' || $fndRow['fnd_status'] == 'ไม่พบสินค้าที่ต้องการ') {
			?>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12">
						<div class="myaccount-content" id="myaccountContent">
							<h5>ข้อมูลคำสั่งตามหาหนังสือของคุณ</h5>
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อหนังสือ </label>
											<input type="text" name="fnd_name" id="fnd_name" readonly value="<?= $fndRow['fnd_name'] ?>">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อผู้เขียน </label>
											<input type="text" name="fnd_author" id="fnd_author" readonly value=<?= $fndRow['fnd_author'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>สำนักพิมพ์ </label>
											<input type="text" name="fnd_publisher" id="fnd_publisher" readonly value=<?= $fndRow['fnd_publisher'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>เล่มที่ </label>
											<input type="text" name="fnd_volumn" id="fnd_volumn" readonly value=<?= $fndRow['fnd_volumn'] ?>>
										</div>
									</div>
									<div class="col-lg-6 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>ภาพประกอบ </label>
											<?php
											if ($fndRow['fnd_img'] == '') {
												echo 'ไม่มีรูปภาพ';
											} else {
											?>
												<img src="fnd_img/<?= $fndRow['fnd_img'] ?>" alt="" width="200px">
											<?php
											}
											?>
										</div>
									</div>
									<input type="text" name="mmb_id" id="mmb_id" value="<?= $_SESSION['mmb_id'] ?>" hidden>
								</div>
							</div>
						</div>
						<?php
						if ($fndRow['fnd_status'] == 'รอการตรวจสอบ') {
						?>
							<div class="wc-proceed-to-checkout">
								<div class="myaccount-content" id="myaccountContent">
									<ul>
										<!-- <button type="submit">อัปเดตตะกร้า</button> -->
										<li><a href="finder_cancel.php" style="background-color: red;">ยกเลิกรายการหาหนังสือ</a></li>
									</ul>
								</div>
							</div>
						<?php
						}
						?>
					</div>

				</div>
				<?php
			}
			//การตอบกลับ
			$fditSQL = "SELECT * FROM bk_fnd_item
			WHERE fnd_id = '$fnd_id'
			ORDER BY fdit_id DESC
			LIMIT 1;
			";
			$fditResult = mysqli_query($proj_connect, $fditSQL);
			$fditRow = mysqli_fetch_assoc($fditResult);
			if ($fditRow > 0) {

				if ($fndRow['fnd_status'] == 'รอสมาชิกตรวจสอบ') {
				?>
					<div class="row">
						<div class="col-lg-6 col-md-12 col-12">
							<div class="myaccount-content" id="myaccountContent">
								<div class="row">
									<h5>ข้อมูลคำสั่งตามหาหนังสือของคุณ</h5>
									<div class="checkbox-form">
										<div class="row">
											<form id="editFinderForm" action="finder_edit.php" method="POST" enctype="multipart/form-data">
												<div class="col-lg-12 col-md-6 col-12 ">
													<div class="checkout-form-list">
														<label>ชื่อหนังสือ </label>
														<input type="text" name="fnd_name" id="fnd_name" value="<?= $fndRow['fnd_name'] ?>">
													</div>
												</div>
												<div class="col-lg-12 col-md-6 col-12 ">
													<div class="checkout-form-list">
														<label>ชื่อผู้เขียน </label>
														<input type="text" name="fnd_author" id="fnd_author" value=<?= $fndRow['fnd_author'] ?>>
													</div>
												</div>
												<div class="col-lg-12 col-md-6 col-12 ">
													<div class="checkout-form-list">
														<label>สำนักพิมพ์ </label>
														<input type="text" name="fnd_publisher" id="fnd_publisher" value=<?= $fndRow['fnd_publisher'] ?>>
													</div>
												</div>
												<div class="col-lg-12 col-md-12 col-12">
													<div class="checkout-form-list">
														<label>เล่มที่ </label>
														<input type="text" name="fnd_volumn" id="fnd_volumn" value=<?= $fndRow['fnd_volumn'] ?>>
													</div>
												</div>
												<div class="col-lg-8 col-md-12 col-12">
													<label>ภาพประกอบ </label>
													<br>
													<?php
													if ($fndRow['fnd_img'] == '') {
														echo 'ไม่มีรูปภาพ';
													} else {
													?>
														<img src="fnd_img/<?= $fndRow['fnd_img'] ?>" alt="" width="200px">
													<?php
													}
													?>
													<input type="file" class="form-control" required name="fnd_img" id="fnd_img" accept="image/*">
												</div>
												<input type="text" name="mmb_id" id="mmb_id" value="<?= $_SESSION['mmb_id'] ?>" hidden>
												<input type="text" name="fnd_id" id="fnd_id" value="<?= $fnd_id ?>" hidden />
												<input type="text" name="fnd_oldimg" id="fnd_oldimg" value="<?= $fndRow['fnd_img'] ?>" hidden />
												<div class="col-lg-6 col-md-6 col-12">
													<div class="wc-proceed-to-checkout">
														<ul>
															<li><a href="#" onclick="submitForm()">บันทึกข้อมูลการแก้ไข</a></li>
														</ul>
													</div>
											</form>
											<script>
												function submitForm() {
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

													document.getElementById("editFinderForm").submit();
												}
											</script>
										</div>
									</div>

								</div>
							</div>

							<hr>
							<h5>ใช่หนังสือที่คุณต้องการ ?</h5>
							<div class="checkbox-form">
								<div class="row">
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อหนังสือ </label>
											<input type="text" disabled name="fnd_name" id="fnd_name" readonly value="<?= $fditRow['fdit_name'] ?>">
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>ชื่อผู้เขียน </label>
											<input type="text" disabled name="fnd_author" id="fnd_author" readonly value=<?= $fditRow['fdit_author'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-6 col-12 ">
										<div class="checkout-form-list">
											<label>สำนักพิมพ์ </label>
											<input type="text" disabled name="fnd_publisher" id="fnd_publisher" readonly value=<?= $fditRow['fdit_publisher'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>เล่มที่ </label>
											<input type="text" disabled name="fnd_volumn" id="fnd_volumn" readonly value=<?= $fditRow['fdit_volumn'] ?>>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>รายละเอียด </label>
											<textarea name="fdit_detail" disabled id="fdit_detail" class="form-control" readonly cols="30" rows="4"><?= $fditRow['fdit_detail'] ?></textarea>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>ราคาสุทธิ </label>
											<input type="text" name="fnd_price" disabled id="fnd_price" readonly value=<?= $fndRow['fnd_price'] ?>>
										</div>
									</div>
									<div class="col-lg-6 col-md-12 col-12">
										<div class="checkout-form-list">
											<label>ภาพประกอบ </label>
											<img src="fdit_img/<?= $fditRow['fdit_img'] ?>" alt="" width="200px">
										</div>
									</div>
									<input type="text" name="mmb_id" id="mmb_id" value="<?= $_SESSION['mmb_id'] ?>" hidden>
									<?php
									if ($fditRow['fdit_status'] == 'รอการยืนยัน') {
									?>

										<!-- ตามหาใหม่ -->


										<div class="row">
											<br>
											<div class="col-lg-6 col-md-6 col-12">
												<div class="wc-proceed-to-checkout">
													<ul>
														<!-- <button type="submit">อัปเดตตะกร้า</button> -->
														<li><a href="finder_update.php?fdit_id=<?= $fditRow['fdit_id'] ?>&fdit_status=1" id="refnd" class="cancel-link" style="background: red;">ตามหาใหม่</a></li>
													</ul>
												</div>
											</div>
											<div class="col-lg-6 col-md-6 col-12">
												<div class="wc-proceed-to-checkout">
													<ul>
														<!-- <button type="submit">อัปเดตตะกร้า</button> -->
														<li style="float: right;"><a href="finder_update.php?fdit_id=<?= $fditRow['fdit_id'] ?>&fdit_status=2" id="confirm">ยืนยัน</a></li>
													</ul>
												</div>
											</div>
										</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>

		</div>
	<?php
				}
	?>
<?php
			}
?>
<div class="row">
	<br>
	<div class="col-lg-6 col-md-6 col-12">
		<div class="wc-proceed-to-checkout">
			<div class="myaccount-content" id="myaccountContent">
				<ul>
					<!-- <button type="submit">อัปเดตตะกร้า</button> -->
					<li><a href="my-account-finder-order.php" style="background-color: gray;">ย้อนกลับ</a></li>
				</ul>
			</div>
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
			var fdnf_img = document.getElementById('fdnf_img').value;

			// ตรวจสอบว่าข้อมูลถูกกรอกครบหรือไม่
			if (fdnf_date.trim() === '' || pay_id.trim() === '' || fdnf_amount.trim() === '' || fdnf_img.trim() === '') {
				alert('กรุณากรอกข้อมูลให้ครบถ้วน');
				return false; // ไม่ทำการ submit ฟอร์ม
			} else {
				// นำรหัส JavaScript ที่ใช้ในการ submit ฟอร์มมาวางที่นี่
				document.getElementById("notify_form").submit();
			}
		}
	</script>

</body>


</html>