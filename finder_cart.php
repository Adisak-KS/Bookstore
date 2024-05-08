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
} // ตรวจสอบสิทธิ์
if (!(isset($_SESSION['mmb_id']))) {
	$_SESSION['status'] = "กรูณาเข้าสู่ระบบ";
	$_SESSION['status_code'] = "ผิดพลาด";
	header('Location: login.php');
}
if (isset($_GET['fnd_id'])) {
	$_SESSION['fnd_id'] = $_GET['fnd_id'];
	$fnd_id = $_SESSION['fnd_id'];
} elseif (!isset($_GET['fnd_id'])) {
	$fnd_id = $_SESSION['fnd_id'];
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

<body class="home">
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
				<div class="col-lg-6 col-md-12 col-12">
					<!-- Finder order -->
					<?php
					//$fnd_id = 2;
					$fditSQL = "SELECT * FROM bk_fnd_item WHERE fnd_id = '$fnd_id' ORDER BY fdit_id DESC LIMIT 1; ";
					$fditResult = mysqli_query($proj_connect, $fditSQL);
					$fditRow = mysqli_fetch_assoc($fditResult);
					?>
					<div class="myaccount-content" id="myaccountContent">
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
										<textarea name="fdit_detail" id="fdit_detail" class="form-control" cols="30" rows="4"><?= $fditRow['fdit_detail'] ?></textarea>
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
					<div class="wc-proceed-to-checkout">
					<div class="myaccount-content" id="myaccountContent">
								<ul>
									<!-- <button type="submit">อัปเดตตะกร้า</button> -->
									<li><a href="finder_cancel.php" style="background-color: red;">ยกเลิกรายการหาหนังสือ</a></li>
								</ul>
							</div>
						<div class="myaccount-content" id="myaccountContent">
							<ul>
								<!-- <button type="submit">อัปเดตตะกร้า</button> -->
								<li><a href="my-account-finder-order.php" style="background-color: gray;">ย้อนกลับ</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-12">
					<div class="cart_totals">
						<?php
						$sql_shipping = "SELECT * FROM bk_ord_shipping WHERE shp_show = '1'";
						$shp_result = mysqli_query($proj_connect, $sql_shipping) or die(mysqli_connect_error());
						$shp_row_result = mysqli_fetch_assoc($shp_result);
						$shp_totalrows_result = mysqli_num_rows($shp_result);

						$sql_payment = "SELECT * FROM bk_ord_payment WHERE pay_show = '1'";
						$pay_result = mysqli_query($proj_connect, $sql_payment) or die(mysqli_connect_error());
						$pay_row_result = mysqli_fetch_assoc($pay_result);
						$pay_totalrows_result = mysqli_num_rows($pay_result);

						if ($shp_row_result > 0 && $pay_row_result > 0) {
						?>
							<h3></h3>
							<h3>สรุปรายการซื้อ</h3>
							<?php

							$fndSQL = "SELECT * FROM bk_fnd_finder WHERE fnd_id = '$fnd_id';";
							$fndResult = mysqli_query($proj_connect, $fndSQL);
							$fndRow = mysqli_fetch_assoc($fndResult);

							if ($fndRow['fnd_status'] != 'เลือกช่องทางส่งและช่องทางชำระ') {
								$_SESSION['status'] = 'ไม่พบรายการ';
								$_SESSION['status_code'] = 'Error';
								header('Location: my-account-finder-order.php');
							}
							// ตรวจสอบว่ามีรายการหรือไม่
							if (isset($_SESSION['mmb_id'])) {
								// มีรายการ
							?>
								<div class="row">
									<table>
										<form id="cart_form" action="finder_checkout.php?fnd_id=<?= $fnd_id ?>" method="POST">

											<tbody>
												<tr class="cart-subtotal">
													<th style="font-size: 18px;">ราคารวม</th>
													<td>
														<span class="amount" style="font-size: 20px; color: gray;"><?php echo number_format($fndRow['fnd_price'], 2); ?></span>
													</td>
												</tr>

												<tr class="shipping">
													<th style="font-size: 18px;">ช่องทางการส่ง</th>
													<?php


													$cumprice = $fndRow['fnd_price'];
													?>
													<td>
														<ul id="shipping_method">
															<?php do { ?>
																<li>
																	<input type="radio" name="shipping" id="shipping" value="<?php echo $shp_row_result['shp_id'] ?>" required>
																	<label for="shipping" style="font-size: 20px;">
																		<?php echo $shp_row_result['shp_name'] ?>
																		<span class="amount" style="font-size: 20px; color: gray;"><?php echo number_format($shp_row_result['shp_price'], 2) ?></span>
																	</label>
																</li>
															<?php } while ($shp_row_result = mysqli_fetch_assoc($shp_result)); ?>
														</ul>
													</td>
												</tr>
												<tr class="shipping">
													<th style="font-size: 18px;">วิธีการชำระเงิน</th>
													<?php
													?>
													<td>
														<ul>
															<?php do { ?>
																<li>
																	<input type="radio" name="payment" value="<?php echo $pay_row_result['pay_id']; ?>" required>
																	<img src="pay_logo/<?= $pay_row_result['pay_logo']; ?>" alt="payment" width="75px">
																	<label style="font-size: 20px;">
																		<?php echo $pay_row_result['pay_name']; ?>
																	</label>
																</li>
															<?php } while ($pay_row_result = mysqli_fetch_assoc($pay_result)); ?>
														</ul>
													</td>
												</tr>
												<tr class="order-total">
													<th style="font-size: 20px;">ราคาสุทธิ</th>
													<td>
														<strong>
															<span class="amount" id="finalPrice" style="font-weight:bold; font-size: 22px;"><?php echo number_format($cumprice, 2); ?></span>
														</strong>
													</td>
												</tr>
											</tbody>
										</form>
									</table>
								</div>


								<div class="wc-proceed-to-checkout">
									<input type="int" name="cumprice" value="<?php echo number_format($cumprice, 2); ?>" hidden>
									<a href="#" onclick="submit_cart_form()">ชำระเงิน</a>
								</div>
								</form>
						<?php
							} else {
								// ไม่มีรายการ
								echo '<p>ยังไม่มีสินค้าในตะกร้า</p>';
							}
						} else {
							echo '<p>ยังไม่มีช่องทางชำระเงินหรือช่องทางขนส่ง</p>';
						}
						?>
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

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var shippingRadios = document.querySelectorAll('input[name="shipping"]');
			var orderTotalAmount = document.querySelector('.order-total .amount');

			// เพิ่มอีเวนต์ change ให้กับทุก radio button ในกลุ่ม "shipping"
			shippingRadios.forEach(function(radio) {
				radio.addEventListener('change', function() {
					// ทำการคำนวณราคาสุทธิทันทีที่ผู้ใช้เลือกช่องทางการขนส่ง
					calculateTotalPrice();
				});
			});

			// ฟังก์ชันคำนวณราคาสุทธิ
			function calculateTotalPrice() {
				var productPrice = parseFloat(<?php echo $cumprice; ?>);
				var shippingPrice = 0;

				// หากมี radio button ที่ถูกเลือก
				var selectedShipping = document.querySelector('input[name="shipping"]:checked');
				if (selectedShipping) {
					shippingPrice = parseFloat(selectedShipping.nextElementSibling.querySelector('.amount').textContent);
				}

				// รวมราคาสุทธิ
				var totalPrice = productPrice + shippingPrice;

				// แสดงผลใน HTML
				orderTotalAmount.textContent = totalPrice.toFixed(2);
			}
		});
	</script>


	<script>
		function checkInput(input) {
			var value = parseInt(input.value);
			var min = parseInt(input.getAttribute('min'));
			var max = parseInt(input.getAttribute('max'));
			input.value = input.value.replace(/[^\d]/g, '');

			// ตรวจสอบว่าค่าอยู่ในช่วงที่ถูกต้องหรือไม่
			if (value < min) {
				input.value = min;
			} else if (value > max) {
				input.value = max;
			}
		}
	</script>

	<!-- ปุ่มชำระเงิน -->
	<script>
		function submit_cart_form() {
			// ตรวจสอบค่าของ radio buttons ในกลุ่ม shipping
			var selectedShipping = document.querySelector('input[name="shipping"]:checked');
			// ตรวจสอบค่าของ radio buttons ในกลุ่ม payment
			var selectedPayment = document.querySelector('input[name="payment"]:checked');

			// ตรวจสอบว่ามีการเลือก shipping และ payment หรือไม่
			if (selectedShipping && selectedPayment) {
				// ถ้ามีการเลือก shipping และ payment ให้ submit ฟอร์ม
				document.getElementById('cart_form').submit();
			} else {
				// ถ้าไม่มีการเลือก shipping หรือ payment ให้แสดง alert
				alert('กรุณาเลือกช่องทางการส่งและวิธีการชำระเงิน');
			}
		}
	</script>

</body>


</html>