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
							<li><a href="#" class="active">การซื้อของฉัน</a></li>
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
						<h2>การซื้อของฉัน</h2>
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
					<div class="wishlist-content">
						<div class="wishlist-table table-responsive">
							<table>
								<thead>
									<tr>
										<th class="product-thumbnail"><a href="#">รอการชำระ</a></th>
										<th class="product-thumbnail">รอการยืนยัน</th>
										<th class="product-name">รอการจัดส่ง</th>
										<th class="product-price">ต้องได้รับ </th>
										<th class="product-stock-stauts">สำเร็จ </th>
										<th class="product-subtotal">สำเร็จ </th>
										<th class="product-subtotal">ยกเลิก </th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="wishlist-content">
					<form action="#">
						<div class="wishlist-table table-responsive">
							<table>
								<thead>
									<tr>
										<td colspan="4">
											<div class="row">
												<div class="col-lg-6 col-md-6 col-12">
													วันที่สั่งซื้อ 30/11/2023
												</div>
												<div class="col-lg-6 col-md-6 col-12">
													<a href="">รายละเอียด</a>
													
												</div>
											</div>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="product-thumbnail"><a href="#"><img src="img/cart/1.jpg" alt="man" /></a></td>
										<td class="product-name"><a href="#">Vestibulum suscipit</a></td>
										<td class="product-name"><a href="#">x 1</a></td>
										<td class="product-price"><span class="amount">165.00</span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</form>
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

</body>


</html>