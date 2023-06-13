<?php
session_start();
if (!isset($_SESSION["login"])) {
	header("Location:../../auth/login");
	exit;
}

require('../../funct/functions.php');

// SESSION USER LOGIN
if (isset($_SESSION["login"])) {

	$userSession = $_SESSION["username"];
	$resultSession = $conn->query("SELECT * FROM tb_users WHERE username = '$userSession' ");
	$rowSession = mysqli_fetch_assoc($resultSession);
	$idSession = $rowSession["id"];
}

// query table surat masuk
$querySuratMasuk = query("SELECT * FROM tb_surat_masuk");

// check empty account
if (empty($rowSession["id"])) {
	header("Location:../../auth/logout");
	exit;
}

// CEK LEVEL
include("../../include/check-level.php");

// SET DATE
date_default_timezone_set('Asia/Makassar');

// tanggal, bulan, tahun
$tbh = date("d M Y");

// Format Tanggal Indonesia
include("../../include/tgl-indo.php");

// Konfigurasi SEO
include("../../include/seo.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="<?= $metaDescription; ?>">
	<meta name="keywords" content="<?= $metaKeywords; ?>">
	<meta name="author" content="<?= $metaAuthor; ?>">
	<title>Data Surat Masuk - smart dokument</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/Aldy.png?v=<?= time(); ?>" type="image/x-icon" />

	<!-- Fonts and icons -->
	<script src="../assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {
				"families": ["Lato:300,400,700,900"]
			},
			custom: {
				"families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
				urls: ['../assets/css/fonts.min.css']
			},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/css/atlantis.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="../assets/css/demo.css">

	<!-- Style Dashboard -->
	<link rel="stylesheet" href="../../assets/css/dashboard.css?v=<?= time(); ?>" class="css">

