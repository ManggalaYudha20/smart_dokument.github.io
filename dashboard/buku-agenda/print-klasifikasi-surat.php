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

// ============================================
// query table surat masuk berdasarkan URL [0]
// ============================================
if (isset($_GET["id_surat_masuk"])) {
	$idSuratMasuk = $_GET["id_surat_masuk"];
	$queryIdSuratMasuk = query("SELECT * FROM tb_surat_masuk WHERE id = '$idSuratMasuk' ")[0];
}

// query table surat masuk berdasarkan URL
if (isset($_GET["id_surat_masuk"])) {
	$idSuratMasuk = $_GET["id_surat_masuk"];
	$queryDisposisiSuratMasuk = $conn->query("SELECT * FROM tb_disposisi WHERE id_surat = '$idSuratMasuk' ");
	$resultDisposisi = mysqli_fetch_assoc($queryDisposisiSuratMasuk);
}

if (!empty($_GET["dari"]) || !empty($_GET["ke"])) {
	// query table surat masuk berdasarkan dari tgl berapa sampai tgl berapa
	$queryKlasifikasiSurat = query("SELECT * FROM tb_klasifikasi WHERE tgl_diterima BETWEEN '" . $_GET['dari'] . "' and '" . $_GET['ke'] . "'");
}

// check empty account
if (empty($rowSession["id"])) {
	header("Location:../../auth/logout");
	exit;
}

// CEK LEVEL
include("../../include/check-level.php");

if ($rowSession["level"] === $levelUser) {
	header("Location:../");
	exit;
}

// SET DATE
date_default_timezone_set('Asia/Makassar');

// tanggal, bulan, tahun
$tbh = date("d M Y");

// Format Tanggal Indonesia
include("../../include/tgl-indo.php");

$nbsp = "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Lembar Disposisi - smart dokument</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/icon.ico?v=<?= time(); ?>" type="image/x-icon" />

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
	<link rel="stylesheet" href="../../assets/css/print-surat.css?v=<?= time(); ?>" class="css">

</head>

<body>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<a href="javascript:window.history.go(-1);" class="btn btn-primary" title="Kembali"><i class="flaticon-left-arrow"></i></a>
						<a href="#" class="btn btn-warning btn-round ml-auto" onclick="window.print()"><i class="fa fa-print"></i> Cetak</a>
					</div>
				</div>
				<div class="card-body">

					<!-- LAYOUT SURAT -->
					<div class="container-surat">
						<!-- kop surat -->
						<div class="kop-surat">
							<img src="../../assets/img/Logo_Kabupaten_Bone_Bolango.jpg" alt="">
							<h2>Pemerintah manado</h2>
							<h1>smart dokument</h1>
							<p> Bahu, Kec. Malalayang, Kota Manado, Sulawesi Utara</p>
						</div>
						<div class="hr-kop-surat"></div>
					</div>

					<!-- konten surat -->
					<div class="konten-agenda-surat">
						<h2>
							<center>AGENDA KLASIFIKASI SURAT</center>
						</h2>
						<h3>
							<center>
								Agenda klasifikasi surat dari tanggal <strong><?= tgl_indo(date($_GET["dari"])); ?></strong> sampai dengan tanggal <strong><?= tgl_indo(date($_GET["ke"])); ?></strong>

								<?php if (empty($querySuratKeluar)) : ?>
									<i>tidak ditemukan</i>
								<?php endif; ?>
							</center>
						</h3>
						<table border="1" cellpadding="10">
							<thead>
								<tr>
									<th>#</th>
									<th>Kode</th>
									<th>Nama</th>
									<th>Uraian</th>
									<th>Tanggal Diterima</th>
									<th>Pengelola</th>
								</tr>
							</thead>
							<tbody>
								<?php $noTable = 1; ?>
								<?php foreach ($queryKlasifikasiSurat as $row) : ?>
									<tr>
										<td><?= $noTable; ?></td>
										<td><?= $row["kode"]; ?></td>
										<td><?= $row["nama"]; ?></td>
										<td><?= $row["uraian"]; ?></td>
										<td><?= tgl_indo(date($row["tgl_diterima"])); ?></td>
										<td>Kepala smart dokument</td>
									</tr>
									<?php $noTable++; ?>
								<?php endforeach; ?>
						</table>
					</div>
					<!-- end LAYOUT SURAT -->

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