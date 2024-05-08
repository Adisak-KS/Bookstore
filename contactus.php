<?php
require_once('connection.php');
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

<body class="contact">
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
							<li><a href="#" class="active">ติดต่อผู้ดูแล</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumbs-area-end -->
	<!-- googleMap-area-start -->
	<div class="map-area mb-70">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<?= $_SESSION['contact_map'] ?>
				</div>
			</div>
		</div>
	</div>
	<!-- googleMap-end -->
	<!-- contact-area-start -->
	<div class="contact-area mb-70">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-12">
					<div class="contact-info">
						<h3>ช่องทางการติดต่อ</h3>
						<ul>
							<li>
								<i class="fa fa-map-marker"></i>
								<span>ที่อยู่: </span>
								<?= $_SESSION['contact_address'] ?>
							</li>
							<li>
								<i class="fa fa-envelope"></i>
								<span>อีเมล: </span>
								<a href="mailto:<?= $_SESSION['contact_mail'] ?>"><?= $_SESSION['contact_mail'] ?></a>
							</li>
							<li>
								<i class="fa fa-mobile"></i>
								<span>โทรศัพท์: </span>
								<?= $_SESSION['contact_phone'] ?>
							</li>

						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- contact-area-end -->
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
	<!-- ajax-mail js -->
	<script src="js/ajax-mail.js"></script>
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
	<!-- googleapis -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMlLa3XrAmtemtf97Z2YpXwPLlimRK7Pk"></script>
	<script>
		/* Google Map js */
		function initialize() {
			var mapOptions = {
				zoom: 15,
				scrollwheel: false,
				center: new google.maps.LatLng(40.740610, -73.935242)
			};

			var map = new google.maps.Map(document.getElementById('googleMap'),
				mapOptions);

			var marker = new google.maps.Marker({
				position: map.getCenter(),
				animation: google.maps.Animation.BOUNCE,
				icon: 'img/map.png',
				map: map
			});

		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</body>

</html>