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
if (empty($_SESSION['mmb_id']) || empty($_GET['ord_id'])) {
	$_SESSION['status'] = 'ไม่พบรายการชำระเงิน';
	$_SESSION['status_code'] = 'error';
	header('Location: index.php');
}
$ord_id = $_GET['ord_id'];
$ordSQL = "SELECT o.*, s.shp_name
FROM bk_ord_orders o
INNER JOIN bk_ord_shipping s ON o.shp_id = s.shp_id
WHERE o.ord_id = '$ord_id';
";
$ordResult = mysqli_query($proj_connect, $ordSQL);
$ordRow = mysqli_fetch_assoc($ordResult);
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
							<li><a href="#" class="active">รายละเอียกรายการสั่งซื้อ</a></li>
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
						<h2><?= $ordRow['ord_status'] ?></h2>
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
			if ($ordRow['ord_status'] == 'อยู่ระหว่างการขนส่ง') {
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
											<a href="order_finish.php?ord_id=<?= $ordRow['ord_id'] ?>" class="btn btn-sqr" style="background-color: #f87c2c; color: white;"><i class="fa fa-gift"></i> ฉันได้รับสินค้าแล้ว</a>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
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
										<input type="text" name="ntf_amount" id="ntf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $ordRow['shp_name'] ?>" readonly required>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-12">
									<div class="checkout-form-list">
										<label>ที่อยู่จัดส่ง </label>
										<div class="single-input-item">
											<textarea name="" id="" readonly><?= $ordRow['ord_address'] ?></textarea>
										</div>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-12">
									<div class="checkout-form-list">
										<label>เลขติดตามพัสดุ </label>
										<?php
										if ($ordRow['ord_detail'] != '-') {
										?>
											<a href="https://ems.thaiware.com/<?= $ordRow['ord_detail'] ?>">
												<p><?= $ordRow['ord_detail'] ?></p>
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
			$ntfSQL = "SELECT * FROM bk_ord_notification WHERE ord_id = '$ord_id'";
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
													<input type="text" name="ntf_amount" id="ntf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $ntfRow['ntf_date'] ?>" readonly required>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-12">
												<div class="checkout-form-list">
													<label>ช่องทางการชำระเงิน </label>

													<input type="text" name="ntf_amount" id="ntf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $payRow['pay_name'] ?>" readonly required>
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-12">
												<div class="checkout-form-list">
													<label>จำนวนเงิน </label>
													<input type="number" name="ntf_amount" id="ntf_amount" placeholder="จำนวนเงินที่ชำระ" value="<?= $ntfRow['ntf_amount'] ?>" readonly required>
												</div>
											</div>
											<div class="row">
												<?php
												$imgSQL = "SELECT * FROM bk_ord_ntf_image WHERE ntf_id = " . $ntfRow['ntf_id'];
												$imgResult = mysqli_query($proj_connect, $imgSQL);

												// Check if there are images
												if (mysqli_num_rows($imgResult) > 0) {
													while ($imgRow = mysqli_fetch_assoc($imgResult)) {
												?>
														<div class="col-lg-6 col-md-12 col-12">
															<div class="checkout-form-list">
																<label>หลักฐานการโอน </label>
																<img src="ntf_img/<?= $imgRow['nimg_img'] ?>" alt="" width="200px">
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
			$itm_sql = "SELECT * FROM bk_ord_item WHERE ord_id = '$ord_id'";
			$itm_result = mysqli_query($proj_connect, $itm_sql);

			if (mysqli_num_rows($itm_result) > 0) {
			?>
				<div class="row">
					<div class="col-lg-6 col-md-12 col-12">
						<div class="myaccount-content" id="myaccountContent">
							<h5>รายการสั่งซื้อ</h5>
							<div class="myaccount-table table-responsive text-center">
								<table class="table table-bordered">
									<thead class="thead-light">
										<tr>
											<th>รูป</th>
											<th>ชื่อสินค้า</th>
											<th>จำนวนที่ซื้อ</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$n = 0;
										while ($itm_row = mysqli_fetch_assoc($itm_result)) {
										?>
											<tr>
												<td>
													<?php
													// แสดงรูปสินค้า
													echo '<img src="prd_img/' . $itm_row['ordi_image'] . '" alt="Product Image" style="width: 50px; height: 50px;">';
													?>
												</td>
												<td><?= $itm_row['ordi_name'] ?></td>
												<td><?= $itm_row['ordi_quan'] ?></td>
												<?php
												$_SESSION['ordi_name'][$n] = $itm_row['ordi_name'];
												$_SESSION['ordi_quan'][$n] = $itm_row['ordi_quan'];
												$n++;
												?>

											</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
							<ul>
								<form action="reorder_session.php" method="POST">
									<input type="text" name="prd_name" id="prd_name" value="<?= implode(',', $_SESSION['ordi_name']) ?>" hidden>
									<input type="text" name="qty" id="qty" value="<?= implode(',', $_SESSION['ordi_quan']) ?>" hidden>
									<input type="text" name="loop" id="loop" value="<?= $n ?>" hidden>
									<br>
									<button type="submit" class="btn btn-sqr">ซื้ออีกครั้ง</button>
								</form>
							</ul>
						</div>
					</div>
				</div>
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
								<li><a href="my-account-my_order.php" style="background-color: gray;">ย้อนกลับ</a></li>
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
			var ntf_date = document.getElementById('ntf_date').value;
			var pay_id = document.getElementById('pay_id').value;
			var ntf_amount = document.getElementById('ntf_amount').value;
			var ntf_img = document.getElementById('ntf_img').value;

			// ตรวจสอบว่าข้อมูลถูกกรอกครบหรือไม่
			if (ntf_date.trim() === '' || pay_id.trim() === '' || ntf_amount.trim() === '' || ntf_img.trim() === '') {
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