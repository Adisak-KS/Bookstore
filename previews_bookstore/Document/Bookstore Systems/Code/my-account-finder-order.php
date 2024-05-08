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
	$current_url = $_SERVER['REQUEST_URI'];
	echo "<script>alert('$status');</script>";
	echo "<script>window.location.href = '" . $current_url . "';</script>";
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
										<div class="tab-pane fade show active" id="download" role="tabpanel">
											<div class="myaccount-content">
												<h5>ประวัติตามหาหนังสือตามสั่ง</h5>
												<div class="myaccount-table table-responsive text-center">
													<?php

													$fnd_sql = "SELECT * FROM bk_fnd_finder WHERE mmb_id = {$_SESSION['mmb_id']} ORDER BY fnd_date DESC";

													$fnd_result = mysqli_query($proj_connect, $fnd_sql);

													if (mysqli_num_rows($fnd_result) > 0) {
													?>
														<table class="table table-bordered">
															<thead class="thead-light">
																<tr>
																	<th>เวลา</th>
																	<th>หมายเลขติดตาม</th>
																	<th>ยอดซื้อ</th>
																	<th>สถานะ</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<?php
																while ($fnd_row = mysqli_fetch_assoc($fnd_result)) {
																	// ทำการดึงข้อมูลสินค้าจากตารางอื่น ๆ ตามความต้องการ

																?>
																	<tr>
																		<td>
																			<?= $fnd_row['fnd_date'] ?>
																		</td>
																		<td><?php
																			if ($fnd_row['fnd_track'] != '-') {

																			?>
																				<a href="https://ems.thaiware.com/<?= $fnd_row['fnd_track'] ?>" target="_blank"><?= $fnd_row['fnd_track'] ?></a>
																			<?php
																			} else {
																				echo '-';
																			}
																			?>
																		</td>
																		<td><?php
																			if ($fnd_row['fnd_totalprice'] > 0) {
																				echo $fnd_row['fnd_totalprice'];
																			} else {
																				echo '-';
																			}
																			?></td>
																		<td>
																			<?php
																			if ($fnd_row['fnd_status'] == 'เลือกช่องทางส่งและช่องทางชำระ') {
																				echo $fnd_row['fnd_status'];
																			} elseif ($fnd_row['fnd_status'] == 'รอการชำระเงิน' || $fnd_row['fnd_status'] == 'การชำระเงินไม่ถูกต้อง') {
																				echo $fnd_row['fnd_status'];
																			} elseif ($fnd_row['fnd_status'] == 'รอการตรวจสอบ') {
																				echo 'ผู้ดูแลกำลังค้นหาหนังสือตามสั่ง';
																			}elseif ($fnd_row['fnd_status'] == 'รอสมาชิกตรวจสอบ') {
																				echo 'โปรดตรวจสอบผลการตามหาของคุณ';
																			} elseif ($fnd_row['fnd_status'] == 'กำลังค้นหา') {
																				echo 'ผู้ดูแลกำลังค้นหาหนังสือตามสั่ง';
																			}else{
																				echo $fnd_row['fnd_status'];
																			}
																			?>
																		</td>
																		<td><?php
																			if ($fnd_row['fnd_status'] == 'เลือกช่องทางส่งและช่องทางชำระ') {
																			?>
																				<a href="finder_cart.php?fnd_id=<?php echo $fnd_row['fnd_id']; ?>" class="btn btn-sqr"><i class="fa fa-eye"></i> รายละเอียด</a>
																			<?php
																			} elseif ($fnd_row['fnd_status'] == 'รอการชำระเงิน' || $fnd_row['fnd_status'] == 'การชำระเงินไม่ถูกต้อง') {
																			?>
																				<a href="finder_payment.php?fnd_id=<?php echo $fnd_row['fnd_id']; ?>" class="btn btn-sqr"><i class="fa fa-eye"></i> รายละเอียด</a>
																			<?php
																			} else {
																			?>
																				<a href="finder_detail.php?fnd_id=<?php echo $fnd_row['fnd_id']; ?>" class="btn btn-sqr"><i class="fa fa-eye"></i> รายละเอียด</a>
																			<?php
																			}
																			?>
																		</td>
																	</tr>
																<?php
																}
																?>
															</tbody>
														</table>
													<?php
													} else {
														echo "ไม่มีรายการสั่งซื้อ";
													}
													?>
												</div>
											</div>
										</div>
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