</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<a href="../" class="logo text-white">
					<img src="../assets/img/Aldy.png?v=<?= time(); ?>" alt="smart dokument" width="70">
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
			<?php include("../../include/navbar.php"); ?>
			<!-- End Navbar -->

		</div>

		<!-- Sidebar -->
		<?php include("../../include/sidebar.php"); ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Data Surat Masuk</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="../">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Transaksi Surat</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Data Surat Masuk</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
									<div class="card-header">
										<div class="d-flex align-items-center">
											<h4 class="card-title">Tambah Data</h4>
											<a href="add-surat-masuk" class="btn btn-primary btn-round ml-auto"><i class="fa fa-plus"></i> Tambah Data</a>
										</div>
									</div>
								<?php endif; ?>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th>No. Agenda</th>
													<th>Kode</th>
													<th>Isi Ringkas</th>
													<th>File</th>
													<th>Asal Surat</th>
													<th>No. Surat</th>
													<th>Tgl Surat</th>
													<th style="width: 10%">Opsi</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>#</th>
													<th>No. Agenda</th>
													<th>Kode</th>
													<th>Isi Ringkas</th>
													<th>File</th>
													<th>Asal Surat</th>
													<th>No. Surat</th>
													<th>Tgl Surat</th>
													<th style="width: 10%">Opsi</th>
												</tr>
											</tfoot>
											<tbody>
												<?php $noTable = 1; ?>
												<?php foreach ($querySuratMasuk as $row) : ?>
													<tr>
														<td><?= $noTable; ?></td>
														<td><?= $row["no_agenda"]; ?></td>
														<td><?= $row["kode_klasifikasi"]; ?></td>
														<td><?= $row["isi"]; ?></td>
														<td>
															<a href="../../uploads/surat-masuk/<?= $row["file"]; ?>" class="bg-info download-file" title="Download File"><i class="fa fa-download"></i></a>
														</td>
														<td><?= $row["asal_surat"]; ?></td>
														<td><?= $row["no_surat"]; ?></td>
														<td><?= tgl_indo(date($row["tgl_surat"])); ?></td>
														<td>
															<div class="form-button-action">
																<div class="dropdown show">
																	<a class="show-opsi bg-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		Opsi
																	</a>

																	<div class="dropdown-menu dropdown-menu-opsi" aria-labelledby="dropdownMenuLink">
																		<?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
																			<a class="dropdown-item text-light bg-primary" href="edit-surat-masuk?id_surat_masuk=<?= $row["id"]; ?>"><i class="fa fa-edit"></i> Edit</a>
																		<?php endif; ?>

																		<?php if ($rowSession["level"] === $levelSuperAdmin || $rowSession["level"] === $levelKaban) : ?>
																			<a class="dropdown-item text-light bg-success" href="disposisi-surat?id_surat_masuk=<?= $row["id"]; ?>"><i class="fa fa-file"></i> Disposisi</a>
																		<?php endif; ?>

																		<?php if ($rowSession["level"] === $levelUser || $rowSession["level"] === $levelKaban || $rowSession["level"] === $levelSuperAdmin) : ?>
																			<a class="dropdown-item text-light bg-warning" href="print-surat?id_surat_masuk=<?= $row["id"]; ?>"><i class="fa fa-print"></i> Cetak</a>
																		<?php endif; ?>

																		<?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
																			<a class="dropdown-item text-light bg-danger" href="#" data-toggle="modal" data-target="#delete-surat-masuk<?= $row["id"]; ?>"><i class=" fa fa-trash"></i> Hapus</a>
																		<?php endif; ?>

																	</div>
																</div>
															</div>
														</td>
													</tr>
													<?php $noTable++; ?>
												<?php endforeach; ?>

											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include("../../include/footer.php"); ?>
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
						<a class="btn btn-primary" href="../../auth/logout">Keluar</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Delete Surat Masuk-->
		<?php foreach ($querySuratMasuk as $row) : ?>
			<div class="modal fade" id="delete-surat-masuk<?= $row["id"]; ?>" tabindex=" -1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Hapus Surat Masuk?</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<table>
								<tr>
									<td><strong>No. Agenda</strong></td>
									<td>: <?= $row["no_agenda"]; ?></td>
								</tr>
								<tr>
									<td><strong>Kode Klasifikasi</strong></td>
									<td>: <?= $row["kode_klasifikasi"]; ?></td>
								</tr>
								<tr>
									<td><strong>Asal Surat</strong></td>
									<td>: <?= $row["asal_surat"]; ?></td>
								</tr>
								<tr>
									<td><strong>Indeks</strong></td>
									<td>: <?= $row["indeks"]; ?></td>
								</tr>
								<tr>
									<td><strong>No. Surat</strong></td>
									<td>: <?= $row["no_surat"]; ?></td>
								</tr>
								<tr>
									<td><strong>Isi Ringkas</strong></td>
									<td>: <?= $row["isi"]; ?></td>
								</tr>
								<tr>
									<td><strong>Tanggal Diterima</strong></td>
									<td>: <?= tgl_indo(date($row["tgl_diterima"])); ?></td>
								</tr>
								<tr>
									<td><strong>Tanggal Surat</strong></td>
									<td>: <?= tgl_indo(date($row["tgl_surat"])); ?></td>
								</tr>
								<tr>
									<td><strong>Keterangan</strong></td>
									<td>: <?= $row["keterangan"]; ?></td>
								</tr>
								<tr>
									<td><strong>File</strong></td>
									<td>: <a href="../../uploads/surat-masuk/<?= $row["file"]; ?>"><i class="fa fa-download"></i> Download</a></td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
							<a href="delete-surat-masuk?id_del_sm=<?= $row["id"]; ?>" type="button" class="btn btn-danger">Hapus</a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

		<!-- =================
         FEEDBACK USER
         ================= -->
		<?php include("../../include/modal-feedback.php"); ?>


	</div>
	<!--   Core JS Files   -->
	<script src="../assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="../assets/js/core/popper.min.js"></script>
	<script src="../assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Chart JS -->
	<script src="../assets/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="../assets/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="../assets/js/plugin/datatables/datatables.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="../assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="../assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

	<!-- Sweet Alert -->
	<script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="../assets/js/atlantis.min.js"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="../assets/js/setting-demo.js"></script>
	<script src="../assets/js/demo.js"></script>

	<script>
		$(document).ready(function() {
			$('#basic-datatables').DataTable({});

			$('#multi-filter-select').DataTable({
				"pageLength": 5,
				initComplete: function() {
					this.api().columns().every(function() {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
							.appendTo($(column.footer()).empty())
							.on('change', function() {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);

								column
									.search(val ? '^' + val + '$' : '', true, false)
									.draw();
							});

						column.data().unique().sort().each(function(d, j) {
							select.append('<option value="' + d + '">' + d + '</option>')
						});
					});
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
				]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>

	<script>
		Circles.create({
			id: 'circles-1',
			radius: 45,
			value: <?php echo "{$resultSuratMasuk["jmlhSuratMasuk"]}"; ?>,
			maxValue: 100,
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
			maxValue: 100,
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
			maxValue: 100,
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
			maxValue: 100,
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
			value: <?php echo "{$resultAkun["jmlhAkun"]}"; ?>,
			maxValue: 100,
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
	</script>
</body>

</html>