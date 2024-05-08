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

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['mmb_id']))) {
	$_SESSION['status'] = "กรูณาเข้าสู่ระบบ";
	$_SESSION['status_code'] = "ผิดพลาด";
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
							<li><a href="#" class="active">ตะกร้า</a></li>
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
						<h2>ตะกร้า</h2>
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
				<div class="col-lg-12">
					<form action="cart_update.php" method="POST" id="addToCartForm">
						<div class="table-content table-responsive mb-15 border-1">
							<style>
								.product-table th,
								.product-table td {
									font-size: 16px;
									/* ปรับขนาดตัวอักษรตามที่คุณต้องการ */
								}
							</style>

							<?php

							$total = 0;
							$cumprice = 0;
							$m = 1;
							$_SESSION['sum_coin'] = 0;
							// ตรวจสอบว่ามีรายการหรือไม่
							if (isset($_SESSION['intLine']) && isset($_SESSION['mmb_id']) && $_SESSION['intLine'] >= 0) {
								// มีรายการ
							?>
								<table class="product-table">
									<thead>
										<tr>
											<th class="product-thumbnail">รูป</th>
											<th class="product-name">ชื่อ</th>
											<th class="product-price">ราคา</th>
											<th class="product-price">จำนวน</th>
											<th class="product-quantity">เหรียญที่ได้รับ</th>
											<th class="product-subtotal">ราคารวม</th>
											<th class="product-remove">นำออก</th>
										</tr>
									</thead>
									<tbody>
										<?php
										//$_SESSION['total_items'] = 0;
										for ($i = 0; $i <= (int)$_SESSION['intLine']; $i++) {
											if (isset($_SESSION['strProductID'][$i]) && (($_SESSION['strProductID'][$i]) != '')) {
												$prd_id = $_SESSION['strProductID'][$i];
												$sql_script = "SELECT * FROM bk_prd_product WHERE prd_id = $prd_id";
												$prd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
												$prd_row_result = mysqli_fetch_assoc($prd_result);


												$_SESSION['price'] = $prd_row_result['prd_price'];
												$total = $_SESSION['strQty'][$i];
												$sum = $prd_row_result['prd_price'] - ($prd_row_result['prd_discount'] / 100 * $prd_row_result['prd_price']);

												//$_SESSION['total_items'] =+ $total;
										?>
												<tr>
													<td><img src="prd_img/<?php echo $prd_row_result['prd_img']; ?>" width="50px" /></td>
													<td style="font-size: 16px;"><?php echo $prd_row_result['prd_name']; ?></td>
													<td style="font-size: 16px;"><?php echo number_format($sum, 2); ?></td>
													<td class="product-quantity"><input style="background-color: white;" name="qty<?php echo $i; ?>" type="number" min="1" max="<?php echo $prd_row_result['prd_qty']; ?>" value="<?php echo $total ?>" oninput="checkInput(this)"></td>
													<td style="font-size: 16px;"><?php echo $prd_row_result['prd_coin'] * $total; ?></td>
													<td style="font-size: 16px;"><?php echo number_format($sum * $total, 2); ?></td>
													<td class="product-remove"><a href="cart_delete.php?Line=<?php echo $i; ?>"><i style="color:#ec5048;" class="fa-solid fa-trash"></i></a></td>
												</tr>
										<?php
												$_SESSION['update_loop'] = $i;
												$_SESSION['sum_coin'] = $_SESSION['sum_coin'] + ($prd_row_result['prd_coin'] * $total);
												$cumprice = $cumprice + ($sum * $total);
												$m++;
											}
										}

										?>
									</tbody>
								</table>
							<?php
							} else {
								// ไม่มีรายการ
								echo '<p>ยังไม่มีสินค้าในตะกร้า</p>';
							}
							?>
						</div>

				</div>
			</div>

			<?php
			// มีรายการ
			$sql_shipping = "SELECT * FROM bk_ord_shipping WHERE shp_show = '1'";
			$shp_result = mysqli_query($proj_connect, $sql_shipping) or die(mysqli_connect_error());
			$shp_row_result = mysqli_fetch_assoc($shp_result);
			$shp_totalrows_result = mysqli_num_rows($shp_result);

			$sql_payment = "SELECT * FROM bk_ord_payment WHERE pay_show = '1'";
			$pay_result = mysqli_query($proj_connect, $sql_payment) or die(mysqli_connect_error());
			$pay_row_result = mysqli_fetch_assoc($pay_result);
			$pay_totalrows_result = mysqli_num_rows($pay_result);

			$sql_promotion = "SELECT * 
			FROM bk_promotion 
			WHERE prp_show = '1' 
				AND NOW() >= prp_start 
				AND NOW() <= prp_end
				AND prp_id != 69
			ORDER BY prp_discount DESC;
			";
			$prp_result = mysqli_query($proj_connect, $sql_promotion) or die(mysqli_connect_error());
			$prp_row_result = mysqli_fetch_assoc($prp_result);
			$prp_totalrows_result = mysqli_num_rows($prp_result);

			if ($shp_row_result > 0 && $pay_row_result > 0) {
			?>
				<div class="row">
					<div class="col-lg-7 col-md-6 col-12">
						<div class="buttons-cart mb-30">
							<ul>
								<!-- <button type="submit">อัปเดตตะกร้า</button> -->
								<li><a href="#" id="updateCartLink">อัปเดตตะกร้า</a></li>
								<!-- <li><a href="index.php">ซื้อต่อ</a></li> -->
							</ul>
						</div>
						</form>
						<?php
						// ตรวจสอบว่ามีรายการหรือไม่
						if (isset($_SESSION['intLine'])) {
							// มีรายการ
						?>
							<div class="coupon">
								<p>ใช้เหรียญเป็นส่วนลด มีอยู่ <?php echo $mmb_row_result['mmb_coin']; ?> เหรียญ</p>
								<form id="discountForm">
									<?php
									// จำนวนเหรียญสูงสุด
									$maxCoin = 0;
									// คำนวณจำนวนเหรียญสูงสุด
									if ($mmb_row_result['mmb_coin'] <= $cumprice) {
										$maxCoin = $mmb_row_result['mmb_coin'];
									} else {
										$maxCoin = $cumprice; // ใช้ราคารวมหลังหักโปรโมชันเป็น maxCoin
									}
									?>
									<!-- ให้ระบุจำนวนเหรียญ -->
									<input type="number" id="coinInput" placeholder="ใช้เหรียญ" min="1" max="<?php echo $maxCoin ?>" oninput="checkInput(this)">
									<!-- ปุ่มใช้เหรียญ -->
									<a href="#" onclick="applyDiscount()">ใช้เหรียญ</a>
								</form>
							</div>


						<?php
						}
						?>

					</div>
					<div class="col-lg-5 col-md-6 col-12">
						<div class="cart_totals">
							<h3>สรุปรายการซื้อ</h3>
							<?php
							// ตรวจสอบว่ามีรายการหรือไม่
							if (isset($_SESSION['intLine']) && isset($_SESSION['mmb_id']) && ($total != 0)) {

							?>
								<div class="row">
									<table>
										<form id="cart_form" action="checkout_address.php" method="POST">

											<tbody>
												<tr class="cart-subtotal">
													<th style="font-size: 18px;">ราคารวม</th>
													<td>
														<span class="amount" style="font-size: 20px; color: gray;"><?php echo number_format($cumprice, 2); ?></span>
													</td>
												</tr>
												<?php
												if ($prp_row_result > 0) {
												?>
													<tr class="shipping">
														<th style="font-size: 18px;">โปรโมชัน</th>
														<td>
															<ul id="shipping_method">
																<?php do { ?>
																	<li>
																		<input type="radio" name="promotion" id="promotion" value="<?php echo $prp_row_result['prp_id'] ?>">
																		<label for="shipping" style="font-size: 20px;">
																			<?php echo $prp_row_result['prp_name'] ?>
																			<span class="amount" style="font-size: 20px; color: gray;">ลด <?php echo number_format($prp_row_result['prp_discount'], 2) ?> %</span>
																		</label>
																	</li>
																<?php } while ($prp_row_result = mysqli_fetch_assoc($prp_result)); ?>
																<li>
																		<input type="radio" name="promotion" id="promotion" value="69>">
																		<label for="shipping" style="font-size: 20px;">
																			ไม่เลือกโปรโมชัน
																			<span class="amount" hidden style="font-size: 20px; color: gray;">ลด 0.00 %</span>
																		</label>
																	</li>
															</ul>
														</td>
													</tr>
												<?php
												}
												?>
												<tr class="cart-subtotal">
													<th style="font-size: 18px;">ส่วนลด(เหรียญ)</th>
													<td style="color: #ec5048;">
														- <span id="discountAmount" class="amount" style="font-size: 20px;"></span>
														<input type="number" name="discountOutput" id="discountOutput" hidden value="0">
													</td>
												</tr>

												<tr class="shipping">
													<th style="font-size: 18px;">ช่องทางการส่ง</th>
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
													<td>
														<ul>
															<?php do { ?>
																<li>
																	<input type="radio" name="payment" value="<?php echo $pay_row_result['pay_id']; ?>" required>
																	<img style="height: 40px;" src="pay_logo/<?= $pay_row_result['pay_logo']; ?>" alt="payment">
																	<label style="font-size: 20px;">
																		<?php echo $pay_row_result['pay_name']; ?>
																	</label>
																</li>
															<?php } while ($pay_row_result = mysqli_fetch_assoc($pay_result)); ?>
														</ul>
													</td>
												</tr>
												<tr class="cart-subtotal">
													<th style="font-size: 18px;">เหรียญที่ได้รับ</th>
													<td>
														<span class="amount" style="font-size: 20px; color: #f8902c;"><?php echo $_SESSION['sum_coin']; ?></span>
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
									<a href="#" onclick="submit_cart_form()">ดำเนินการต่อ</a>
								</div>
								</form>
						<?php
							} else {
								echo '<p>ยังไม่มีสินค้าในตะกร้า</p>';
							}
						} else {
							// ไม่มีรายการ
							echo '<p>ไม่พบช่องทางจัดส่งหรือช่องการการชำระ</p>';
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
			var updateCartLink = document.querySelector('#updateCartLink');

			updateCartLink.addEventListener('click', function() {
				var form = document.getElementById('addToCartForm');
				form.submit();
			});
		});
	</script>

	<!-- เมื่อผู้ใช้เลือกโปรโมชัน -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var promotionRadios = document.querySelectorAll('input[name="promotion"]');
			var orderTotalAmount = document.getElementById('finalPrice');
			var discountAmount = document.getElementById('discountAmount');
			var cumprice = <?php echo $cumprice; ?>;

			// เพิ่มอีเวนต์ change ให้กับทุก radio button ในกลุ่ม "promotion"
			promotionRadios.forEach(function(radio) {
				radio.addEventListener('change', function() {
					// ทำการคำนวณราคาสุทธิทันทีที่ผู้ใช้เลือกโปรโมชัน
					calculateTotalPrice();
				});
			});

			// ฟังก์ชันคำนวณราคาสุทธิ
			// ฟังก์ชันคำนวณราคาสุทธิ
			function calculateTotalPrice() {
				var selectedPromotion = document.querySelector('input[name="promotion"]:checked');
				var discountPercentage = 0;
				var finalPrice = cumprice;

				if (selectedPromotion) {
					// หากมีโปรโมชันที่ถูกเลือก
					discountPercentage = parseFloat(selectedPromotion.nextElementSibling.querySelector('.amount').textContent.replace('ลด ', '').replace(' %', ''));
					var discountValue = (finalPrice / 100) * discountPercentage;
					finalPrice -= discountValue; // ลดราคาสุทธิตามเปอร์เซ็นต์โปรโมชัน

					// แสดงส่วนลดที่ได้
					//discountAmount.textContent = discountValue.toFixed(2);
					//document.getElementById('discountOutput').value = discountValue.toFixed(2);
				} else {
					// หากไม่มีโปรโมชันที่ถูกเลือก
					discountAmount.textContent = '0.00';
					document.getElementById('discountOutput').value = '0';
				}

				// คำนวณค่าขนส่ง
				var shippingPrice = 0;
				var selectedShipping = document.querySelector('input[name="shipping"]:checked');
				if (selectedShipping) {
					shippingPrice = parseFloat(selectedShipping.nextElementSibling.querySelector('.amount').textContent);
				}

				// เพิ่มค่าขนส่งในราคาสุทธิ
				finalPrice += shippingPrice;

				// แสดงราคาสุทธิใหม่
				orderTotalAmount.textContent = finalPrice.toFixed(2);

				var discountedPrice = <?php echo $cumprice; ?> - (<?php echo $cumprice; ?> * (discountPercentage / 100));
				var maxCoin = Math.min(<?php echo $mmb_row_result['mmb_coin']; ?>, discountedPrice);
				document.getElementById('coinInput').max = maxCoin;
				document.getElementById('coinInput').value = '';
				document.getElementById('discountAmount').textContent = '';
			}
		});
	</script>

	<!-- เลือกช่องทางขนส่ง -->
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var shippingRadios = document.querySelectorAll('input[name="shipping"]');
			var promotionRadios = document.querySelectorAll('input[name="promotion"]');
			var orderTotalAmount = document.querySelector('.order-total .amount');
			var cumprice = <?php echo $cumprice; ?>;

			// เพิ่มอีเวนต์ change ให้กับทุก radio button ในกลุ่ม "shipping"
			shippingRadios.forEach(function(radio) {
				radio.addEventListener('change', function() {
					// ทำการคำนวณราคาสุทธิทันทีที่ผู้ใช้เลือกช่องทางการขนส่ง
					calculateTotalPrice();
				});
			});

			// เพิ่มอีเวนต์ change ให้กับทุก radio button ในกลุ่ม "promotion"
			promotionRadios.forEach(function(radio) {
				radio.addEventListener('change', function() {
					// ทำการคำนวณราคาสุทธิทันทีที่ผู้ใช้เลือกโปรโมชัน
					calculateTotalPrice();
				});
			});

			// ฟังก์ชันคำนวณราคาสุทธิ
			function calculateTotalPrice() {
				var productPrice = parseFloat(cumprice);
				var shippingPrice = 0;

				// หากมี radio button ที่ถูกเลือกในกลุ่ม "shipping"
				var selectedShipping = document.querySelector('input[name="shipping"]:checked');
				if (selectedShipping) {
					shippingPrice = parseFloat(selectedShipping.nextElementSibling.querySelector('.amount').textContent);
				}

				// หากมี radio button ที่ถูกเลือกในกลุ่ม "promotion"
				var selectedPromotion = document.querySelector('input[name="promotion"]:checked');
				var discountPercentage = 0;
				if (selectedPromotion) {
					discountPercentage = parseFloat(selectedPromotion.nextElementSibling.querySelector('.amount').textContent.replace('ลด ', '').replace(' %', ''));
				}
				var coinInput = document.getElementById('coinInput').value;
				var discountAmount = coinInput * 1;
				// คำนวณราคาสุทธิโดยลดราคาจากโปรโมชัน
				var discountPrice = (productPrice / 100) * discountPercentage;
				var totalPrice = productPrice - discountPrice + shippingPrice;
				var finalPrice = totalPrice - discountAmount;
				// แสดงผลใน HTML
				orderTotalAmount.textContent = finalPrice.toFixed(2);
			}
		});
	</script>

	<!-- ใช้เหรียญ -->
	<script>
		function applyDiscount() {
			var coinInput = document.getElementById('coinInput').value;
			var maxCoins = <?php echo $mmb_row_result['mmb_coin']; ?>;
			var cumprice = <?php echo $cumprice; ?>; // ราคารวมทั้งหมด

			if (cumprice <= 0) {
				alert('กรุณานำสินค้าใส่ตะกร้า');
			} else {
				// ตรวจสอบว่าจำนวนเหรียญที่รับมาถูกต้องหรือไม่
				if (coinInput >= 0 && coinInput <= maxCoins) {
					// คำนวนส่วนลดตามจำนวนเหรียญ
					var discountAmount = coinInput * 1;

					// คำนวณราคารวมหลังหักส่วนลด
					var finalPrice = cumprice - discountAmount;

					// ตรวจสอบว่ามีการเลือกโปรโมชันหรือไม่
					var selectedPromotion = document.querySelector('input[name="promotion"]:checked');
					if (selectedPromotion) {
						var discountPercentage = parseFloat(selectedPromotion.nextElementSibling.querySelector('.amount').textContent.replace('ลด ', '').replace(' %', ''));

						// คำนวนส่วนลดตามจำนวนเหรียญ
						var discountAmount = coinInput * 1;

						// คำนวณราคารวมหลังหักส่วนลด
						var finalPrice = cumprice - (cumprice / 100 * discountPercentage) - discountAmount;

						var discountedPrice = (finalPrice * (1 - (discountPercentage / 100))) - coinInput;

						// แสดงค่า discountedPrice ด้วย alert
						//alert('ค่า discountedPrice = ' + discountedPrice.toFixed(2));

						finalPrice = finalPrice;
					}

					// ตรวจสอบว่ามีการเลือกค่าขนส่งหรือไม่
					var selectedShipping = document.querySelector('input[name="shipping"]:checked');
					if (selectedShipping) {
						var shippingPrice = parseFloat(selectedShipping.nextElementSibling.querySelector('.amount').textContent);
						finalPrice += shippingPrice;
					}

					// แสดงผลลัพธ์ราคารวมที่หลังหักส่วนลดและบวกค่าขนส่ง
					document.getElementById('finalPrice').textContent = finalPrice.toFixed(2);
					document.getElementById('discountAmount').textContent = discountAmount;

					// ใส่ค่า discountAmount ลงใน input ที่ซ่อนอยู่
					document.getElementById('discountOutput').value = discountAmount;

					// แจ้งเตือนการใช้เหรียญสำเร็จ
					alert('การใช้เหรียญสำเร็จ!');
				} else {
					// กรณีป้อนข้อมูลไม่ถูกต้อง
					alert('กรุณาใส่จำนวนเหรียญที่ถูกต้อง');
				}
			}
		}
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
				// เพิ่มค่า finalPrice และ prp_id ไปยังฟอร์ม
				var finalPrice = document.getElementById('finalPrice').textContent;
				var selectedPromotion = document.querySelector('input[name="promotion"]:checked');
				var prp_id = null;
				if (selectedPromotion) {
					prp_id = selectedPromotion.value;
				}
				// เพิ่ม hidden input เพื่อส่งข้อมูล finalPrice และ prp_id
				var form = document.getElementById('cart_form');
				var finalPriceInput = document.createElement('input');
				finalPriceInput.setAttribute('type', 'hidden');
				finalPriceInput.setAttribute('name', 'finalPrice');
				finalPriceInput.setAttribute('value', finalPrice);
				form.appendChild(finalPriceInput);
				if (prp_id) {
					var prpIdInput = document.createElement('input');
					prpIdInput.setAttribute('type', 'hidden');
					prpIdInput.setAttribute('name', 'prp_id');
					prpIdInput.setAttribute('value', prp_id);
					form.appendChild(prpIdInput);
				}

				// submit ฟอร์ม
				//alert('Final Price: ' + finalPrice + '\nPRP ID: ' + prp_id);
				form.submit();
			} else {
				// ถ้าไม่มีการเลือก shipping หรือ payment ให้แสดง alert
				alert('กรุณาเลือกช่องทางการส่งและวิธีการชำระเงิน');
			}
		}
	</script>


</body>


</html>