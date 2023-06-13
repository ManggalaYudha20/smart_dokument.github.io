<?php
session_start();
if (!isset($_SESSION["login"])) {
	header("Location:../auth/login");
	exit;
}

require('../funct/functions.php');

// SESSION USER LOGIN
if (isset($_SESSION["login"])) {

	$userSession = $_SESSION["username"];
	$resultSession = $conn->query("SELECT * FROM tb_users WHERE username = '$userSession' ");
	$rowSession = mysqli_fetch_assoc($resultSession);
	$idSession = $rowSession["id"];

	// Count data table
	include("../include/count-data-table.php");
}

// query table user
$queryUsers = query("SELECT * FROM tb_users");

// check empty account
if (empty($rowSession["id"])) {
	header("Location:../auth/logout");
	exit;
}

// SET DATE
date_default_timezone_set('Asia/Makassar');

// tanggal, bulan, tahun
$date = date("d M Y");
$time = date("h:m");

// Check Level
include("../include/check-level.php");

// Konfigurasi SEO
include("../include/seo.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="<?= $metaDescription; ?>">
	<meta name="keywords" content="<?= $metaKeywords; ?>">
	<meta name="author" content="<?= $metaAuthor; ?>">
	<title>Dashbor - smart dokument</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="assets/img/Aldy.png?v=<?= time(); ?>" type="image/x-icon" />

	<!-- Fonts and icons -->
	<script src="assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Lato:300,400,700,900"]
			},
			custom: {
				"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
				urls: ['assets/css/fonts.min.css']
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/atlantis.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">

	<!-- My Style Css -->
	<link rel="stylesheet" href="../assets/css/style.css?v=<?= time(); ?>" class="css">

</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<a href="" class="logo text-white">
					<img src="assets/img/Aldy.png?v=<?= time(); ?>" alt="Arsip Bappeda Litbang Manado" width="60">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<?php include("../include/navbar.php"); ?>
			<!-- End Navbar -->

		</div>

		<!-- Sidebar -->
		<?php include("../include/sidebar.php"); ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">Dashboard - smart dokument</h2>
								<h5 class="text-white op-8 mb-2">
									Anda Masuk Sebagai
									<?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
										Super Admin
									<?php endif; ?>

									<?php if ($rowSession["level"] === $levelKaban) : ?>
										Kepala smart dokument
									<?php endif; ?>

									<?php if ($rowSession["level"] === $levelUser) : ?>
										User
									<?php endif; ?>
								</h5>
							</div>
							<?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
								<div class="ml-md-auto py-2 py-md-0">
									<a href="settings/user" class="btn btn-light text-primary btn-round">
										<i class="fa fa-user"></i> Tambah akun
									</a>
								</div>
							<?php endif; ?>

							<?php if ($rowSession["level"] === $levelKaban) : ?>
							<?php endif; ?>

							<?php if ($rowSession["level"] === $levelUser) : ?>
								<div class="ml-md-auto py-2 py-md-0">
									<?php if (empty($rowFeedbackUser)) : ?>
										<button class="btn btn-light text-primary btn-round" data-toggle="modal" data-target="#feedBack">
											<i class="fa fa-comment"></i> <sup><i class="fa fa-thumbs-up"></i></sup> Berikan Feedback
										</button>
									<?php endif; ?>
									<?php if (!empty($rowFeedbackUser)) : ?>
										<button class="btn btn-light text-primary btn-round" data-toggle="modal" data-target="#feedBack">
											<i class="fa fa-comment"></i> <sup><i class="fa fa-thumbs-up"></i></sup> Feedbackmu
										</button>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body">
									<div class="card-title">Statistik keseluruhan</div>
									<div class="card-category">Informasi harian tentang statistik dalam sistem</div>
									<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-1"></div>
											<h6 class="fw-bold mt-3 mb-0">Jumlah Surat Masuk</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-2"></div>
											<h6 class="fw-bold mt-3 mb-0">Jumlah Surat Keluar</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-3"></div>
											<h6 class="fw-bold mt-3 mb-0">Jumlah Disposisi</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-4"></div>
											<h6 class="fw-bold mt-3 mb-0">Jumlah Klasifikasi Surat</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-5"></div>
											<h6 class="fw-bold mt-3 mb-0">Jumlah Umpan Balik</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-6"></div>
											<h6 class="fw-bold mt-3 mb-0">Jumlah Pengguna</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Bagan Lingkaran</div>
								</div>
								<div class="card-body">
									<div class="chart-container">
										<canvas id="doughnutChart" style="width: 50%; height: 50%"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Grafik Umpan Balik</div>
								</div>
								<div class="card-body">
									<div class="chart-container">
										<canvas id="barChart"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<div class="card-title fw-mediumbold">Semua Akun</div>
										<div class="card-list card-all-account">
											<?php foreach ($queryUsers as $row) : ?>
												<div class="item-list">
													<div class="avatar">
														<img src="../assets/img/photo-profile/<?= $row["gambar"]; ?>" alt="..." class="avatar-img rounded-circle">
													</div>
													<div class="info-user ml-3">
														<div class="username">
															<?= $row["first_name"]; ?> <?= $row["last_name"]; ?>
														</div>
														<div class="status">
															<?php if ($row["level"] === $levelSuperAdmin) : ?>
																Super Admin
															<?php endif; ?>

															<?php if ($row["level"] === $levelKaban) : ?>
																Kepala Badan
															<?php endif; ?>

															<?php if ($row["level"] === $levelUser) : ?>
																User
															<?php endif; ?>
														</div>
													</div>
													<?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
														<a href="settings/user" class="btn btn-icon  btn-round btn-xs btn-plus-round" title="Lihat">
															<i class="fa fa-eye text-primary"></i>
														</a>
													<?php endif; ?>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<div class="col-md-6 <?php if ($rowSession["level"] === $levelUser || $rowSession["level"] === $levelKaban) : ?>col-md-12<?php endif; ?>">
							<div class="card full-height">
								<div class="card-header">
									<div class="card-title">Aktifitas Umpan Balik / Masukan</div>
								</div>
								<div class="card-body">
									<ol class="activity-feed card-activity-feedback">
										<?php foreach ($queryFeedback as $row) : ?>
											<li class="feed-item">
												<time class="date" datetime="9-17">
													<i class="fa fa-calendar-alt"></i> <?= $row["date"]; ?> |
													<i class="fa fa-clock"></i> <?= $row["time"]; ?>
												</time>
												<span class="text">
													<?= $row["first_name"]; ?> <?= $row["last_name"]; ?>
													<a href="feedback/user?id=<?= $row["id"]; ?>&view=">"<?= $row["response"]; ?>"</a>
												</span>
											</li>
										<?php endforeach; ?>
									</ol>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include("../include/footer.php"); ?>
		</div>


		<!-- Logout Modal-->
		<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Siap untuk keluar?</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">Pilih "Keluar" jika anda yakin ingin mengakhiri sesi anda saat ini.</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
						<a class="btn btn-primary" href="../auth/logout">Keluar</a>
					</div>
				</div>
			</div>
		</div>


		<!-- =================
           FEEDBACK USER
           ================= -->
		<?php include("../include/modal-feedback.php"); ?>


	</div>
	<!--   Core JS Files   -->
	<script src="assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="assets/js/core/popper.min.js"></script>
	<script src="assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Chart JS -->
	<script src="assets/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="assets/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="assets/js/plugin/datatables/datatables.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

	<!-- Sweet Alert -->
	<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="assets/js/atlantis.min.js"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="assets/js/setting-demo.js"></script>
	<script src="assets/js/demo.js"></script>
	<script>
		Circles.create({
			id: 'circles-1',
			radius: 45,
			value: <?php echo "{$resultSuratMasuk["jmlhSuratMasuk"]}"; ?>,
			maxValue: 20,
			width: 7,
			text: <?php echo "{$resultSuratMasuk["jmlhSuratMasuk"]}"; ?>,
			colors: ['#f1f1f1', '#FF9E27'],
			duration: 400,
			wrpClass: 'circles-wrp',
			textClass: 'circles-text',
			styleWrapper: true,
			styleText: true
		})

		Circles.create({
			id: 'circles-2',
			radius: 45,
			value: <?php echo "{$resultSuratKeluar["jmlhSuratKeluar"]}"; ?>,
			maxValue: 20,
			width: 7,
			text: <?php echo "{$resultSuratKeluar["jmlhSuratKeluar"]}"; ?>,
			colors: ['#f1f1f1', '#2BB930'],
			duration: 400,
			wrpClass: 'circles-wrp',
			textClass: 'circles-text',
			styleWrapper: true,
			styleText: true
		})

		Circles.create({
			id: 'circles-3',
			radius: 45,
			value: <?php echo "{$resultSuratDisposisi["jmlhSuratDisposisi"]}"; ?>,
			maxValue: 20,
			width: 7,
			text: <?php echo "{$resultSuratDisposisi["jmlhSuratDisposisi"]}"; ?>,
			colors: ['#f1f1f1', '#F25961'],
			duration: 400,
			wrpClass: 'circles-wrp',
			textClass: 'circles-text',
			styleWrapper: true,
			styleText: true
		})

		Circles.create({
			id: 'circles-4',
			radius: 45,
			value: <?php echo "{$resultKlasifikasiSurat["jmlhKlasifikasiSurat"]}"; ?>,
			maxValue: 20,
			width: 7,
			text: <?php echo "{$resultKlasifikasiSurat["jmlhKlasifikasiSurat"]}"; ?>,
			colors: ['#f1f1f1', '#1269db'],
			duration: 400,
			wrpClass: 'circles-wrp',
			textClass: 'circles-text',
			styleWrapper: true,
			styleText: true
		})

		Circles.create({
			id: 'circles-5',
			radius: 45,
			value: <?php echo "{$resultFeedback["jmlhFeedback"]}"; ?>,
			maxValue: 20,
			width: 7,
			text: <?php echo "{$resultFeedback["jmlhFeedback"]}"; ?>,
			colors: ['#f1f1f1', '#04d7d7'],
			duration: 400,
			wrpClass: 'circles-wrp',
			textClass: 'circles-text',
			styleWrapper: true,
			styleText: true
		})

		Circles.create({
			id: 'circles-6',
			radius: 45,
			value: <?php echo "{$resultAkun["jmlhAkun"]}"; ?>,
			maxValue: 20,
			width: 7,
			text: <?php echo "{$resultAkun["jmlhAkun"]}"; ?>,
			colors: ['#f1f1f1', '#d71380'],
			duration: 400,
			wrpClass: 'circles-wrp',
			textClass: 'circles-text',
			styleWrapper: true,
			styleText: true
		})



		$('#lineChart').sparkline([105, 103, 123, 100, 95, 105, 115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});


		// VAR Bar Chart, doughnut Chart
		var barChart = document.getElementById('barChart').getContext('2d'),
			doughnutChart = document.getElementById('doughnutChart').getContext('2d');

		var myDoughnutChart = new Chart(doughnutChart, {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						<?php echo "{$resultSuratMasuk["jmlhSuratMasuk"]}"; ?>,
						<?php echo "{$resultSuratKeluar["jmlhSuratKeluar"]}"; ?>,
						<?php echo "{$resultSuratDisposisi["jmlhSuratDisposisi"]}"; ?>,
						<?php echo "{$resultKlasifikasiSurat["jmlhKlasifikasiSurat"]}"; ?>,
						<?php echo "{$resultFeedback["jmlhFeedback"]}"; ?>,
						<?php echo "{$resultAkun["jmlhAkun"]}"; ?>
					],
					backgroundColor: ['#FF9E27', '#2BB930', '#F25961', '#1269db', '#04d7d7', '#d71380']
				}],

				labels: [
					'Surat Masuk',
					'Surat Keluar',
					'Disposisi',
					'Klasifikasi',
					'Umpan Balik',
					'Pengguna'
				]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					position: 'bottom'
				},
				layout: {
					padding: {
						left: 20,
						right: 20,
						top: 20,
						bottom: 20
					}
				}
			}
		});

		var myBarChart = new Chart(barChart, {
			type: 'bar',
			data: {
				labels: ["Sangat Baik", "Baik", "Sedang", "Buruk", "Sangat Buruk"],
				datasets: [{
					label: "Data",
					backgroundColor: 'rgb(23, 125, 255)',
					borderColor: 'rgb(23, 125, 255)',
					data: [
						<?php echo "{$resultFeedbackSangatBaik["jmlhFeedbackSangatBaik"]}"; ?>,
						<?php echo "{$resultFeedbackBaik["jmlhFeedbackBaik"]}"; ?>,
						<?php echo "{$resultFeedbackSedang["jmlhFeedbackSedang"]}"; ?>,
						<?php echo "{$resultFeedbackBuruk["jmlhFeedbackBuruk"]}"; ?>,
						<?php echo "{$resultFeedbackSangatBuruk["jmlhFeedbackSangatBuruk"]}"; ?>
					],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				},
			}
		});
	</script>
</body>

</html>