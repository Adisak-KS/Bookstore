<?php
require_once('connection.php');


// เช็คว่ามีค่า prd_id ที่ส่งมาผ่าน URL
if (isset($_GET['prd_id'])) {
	$prd_id = base64_decode($_GET['prd_id']); // ถอดรหัส prd_id
	$_SESSION['detail_prd_id'] = $prd_id;
} elseif (isset($_SESSION['detail_prd_id'])) {
	$prd_id = $_SESSION['detail_prd_id'];
} else {
	$_SESSION['status'] = "ไม่พบข้อมูล";
	$_SESSION['status_code'] = "error";
	header('Location: index.php');
}
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
$sql_script = "SELECT p.*
	FROM bk_prd_product p
	INNER JOIN bk_prd_type t ON p.pty_id = t.pty_id
	WHERE p.prd_id = $prd_id
	  AND p.prd_show = 1
	  AND p.prd_qty > 0
	  AND t.pty_show = 1";
$prd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$prd_row_result = mysqli_fetch_assoc($prd_result);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if (mysqli_num_rows($prd_result) == 0) {
	echo "ขออภัย ไม่พบข้อมูลสินค้าที่คุณค้นหา";
	exit(); // หยุดการทำงานเมื่อไม่พบข้อมูล
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

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
							<li><a href="#" class="active"><?php echo $prd_row_result['prd_name']; ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumbs-area-end -->
	<!-- product-main-area-start -->
	<div class="product-main-area mb-70">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-12 col-12 order-lg-1 order-1">
					<!-- product-main-area-start -->
					<div class="product-main-area">
						<div class="row">
							<div class="col-lg-5 col-md-6 col-12">
								<div class="flexslider">
									<ul class="slides">

										<img src="prd_img/<?php echo $prd_row_result['prd_img']; ?>" alt="woman" />

									</ul>
								</div>
							</div>
							<div class="col-lg-7 col-md-6 col-12">
								<div class="product-info-main">
									<div class="page-title">
										<h1><?php echo $prd_row_result['prd_name']; ?></h1>
									</div>
									<div class="product-info-stock-sku">
										<div class='product-attribute'>
											<!-- preorder -->
											<?php
											// ตรวจสอบว่ามีข้อมูลหรือไม่
											if ($prd_row_result['prd_preorder'] == 1) {
											?>
												<a href='shop.php?prd_filter=<?= urlencode("SELECT * FROM bk_prd_product WHERE prd_show = 1 AND prd_qty > 0 AND prd_preorder = 1 ORDER BY prd_id") ?>'><span>พรีออเดอร์</span></a>

											<?php
											}
											?>
										</div>

									</div>
									<?php
									$cmm_query = "SELECT bk_prd_comment.*, bk_auth_member.mmb_username
FROM bk_prd_comment
INNER JOIN bk_auth_member ON bk_prd_comment.mmb_id = bk_auth_member.mmb_id
WHERE bk_prd_comment.prd_id = '$prd_id' AND bk_prd_comment.cmm_show = '1'";

									$cmm_result = mysqli_query($proj_connect, $cmm_query);

									// กำหนดค่าเริ่มต้น
									$total_ratings = 0;
									$total_reviews = 0;

									while ($cmm_row = mysqli_fetch_assoc($cmm_result)) {
										// นับ rating ทั้งหมด
										$total_ratings += $cmm_row['cmm_rating'];

										// นับจำนวนรีวิว
										$total_reviews++;
									}

									// คำนวณ rating เฉลี่ย
									$average_rating = ($total_reviews > 0) ? round($total_ratings / $total_reviews, 1) : 0;

									?>
									<div class="product-reviews-summary">
										<div class="rating-summary">
											<?php
											// แสดง rating เฉลี่ย
											if ($total_reviews > 0) {
												for ($i = 1; $i <= 5; $i++) {
													if ($i <= $average_rating) {
														echo '<a><i class="fa fa-star text-warning"></i></a>';
													} else {
														echo '<a><i class="fa fa-star"></i></a>';
													}
												}
											} else {
												// ถ้าไม่มีรีวิว, แสดงทั้งหมดเป็น star text-warning
												for ($i = 1; $i <= 5; $i++) {
													echo '<a><i class="fa fa-star text-warning"></i></a>';
												}
											}
											?>
										</div>
										<div class="reviews-actions">
											<a><?= $total_reviews ?> รีวิว</a>
											<!-- <a href="#" class="view">Add Your Review</a> -->
										</div>
									</div>


									<!-- ราคาและส่วนลด -->
									<div class="product-info-price">
										<?php
										if ($prd_row_result['prd_discount'] > 0) {
										?>
											<div class="price-final">
												<span>฿<?php echo $prd_row_result['prd_price'] - ($prd_row_result['prd_discount'] / 100 * $prd_row_result['prd_price']); ?></span>
												<span class="old-price">฿<?php echo $prd_row_result['prd_price']; ?></span>
											</div>
										<?php
										} else {
										?>
											<div class="price-final">
												<span>฿<?php echo $prd_row_result['prd_price']; ?></span>
											</div>
										<?php
										}
										?>
									</div>
									<div class="product-add-form">
										<?php
										if ($prd_row_result['prd_qty'] > 0) {
										?>
											<form action="cart_session.php?id=<?php echo $prd_id; ?>" method="post" id="addToCartForm">
												<div class="quality-button">
													<input name="qty" class="qty" type="number" value="1" min="1" max="<?php echo $prd_row_result['prd_qty']; ?>" oninput="validateQty(this)">
													<input name="id" class="id" type="number" value="<?php echo $prd_id; ?>" hidden>
												</div>
												<input name="prd" type="text" hidden value="<?php echo $prd_id; ?>">
												<a href="#" onclick="addToCart()">ใส่ตะกร้า</a>
											</form>
										<?php
										} else {
										?>
											<h3>ขออภัยสินค้าหมด </h3>
										<?php
										}
										?>

									</div>


									<div class="product-social-links">
										<div class="product-addto-links">
											<?php
											if (isset($_SESSION['mmb_id'])) {
												// ตรวจสอบว่าสินค้านี้มีใน Wishlist ของ mmb_id หรือไม่
												$check_wishlist_query = "SELECT * FROM bk_mmb_wishlist WHERE mmb_id = " . $_SESSION['mmb_id'] . " AND prd_id = " . $prd_row_result['prd_id'];
												$check_wishlist_result = mysqli_query($proj_connect, $check_wishlist_query);

												// ตั้งค่าสีตามผลตรวจสอบ
												$heart_color = mysqli_num_rows($check_wishlist_result) > 0 ? 'red' : '';
											?>
												<a href="wishlist_add.php?prd_id=<?= $prd_row_result['prd_id'] ?>&mmb_id=<?= $_SESSION['mmb_id'] ?>"><i class="fa fa-heart" style="color: <?= $heart_color ?>;"></i></a>
											<?php
											} else {
											?>
												<a href="login.php"><i class="fa fa-heart"></i></a>
											<?php
											}
											?>
											<a href="javascript:void(0);" onclick="copyCurrentURL()"><i class="fa fa-share-square"></i></a>
										</div>
										<div class="product-addto-links-text">
											<p style="color: orange;">คุณได้รับ <?php echo $prd_row_result['prd_coin']; ?> เหรียญ</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- product-main-area-end -->
					<!-- product-info-area-start -->
					<div class="product-info-area mt-80">
						<!-- Nav tabs -->
						<ul class="nav">
							<li><a class="active" href="#Details" data-bs-toggle="tab">รายละเอียด</a></li>
							<li><a href="#Reviews" data-bs-toggle="tab">การรีวิว</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="Details">
								<div class="valu">
									<p><?php echo $prd_row_result['prd_detail']; ?></p>
									<!-- <ul>
										<li><i class="fa fa-circle"></i>Dual top handles.</li>
									</ul> -->
								</div>
							</div>
							<div class="tab-pane fade" id="Reviews">
								<div class="valu valu-2">
									<div class="section-title mb-60 mt-60">
										<h2>รีวิวทั้งหมด</h2>
									</div>
									<ul>
										<?php
										$cmm_result = mysqli_query($proj_connect, $cmm_query);

										// ถ้ามีข้อมูลรีวิว
										if (mysqli_num_rows($cmm_result) > 0) {
											while ($cmm_row = mysqli_fetch_assoc($cmm_result)) {
												// แสดงตัวอย่างรีวิว
										?>
												<li>

													<div class="review-left">
														<div class="review-rating">
															<div class="rating-result">
																<?php
																// แสดงดาวตามคะแนนที่ได้รับ
																for ($i = 1; $i <= 5; $i++) {
																	if ($i <= $cmm_row['cmm_rating']) {
																		// ถ้าคะแนนน้อยกว่าหรือเท่ากับ cmm_rating แสดงดาว active
																?>
																		<a><i class="fa fa-star text-warning"></i></a>
																	<?php
																	} else {
																		// ถ้าคะแนนมากกว่า cmm_rating แสดงดาวไม่ active
																	?>
																		<a><i class="fa fa-star"></i></a>
																<?php
																	}
																}
																?>
															</div>
														</div>
													</div>
													<div class="review-right">
														<div class="review-content">
															<h4><?= $cmm_row['cmm_detail'] ?> </h4>
														</div>
														<div class="review-details">
															<p class="review-author">รีวิวโดย<a><?= $cmm_row['mmb_username'] ?></a></p>
															<p class="review-date">
																<span><?= date('d/m/Y', strtotime($cmm_row['cmm_date'])) ?></span>
															</p>

														</div>
													</div>

												</li>
										<?php
											}
										} else {
											// ถ้าไม่มีข้อมูลรีวิว
											echo "ไม่พบรีวิว";
										}
										?>
									</ul>

									<?php
									if (isset($_SESSION['mmb_id'])) {
									?>
										<div class="review-add">
											<h3>เพิ่มรีวิวของคุณ</h3>
										</div>
										<div class="review-field-ratings">
											<span>ให้คะแนน <sup>*</sup></span>
											<div class="control">
												<div class="single-control">
													<span></span>
													<div class="review-control-vote">
														<h4 class="text-center mt-2 mb-4">
															<i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
															<i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
															<i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
															<i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
															<i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
														</h4>
													</div>
												</div>
											</div>
										</div>
										<div class="review-form">
											<div class="single-form">
												<label>เขียนรีวิว </label>
												<form id="reviewForm" action="#" method="POST">
													<input type="hidden" name="mmb_id" id="mmb_id" value="<?= $_SESSION['mmb_id'] ?>">
													<input type="hidden" name="prd_id" id="prd_id" value="<?= $prd_row_result['prd_id'] ?>">
													<?php
													if (isset($cmm_row['cmm_detail'])) {
													?>
														<textarea name="reviewMessage" id="reviewMessage" cols="10" rows="4" maxlength="100"><?= $cmm_row['cmm_detail'] ?></textarea>
													<?php
													} else {
													?>
														<textarea name="reviewMessage" id="reviewMessage" cols="10" rows="4" maxlength="100" placeholder="ความคิดเห็นของคุณต่อสินค้า"></textarea>
													<?php
													}
													?>
													<input type="hidden" value="0">
												</form>
											</div>
										</div>
										<div class="buttons-cart mb-30">
											<ul>
												<li>
													<a href="#" name="save_review" id="save_review">ยืนยันรีวิว</a>
												</li>
											</ul>

										</div>

										<script>
											$(document).ready(function() {
												var rating_data = 0;
												$(document).on('mouseenter', '.submit_star', function() {
													var rating = $(this).data('rating');
													reset_background();
													for (var count = 1; count <= rating; count++) {
														$('#submit_star_' + count).addClass('text-warning');
													}
												});

												function reset_background() {
													for (var count = 1; count <= 5; count++) {
														$('#submit_star_' + count).addClass('star-light');
														$('#submit_star_' + count).removeClass('text-warning');
													}
												}
												$(document).on('mouseleave', '.submit_star', function() {
													reset_background();
													for (var count = 1; count <= rating_data; count++) {

														$('#submit_star_' + count).removeClass('star-light');

														$('#submit_star_' + count).addClass('text-warning');
													}
												});
												$(document).on('click', '.submit_star', function() {
													rating_data = $(this).data('rating');
												});
												$('#save_review').click(function() {
													var reviewMessage = $('#reviewMessage').val();
													var mmb_id = $('#mmb_id').val();
													var prd_id = $('#prd_id').val();

													if (rating_data == 0) {
														alert("กรุณาให้คะแนนก่อนบันทึกรีวิว");
														return false;
													}
													// ส่งค่าไปยัง review_add.php
													$.ajax({
														type: 'POST',
														url: 'review_add.php',
														data: {
															rating_data: rating_data,
															reviewMessage: reviewMessage,
															mmb_id: mmb_id,
															prd_id: prd_id,
															save_review: 1
														},
														success: function(response) {
															// เปลี่ยนเส้นทางหน้าเว็บไปที่ review_add.php?rating_data=...&reviewMessage=...&mmb_id=...&prd_id=...
															window.location.href = 'review_add.php?rating_data=' + rating_data + '&reviewMessage=' + encodeURIComponent(reviewMessage) + '&mmb_id=' + mmb_id + '&prd_id=' + prd_id;
														},
														error: function(error) {
															// แสดงข้อผิดพลาดกรณีเกิดข้อผิดพลาดในการส่งข้อมูล
															console.error('Error:', error);
														}
													});
												});

											});
										</script>
									<?php
									} else {
									?>
										<div class="review-add">
											<h3>เข้าสู่ระบบเพื่อเพิ่มรีวิวของคุณ</h3>
										</div>
									<?php
									}
									?>

								</div>
							</div>
						</div>
					</div>
					<!-- product-info-area-end -->
					<!-- new-book-area-start -->
					<div class="new-book-area mt-60">
						<div class="section-title text-center mb-30">
							<h3>สินค้าขายดี</h3>
						</div>
						<div class="row">
							<?php
							$product_query = "SELECT p.*
							FROM bk_prd_product p
							INNER JOIN bk_prd_type t ON p.pty_id = t.pty_id
							WHERE p.prd_show = 1 
							AND t.pty_show = 1
							AND p.prd_qty > 0
							ORDER BY p.prd_qty ASC
							LIMIT 4;
							";
							$product_result = mysqli_query($proj_connect, $product_query) or die(mysqli_connect_error());
							if (mysqli_num_rows($product_result) > 0) {
								while ($product_row = mysqli_fetch_assoc($product_result)) {
							?>
									<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
										<!-- single-product-start -->
										<div class="product-wrapper mb-40">
											<div class="product-img">
												<a href="product-details.php?prd_id=<?php echo base64_encode($product_row['prd_id']); ?>">
													<!-- height: 185px -->
													<img src="prd_img/<?php echo $product_row['prd_img']; ?>" alt="book" class="primary" style="height: 100%;" />
												</a>
												<!-- ตรวจสอบโปรโมชั่น -->
												<div class="product-flag">
													<ul>
														<?php if ($product_row['prd_discount'] > 0) { ?>
															<li><span class="discount-percentage"><?php echo '-' . round($product_row['prd_discount'], 0) . '%'; ?></span></li>
														<?php } ?>
													</ul>
												</div>
											</div>
											<?php
											$cmm_query = "SELECT * FROM bk_prd_comment WHERE cmm_show = 1 AND prd_id =" . $product_row['prd_id'];
											$cmm_result = mysqli_query($proj_connect, $cmm_query) or die(mysqli_connect_error());

											$total_ratings = 0;
											$total_reviews = 0;

											while ($cmm_row = mysqli_fetch_assoc($cmm_result)) {
												// นับ rating ทั้งหมด
												$total_ratings += $cmm_row['cmm_rating'];

												// นับจำนวนรีวิว
												$total_reviews++;
											}

											// คำนวณ rating เฉลี่ย
											$average_rating = ($total_reviews > 0) ? round($total_ratings / $total_reviews, 1) : 0;
											?>
											<div class="product-details text-center">
												<div class="product-rating">
													<ul>
														<?php
														// ถ้าไม่มี rating ให้แสดง <li><a><i class="fa fa-star text-warning"></i></a></li> ทั้งหมด
														if ($total_reviews === 0) {
															for ($i = 1; $i <= 5; $i++) {
																echo '<li><a><i class="fa fa-star text-warning"></i></a></li>';
															}
														} else {
															// แสดง cmm_rating เฉลี่ย
															for ($i = 1; $i <= 5; $i++) {
																if ($i <= $average_rating) {
																	echo '<li><a><i class="fa fa-star text-warning"></i></a></li>';
																} else {
																	echo '<li><a><i class="fa fa-star"></i></a></li>';
																}
															}
														}
														?>
													</ul>
												</div>
												<h4><a><?php echo $product_row['prd_name']; ?></a></h4>
												<div class="product-price">
													<ul>
														<?php if ($product_row['prd_discount'] > 0) { ?>
															<li>฿<?php echo number_format(($product_row['prd_price'] - ($product_row['prd_discount'] / 100 * $product_row['prd_price'])), 2); ?></li>
															<li class="old-price">฿<?php echo $product_row['prd_price']; ?></li>
														<?php } else { ?>
															<li>฿<?php echo number_format($product_row['prd_price'], 2); ?></li>
														<?php } ?>
													</ul>
												</div>
											</div>
											<div class="product-link">
												<div class="product-button">
													<a href="product-details.php?prd_id=<?php echo base64_encode($product_row['prd_id']); ?>" title="Add to cart"><i class="fa fa-shopping-cart"></i>รายละเอียด</a>
												</div>
												<div class="add-to-link">
													<ul>
														<li><a href="product-details.php?prd_id=<?php echo base64_encode($product_row['prd_id']); ?>" title="Details"><i class="fa fa-external-link"></i></a></li>
													</ul>
												</div>
											</div>
										</div>
										<!-- single-product-end -->
									</div>
							<?php
								}
							} else {
								// ถ้าไม่มีข้อมูลแสดงข้อความนี้
								echo '<p>ไม่พบข้อมูลสินค้าที่ตรงที่ค้นหา</p>';
							}
							?>
						</div>
					</div>
					<!-- new-book-area-start -->
				</div>
				<div class="col-lg-3 col-md-12 col-12 order-lg-2 order-2">
					<div class="shop-left">
						<div class="left-title mb-20">
							<h4>สินค้าที่ใกล้เคียง</h4>
						</div>
						<div class="random-area mb-30">
							<div class="product-active-2 owl-carousel">
								<div class="product-total-2">
									<?php
									$product_query = "SELECT p.*
									FROM bk_prd_product p
									INNER JOIN bk_prd_type t ON p.pty_id = t.pty_id
									WHERE p.prd_show = 1 
									AND t.pty_show = 1
									AND p.prd_qty > 0
									AND p.prd_id != $prd_id
									LIMIT 4;
									";
									$product_result = mysqli_query($proj_connect, $product_query) or die(mysqli_connect_error());
									if (mysqli_num_rows($product_result) > 0) {
										while ($product_row = mysqli_fetch_assoc($product_result)) {
									?>
											<!-- single-product-start -->
											<div class="single-most-product bd mb-18">
												<div class="product-wrapper">
													<div class="most-product-img">
														<a href="product-details.php?prd_id=<?php echo base64_encode($product_row['prd_id']); ?>">
															<!-- height: 65px -->
															<img src="prd_img/<?php echo $product_row['prd_img']; ?>" alt="book" class="primary" style="height: 100%;" />
														</a>
														<!-- ตรวจสอบโปรโมชั่น -->
														<div class="product-flag">
															<ul>
																<?php if ($product_row['prd_discount'] > 0) { ?>
																	<li><span class="discount-percentage"><?php echo '-' . round($product_row['prd_discount'], 0) . '%'; ?></span></li>
																<?php } ?>
															</ul>
														</div>
													</div>
													<?php
													$cmm_query = "SELECT * FROM bk_prd_comment WHERE cmm_show = 1 AND prd_id =" . $product_row['prd_id'];
													$cmm_result = mysqli_query($proj_connect, $cmm_query) or die(mysqli_connect_error());

													$total_ratings = 0;
													$total_reviews = 0;

													while ($cmm_row = mysqli_fetch_assoc($cmm_result)) {
														// นับ rating ทั้งหมด
														$total_ratings += $cmm_row['cmm_rating'];

														// นับจำนวนรีวิว
														$total_reviews++;
													}

													// คำนวณ rating เฉลี่ย
													$average_rating = ($total_reviews > 0) ? round($total_ratings / $total_reviews, 1) : 0;
													?>
													<div class="product-details text-center">
														<div class="product-rating">
															<ul>
																<?php
																// ถ้าไม่มี rating ให้แสดง <li><a><i class="fa fa-star text-warning"></i></a></li> ทั้งหมด
																if ($total_reviews === 0) {
																	for ($i = 1; $i <= 5; $i++) {
																		echo '<li><a><i class="fa fa-star text-warning"></i></a></li>';
																	}
																} else {
																	// แสดง cmm_rating เฉลี่ย
																	for ($i = 1; $i <= 5; $i++) {
																		if ($i <= $average_rating) {
																			echo '<li><a><i class="fa fa-star text-warning"></i></a></li>';
																		} else {
																			echo '<li><a><i class="fa fa-star"></i></a></li>';
																		}
																	}
																}
																?>
															</ul>
														</div>
														<h4><a><?php echo $product_row['prd_name']; ?></a></h4>
														<div class="product-price">
															<ul>
																<?php if ($product_row['prd_discount'] > 0) { ?>
																	<li>฿<?php echo number_format(($product_row['prd_price'] - ($product_row['prd_discount'] / 100 * $product_row['prd_price'])), 2); ?></li>
																	<li class="old-price">฿<?php echo $product_row['prd_price']; ?></li>
																<?php } else { ?>
																	<li>฿<?php echo number_format($product_row['prd_price'], 2); ?></li>
																<?php } ?>
															</ul>
														</div>
													</div>
													<div class="product-link">
														<div class="product-button">
															<a href="product-details.php?prd_id=<?php echo base64_encode($product_row['prd_id']); ?>" title="Add to cart"><i class="fa fa-shopping-cart"></i>รายละเอียด</a>
														</div>
														<div class="add-to-link">
															<ul>
																<li><a href="product-details.php?prd_id=<?php echo base64_encode($product_row['prd_id']); ?>" title="Details"><i class="fa fa-external-link"></i></a></li>
															</ul>
														</div>
													</div>
												</div>
											</div>
											<!-- single-product-end -->
									<?php
										}
									} else {
										// ถ้าไม่มีข้อมูลแสดงข้อความนี้
										echo '<p>ไม่พบข้อมูลสินค้า</p>';
									}
									?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- product-main-area-end -->
	<!-- footer-area-start -->
	<footer>
		<?php
		require_once('footer.php');
		?>
	</footer>
	<!-- footer-area-end -->
	<!-- Modal -->
	<div class="modal fade" id="productModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-xs-12">
							<div class="modal-tab">
								<div class="product-details-large tab-content">
									<div class="tab-pane active" id="image-1">
										<img src="img/product/quickview-l4.jpg" alt="" />
									</div>
									<div class="tab-pane" id="image-2">
										<img src="img/product/quickview-l2.jpg" alt="" />
									</div>
									<div class="tab-pane" id="image-3">
										<img src="img/product/quickview-l3.jpg" alt="" />
									</div>
									<div class="tab-pane" id="image-4">
										<img src="img/product/quickview-l5.jpg" alt="" />
									</div>
								</div>
								<div class="product-details-small quickview-active owl-carousel">
									<a class="active" href="#image-1"><img src="img/product/quickview-s4.jpg" alt="" /></a>
									<a href="#image-2"><img src="img/product/quickview-s2.jpg" alt="" /></a>
									<a href="#image-3"><img src="img/product/quickview-s3.jpg" alt="" /></a>
									<a href="#image-4"><img src="img/product/quickview-s5.jpg" alt="" /></a>
								</div>
							</div>
						</div>
						<div class="col-md-7 col-sm-7 col-xs-12">
							<div class="modal-pro-content">
								<h3>Chaz Kangeroo Hoodie3</h3>
								<div class="price">
									<span>$70.00</span>
								</div>
								<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet.</p>
								<div class="quick-view-select">
									<div class="select-option-part">
										<label>Size*</label>
										<select class="select">
											<option value="">S</option>
											<option value="">M</option>
											<option value="">L</option>
										</select>
									</div>
									<div class="quickview-color-wrap">
										<label>Color*</label>
										<div class="quickview-color">
											<ul>
												<li class="blue">b</li>
												<li class="red">r</li>
												<li class="pink">p</li>
											</ul>
										</div>
									</div>
								</div>
								<form action="#">
									<input type="number" value="1" />
									<button>Add to cart</button>
								</form>
								<span><i class="fa fa-check"></i> In stock</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal end -->





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
    function addToCart() {
        // ตรวจสอบว่ามีค่าใน $_SESSION['mmb_id'] หรือไม่
        <?php if(!isset($_SESSION['mmb_id'])) { ?>
            alert("กรุณาเข้าสู่ระบบก่อนทำการใส่ตะกร้า!");
        <?php } else { ?>
            // ส่งข้อมูลฟอร์มเมื่อมีการเรียกใช้ฟังก์ชั่น addToCart()
            document.getElementById("addToCartForm").submit();
            alert("ใส่ตะกร้าสำเร็จ!");
        <?php } ?>
    }
</script>

	<script>
		function copyCurrentURL() {
			//var currentURL = window.location.href;
			var currentURL = window.location.href + '?prd_id=<?= base64_encode($prd_id) ?>';


			// สร้าง element textarea สำหรับเก็บ URL
			var textarea = document.createElement('textarea');
			textarea.value = currentURL;

			// เพิ่ม element ลงใน body
			document.body.appendChild(textarea);

			// เลือกข้อความใน textarea
			textarea.select();

			// คัดลอกข้อความ
			document.execCommand('copy');

			// ลบ element textarea
			document.body.removeChild(textarea);

			// แจ้งเตือน
			alert('คัดลอก URL ปัจจุบันเรียบร้อยแล้ว');
		}
	</script>

	<!-- จำนวนสินค้า -->
	<script>
		function validateQty(input) {
			var maxQty = <?php echo $prd_row_result['prd_qty']; ?>;
			var enteredQty = parseInt(input.value);

			if (enteredQty < 1 || enteredQty > maxQty) {
				alert('กรุณากรอกจำนวนให้ถูกต้อง (1-' + maxQty + ')');
				input.value = 1; // กำหนดค่าใหม่เป็น 1 หรือค่าต่ำสุดที่ต้องการ
			}
		}
	</script>

</body>

</html>