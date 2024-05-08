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
	echo "<script>window.location.href = 'index.php';</script>";
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
	<!-- slider-area-start -->
	<div class="slider-area mt-30">
		<div class="container">
			<div class="slider-active owl-carousel">
				<a href="#">
					<div class="single-slider slider-hm4-1 pt-154 pb-154 bg-img" style="height: auto; background-image:url(admin_page/Admin/dist/assets/images/<?= $_SESSION['banner_1']; ?>);">
						<div class="row">
							<div class="col-md-12">
								<div class="slider-content-3 slider-animated-1 pl-100">
								</div>
							</div>
						</div>
					</div>
				</a>
				<a href="#">
					<div class="single-slider slider-hm4-1 pt-154 pb-154 bg-img" style="background-image:url(admin_page/Admin/dist/assets/images/<?= $_SESSION['banner_2']; ?>);">
						<div class="row">
							<div class="col-md-12">
								<div class="slider-content-3 slider-animated-1 pl-100">
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	<!-- slider-area-end -->
	<!-- slider-group-start -->
	<div class="slider-group  mt-30">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-12 col-12">
					<!-- slider-area-start -->
					<div class="slider-area">
						<div class="">
							<div class="single-slider slider-hm4-1 pt-154 pb-154 bg-img" style="background-image:url(admin_page/Admin/dist/assets/images/<?= $_SESSION['banner_1']; ?>);">
								<div class="slider-content-4 slider-animated-1 pl-40">
									<?= $_SESSION['banner_1_text'] ?>
									<!-- <a href="#">Shopping now!</a> -->
								</div>
							</div>
						</div>
					</div>
					<!-- slider-area-end -->
				</div>
				<div class="col-lg-3 col-md-12 col-12">
					<!-- banner-static-2-start -->
					<div class="banner-static-2">
						<div class="row">
							<div class="col-lg-12 col-md-6 col-12">
								<div class="banner-img-2">
									<a href="<?= $_SESSION['url_banner_2'] ?>"><img src="admin_page/Admin/dist/assets/images/<?= $_SESSION['banner_2']; ?>" alt="banner" style="height: 409px; width: 570px" /></a>
								</div>
							</div>
							<div class="col-lg-12 col-md-6 col-12">
								<!-- banner-area-3-start -->
								<div class="banner-area-3">
									<div class="row">
										<div class="col-12">
											<!-- single-banner-2-start -->
											<!-- <div class="single-banner-2 mt-16">
												<div class="single-icon-2">
													<a href="#">
														<img class="service-blue-img" src="img/icon-img/service-1.png" alt="banner" />
														<img class="service-white-img" src="img/icon-img/service-1-white.png" alt="banner" />
													</a>
												</div>
												<div class="single-text-2">
													<h2>ฟรีค่าจัดส่ง</h2>
													<p>เมื่อซื้อสินค้าครบ 500฿</p>
												</div>
											</div> -->
											<!-- single-banner-2-end -->
										</div>
									</div>
								</div>
								<!-- banner-area-3-end -->
							</div>
						</div>

					</div>
					<!-- banner-static-2-end -->
				</div>
			</div>
		</div>
	</div>
	<!-- slider-group-end -->
	<!-- home-main-area-start -->
	<div class="home-main-area mt-30">
		<div class="container">
			<div class="row">

				<div class="col-lg-12 col-md-8 col-12">
					<!-- banner-area-5-start -->
					<div class="banner-area-5">
						<div class="single-banner-4 xs-mb">
							<div class="banner-img-2">
								<a href="<?= $_SESSION['url_banner_3'] ?>"><img src="admin_page/Admin/dist/assets/images/<?= $_SESSION['banner_3']; ?>" alt="banner" style="height: 189px; width: 600px" /></a>
							</div>
						</div>
						<div class="single-banner-5">
							<div class="banner-img-2">
								<a href="<?= $_SESSION['url_banner_4'] ?>"><img src="admin_page/Admin/dist/assets/images/<?= $_SESSION['banner_4']; ?>" alt="banner" style="height: 189px; width: 600px" /></a>
							</div>
						</div>
					</div>


					<!-- banner-area-5-end -->
					<!-- new-book-area-start -->
					<?php
					// ดึงข้อมูลสินค้าจากตาราง product และเรียงจากใหม่สุด
					$product_query = "SELECT * FROM bk_prd_product
                WHERE prd_show = 1 AND prd_qty > 0
                ORDER BY prd_id DESC
                LIMIT 8;
                ";
					$product_result = mysqli_query($proj_connect, $product_query) or die(mysqli_connect_error());

					$grouped_products = array();
					$group_count = 0;

					while ($product_row = mysqli_fetch_assoc($product_result)) {
						$grouped_products[$group_count][] = $product_row;
						if (count($grouped_products[$group_count]) >= 2) {
							$group_count++;
						}
					}
					?>

					<div class="new-book-area ptb-50">
						<div class="section-title-2 mb-30">
							<h3>สินค้าใหม่</h3>
						</div>
						<div class="row">
							<?php
							if (isset($_GET['prd_filter'])) {
								$product_query = $_GET['prd_filter'];
							} else {
								$product_query = "SELECT * FROM bk_prd_product WHERE prd_show = 1 AND prd_qty > 0 ORDER BY prd_id";
							}
							$product_result = mysqli_query($proj_connect, $product_query) or die(mysqli_connect_error());
							if (mysqli_num_rows($product_result) > 0) {
								while ($product_row = mysqli_fetch_assoc($product_result)) {
							?>
									<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
										<!-- single-product-start -->
										<!-- <div class="product-wrapper mb-40"> -->
										<div class="product-wrapper mb-40">
											<div class="product-img">
												<a href="product-details.php?prd_id=<?php echo base64_encode($product_row['prd_id']); ?>">
													<img src="prd_img/<?php echo $product_row['prd_img']; ?>" alt="book" class="primary" />
												</a>
												<!-- ตรวจสอบโปรโมชั่น -->
												<?php
												$product_promotion_query = "SELECT bk_promotion.* 
												FROM bk_promotion
												JOIN bk_prd_promotion ON bk_promotion.prp_id = bk_prd_promotion.prp_id
												WHERE bk_prd_promotion.prd_id = " . $product_row['prd_id'];
												$product_promotion_result = mysqli_query($proj_connect, $product_promotion_query) or die(mysqli_connect_error());
												//$product_promotion_row = mysqli_fetch_assoc($product_promotion_result);

												$discount_percentage = 0;
												if ($product_promotion_result) {
													while ($promotion_row = mysqli_fetch_assoc($product_promotion_result)) {
														$discount_percentage += $promotion_row['prp_discount'];
													}

													mysqli_free_result($product_promotion_result);
												}
												?>
												<div class="product-flag">
													<ul>
														<?php if ($discount_percentage > 0) { ?>
															<li><span class="discount-percentage"><?php echo '-' . round($discount_percentage, 0) . '%'; ?></span></li>
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
														<?php if ($discount_percentage > 0) { ?>
															<li>฿<?php echo number_format(($product_row['prd_price'] - ($discount_percentage % $product_row['prd_price'])), 2); ?></li>
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
								echo '<p>ไม่พบรายการ</p>';
							}
							?>

						</div>
					</div>

				</div>
				<!-- new-book-area-start -->

			</div>
		</div>
	</div>
	</div>
	<!-- home-main-area-end -->
	<!-- banner-area-start -->
	<div class="banner-area-5 mtb-70">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="banner-img-2 for-height">
						<a href="<?= $_SESSION['url_banner_5']; ?>"><img src="admin_page/Admin/dist/assets/images/<?= $_SESSION['banner_5']; ?>" style="height: 189px;" /></a>
						<div class="banner-text">
							<?= $_SESSION['banner_5_text']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- banner-area-end -->
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