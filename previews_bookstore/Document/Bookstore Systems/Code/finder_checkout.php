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
if (!($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['mmb_id']))) {
	$_SESSION['status'] = 'โปรดดำเนินการซื้ออีกครั้ง';
	$_SESSION['status_code'] = 'error';
	header('Location: finder_cart.php');
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
							<li><a href="#" class="active">การสั่งซื้อ</a></li>
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
						<h2>การส่งสินค้า</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- entry-header-area-end -->
	<!-- checkout-area-start -->
	<div class="checkout-area mb-70">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<form id="checkoutForm" method="POST" onsubmit="return validateForm()" class="parsley-examples needs-validation" novalidate action="finder_chechout_update.php">
						<div class="row">
							<div class="col-lg-6 col-md-12 col-12">
								<div class="checkbox-form">
									<?php
									$address_sql = "SELECT * 
									FROM bk_mmb_address 
									WHERE mmb_id = {$_SESSION['mmb_id']} 
									ORDER BY addr_active DESC
									";
									$addr_result = mysqli_query($proj_connect, $address_sql);
									?>
									<h3>เลือกที่อยู่จัดส่ง</h3>
									<div class="row">
										<h5>ใช้ที่อยู่จัดส่งหลัก</h5>
										<div class=" col-lg-12">
											<div class="checkout-form-list">
												<?php
												$addr_chk = false;
												// ตรวจสอบว่ามีข้อมูลหรือไม่
												if (mysqli_num_rows($addr_result) > 0) {
													$addr_chk = true;
													// สร้างลูปเพื่อแสดงตัวเลือกที่อยู่
													while ($addr_row = mysqli_fetch_assoc($addr_result)) {
												?>
														<div class="row">
															<div class="col-lg-1 col-md-6 col-12">

																<input type="radio" name="delivery_address" id="address_main" value="<?= htmlspecialchars($addr_row['addr_name'] . " " . $addr_row['addr_lastname'] . " " . $addr_row['addr_detail'] . " " . $addr_row['addr_provin'] . " " . $addr_row['addr_amphu'] . " " . $addr_row['addr_postal'] . " " . $addr_row['addr_phone']) ?>" required>
																<div class="invalid-feedback">
																	เลือกที่อยู่จัดส่ง
																</div>
															</div>
															<div class="col">
																<div class="contact-info">
																	<ul>
																		<li>
																			<?= $addr_row['addr_name'] . " " . $addr_row['addr_lastname'] ?>
																		</li>
																		<li>
																			<?= $addr_row['addr_detail'] . " " . $addr_row['addr_provin'] . " " . $addr_row['addr_amphu'] . " " . $addr_row['addr_postal'] ?>
																		</li>
																		<li>
																			<?= $addr_row['addr_phone'] ?>
																		</li>
																		<!-- <li>
																			<a href="my-account-address.php" target="_blank" style="color: #f8902c;">เปลี่ยนที่อยู่จัดส่งหลัก</a>
																		</li> -->
																	</ul>

																</div>
															</div>
														</div>
												<?php
													}
												} else {
													echo '<p>ยังไม่มีที่อยู่จัดส่ง กรุณาเพิ่มที่อยู่จัดส่งก่อนทำรายการ</p>';
												}
												?>
											</div>
										</div>
									</div>

									<!-- ใช้เป็นที่อยู่เฉพาะครั้งนี้ -->
									<div class="row">
										<div class=" col-lg-12">
											<div class="checkout-form-list">
												<div class="row">
													<h5>เฉพาะครั้งนี้</h5>
													<div class="col-lg-1 col-md-6 col-12">
														<input type="radio" name="delivery_address" id="address_temporary" value="addr_temporary" required>
														<div class="invalid-feedback">
															เลือกที่อยู่จัดส่ง
														</div>
													</div>
													<div class="col">
														<div class="contact-info">
															<ul>
																<li>
																	<div class="row">
																		<div class="col-lg-6">
																			<input type="text" id="mmb_id" name="mmb_id" value="66" hidden>
																			<div class="single-input-item">
																				<label for="first-name" class="required">ชื่อจริง</label>
																				<input type="text" id="mmb_firstname" name="mmb_firstname" maxlength="20" placeholder="ชื่อจริง">
																			</div>
																		</div>
																		<div class="col-lg-6">
																			<div class="single-input-item">
																				<label for="last-name" class="required">นามสกุล</label>
																				<input type="text" id="mmb_lastname" name="mmb_lastname" maxlength="20" placeholder="นามสกุล">
																			</div>
																		</div>
																	</div>
																	<div class="col-lg-12">
																		<div class="single-input-item">
																			<label for="last-name" class="required">รายละเอียดที่อยู่</label>
																			<textarea name="addr_detail" id="addr_detail" cols="60" rows="2" placeholder="อาคาร, เลขที่บ้าน"></textarea>
																		</div>
																	</div>
																	<?php
																	$prov_sql = "SELECT * FROM bk_province";
																	$prov_result = mysqli_query($proj_connect, $prov_sql);
																	?>
																	<div class="row">
																		<div class="col-lg-6">
																			<div class="single-input-item">
																				<div class="country-select">
																					<label for="last-name" class="required">จังหวัด</label>
																					<select name="addr_provin">
																						<option value="" disabled selected>--กรุณาเลือกจังหวัด--</option>
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
																		<div class="col-lg-6">
																			<label for="display-name" class="required">อำเภอ</label>
																			<input type="text" name="addr_amphu" placeholder="อำเภอ">
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-lg-6">
																			<label for="email" class="required">ไปรษณีย์</label>
																			<input type="text" name="addr_postal" placeholder="รหัสไปรษณีย์" maxlength="5">
																		</div>
																		<div class="col-lg-6">
																			<label for="email" class="required">เบอร์โทรติดต่อ</label>
																			<input type="text" name="addr_phone" id="addr_phone" placeholder="เบอร์โทรติดต่อ">
																		</div>
																	</div>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
											<div class="buttons-cart">
												<a href="my-account-finder-order.php" style="background-color: gray;">ย้อนกลับ</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-12">
								<div class="your-order">
									<h3>รายการสินค้า</h3>
									<div class="your-order-table table-responsive">
										<table>
											<tbody>
												<?php
												// ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
												if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['mmb_id'])) {
													// ดึงข้อมูลจาก session ที่กำหนดใน cart_session.php
													$mmb_id = $_SESSION['mmb_id'];
													$paymentMethod = $_POST['payment'];
													$shippingMethod = $_POST['shipping'];

													// ราคาสินค้าทั้งหมด
													$totalfnd_price = 0;

													// วนลูปแสดงข้อมูลสินค้า
													$fnd_id = $_GET['fnd_id'];

													// ตรวจสอบว่า $productID ไม่เป็นค่าว่าง
													if (empty($productID)) {
														// ดึงข้อมูลสินค้าจากฐานข้อมูล
														$sql = "SELECT * FROM bk_fnd_finder WHERE fnd_id = $fnd_id";
														$result = mysqli_query($proj_connect, $sql);
														$row = mysqli_fetch_assoc($result);
														if ($row['fnd_status'] != 'เลือกช่องทางส่งและช่องทางชำระ') {
															$_SESSION['status'] = 'ไม่พบรายการ';
															$_SESSION['status_code'] = 'Error';
															header('Location: my-account-finder-order.php');
														}

														$fnd_name = 'หาหนังสือตามสั่ง';
														$fnd_price = $row['fnd_price'];

														// นับรวมราคาสินค้าทั้งหมด
														$totalfnd_price += ($fnd_price);
												?>
														<tr class="cart_item">
															<td class="product-name">
																<?= $fnd_name ?>
															</td>
															<td><strong class="product-quantity"> × 1</strong></td>
															<td class="product-total">
																<span class="amount">฿<?= number_format($fnd_price, 2) ?></span>
															</td>
														</tr>
												<?php
													}

													// ราคาส่ง
													$sql_shipping = "SELECT * FROM bk_ord_shipping WHERE shp_id = $shippingMethod";
													$shp_result = mysqli_query($proj_connect, $sql_shipping);
													$shp_row = mysqli_fetch_assoc($shp_result);
													$shippingPrice = $shp_row['shp_price'];

													// นับรวมราคาสุทธิ
													$totalPrice = $totalfnd_price + $shippingPrice;
												} else {
													echo "<p>ไม่มีสินค้าในตะกร้า</p>";
												}
												?>
											</tbody>
											<tfoot>
												<tr class="order-total">
													<th>
														<br>
														<h6>ค่าจัดส่ง <?= $shp_row['shp_name'] ?></h6>
													</th>
													<td colspan="2">
														<br>
														<h2><span class="amount" style="color: gray;">฿<?= number_format($shp_row['shp_price'], 2) ?></span></h2>
													</td>
												</tr>
												<tr class="order-total">
													<th>
														<h5>ราคาสุทธิ</h5>
													</th>
													<td colspan="2"><strong><span class="amount" style="color: black;">฿<?= number_format($totalPrice, 2) ?></span></strong>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
									<div class="payment-method">
										<!-- เก็บข้อมูลไว้ใน post -->
										<input type="text" hidden name="payment" value="<?= $paymentMethod ?>">
										<input type="text" hidden name="shipping" value="<?= $shippingMethod ?>">
										<input type="text" hidden name="totalPrice" value="<?= $totalPrice ?>">
										<input type="text" hidden name="fnd_id" value="<?= $fnd_id ?>">
										<div class="order-button-payment">
											<input type="submit" value="ดำเนินการซื้อ" onclick="return validateForm()">
										</div>

									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- checkout-area-end -->
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

	<!-- ตรวจสอบที่อยู่ -->
	<script>
		function validateForm() {
			// ตรวจสอบค่าของ input ที่มี value เป็น "addr_temporary" หรือไม่
			var deliveryAddressInput = document.getElementById("address_temporary");
			var MainAddressInput = document.getElementById("address_main");

			// ตรวจสอบว่ามี element ที่มี id เป็น "address_temporary" หรือไม่
			if (MainAddressInput) {
				// ตรวจสอบว่า element นี้ถูก check หรือไม่
				if (MainAddressInput.checked) {
					deliveryAddress = MainAddressInput.value;
					//alert("ที่อยู่หลัก");
					return true; // ยกเลิกการ submit
				}
			}
			if (deliveryAddressInput) {
				if (deliveryAddressInput.checked) {
					deliveryAddress = deliveryAddressInput.value;
					//alert("ที่อยู่ชั่วคราว");
					// ตรวจสอบข้อมูลที่กรอกเฉพาะครั้งนี้
					var firstName = document.getElementById("mmb_firstname").value;
					var lastName = document.getElementById("mmb_lastname").value;
					var addrDetail = document.getElementById("addr_detail").value;
					var addrProvin = document.getElementsByName("addr_provin")[0].value;
					var addrAmphu = document.getElementsByName("addr_amphu")[0].value;
					var addrPostal = document.getElementsByName("addr_postal")[0].value;
					var addrPhone = document.getElementById("addr_phone").value;

					// ตรวจสอบความถูกต้องของข้อมูล
					if (
						firstName.trim() === "" ||
						lastName.trim() === "" ||
						addrDetail.trim() === "" ||
						addrProvin.trim() === "" ||
						addrAmphu.trim() === "" ||
						addrPostal.trim() === "" ||
						addrPhone.trim() === "" ||
						!/^\d{5}$/.test(addrPostal.trim()) || // ตรวจสอบรหัสไปรษณีย์ 5 ตัว
						!/^\d{9,12}$/.test(addrPhone.trim()) // ตรวจสอบเบอร์โทรศัพท์ 9-12 ตัวเลข
					) {
						var errorMessage = "กรุณากรอกข้อมูลที่อยู่ให้ถูกต้อง:\n";

						if (firstName.trim() === "") {
							errorMessage += "- กรุณากรอกชื่อจริง\n";
						}

						if (lastName.trim() === "") {
							errorMessage += "- กรุณากรอกนามสกุล\n";
						}

						if (addrDetail.trim() === "") {
							errorMessage += "- กรุณากรอกรายละเอียดที่อยู่\n";
						}

						if (addrProvin.trim() === "") {
							errorMessage += "- กรุณาเลือกจังหวัด\n";
						}

						if (addrAmphu.trim() === "") {
							errorMessage += "- กรุณากรอกอำเภอ\n";
						}

						if (addrPostal.trim() === "" || !/^\d{5}$/.test(addrPostal.trim())) {
							errorMessage += "- กรุณากรอกรหัสไปรษณีย์ 5 ตัวเลข\n";
						}

						if (addrPhone.trim() === "" || !/^\d{9,12}$/.test(addrPhone.trim())) {
							errorMessage += "- กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง\n";
						}

						alert(errorMessage);
						return false; // ยกเลิกการ submit
						exit;
					}
					return true; // ยกเลิกการ submit
				}
			} else {
				// กรณีที่ไม่พบ element ที่มี id เป็น "address_temporary"
				alert("ไม่พบที่อยู่");
				return false; // ยกเลิกการ submit
			}
		}
	</script>



</body>

</html>