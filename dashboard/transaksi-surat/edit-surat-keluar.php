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
// query table surat keluar berdasarkan URL [0]
// ============================================
if (isset($_GET["id_surat_keluar"])) {
	$idSuratKeluar = $_GET["id_surat_keluar"];
	$queryIdSuratKeluar = query("SELECT * FROM tb_surat_keluar WHERE id = '$idSuratKeluar' ")[0];
}

// check empty account
if (empty($rowSession["id"])) {
	header("Location:../../auth/logout");
	exit;
}

// ====================================================
// PENGKONDISIAN SURAT KELUAR
// ====================================================
// EDIT/UBAH DATA SURAT KELUAR
if (isset($_POST["edit_surat_keluar"])) {
	if (editDataSuratKeluar($_POST) > 0) {
		echo "
    <script>
      alert('SUKSES! Data berhasil diedit');
      document.location.href = 'surat-keluar';
    </script>";
	} else {
		echo "
    <script>
      alert('GAGAL! Data gagal diedit');
      document.location.href = '';
    </script>";
	}
}

// CEK LEVEL
include("../../include/check-level.php");

if ($rowSession["level"] !== $levelSuperAdmin) {
	header("Location:surat-keluar");
	exit;
}

// SET DATE
date_default_timezone_set('Asia/Makassar');

// tanggal, bulan, tahun
$tbh = date("d M Y");
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
	<title>Edit Surat Keluar - smart dokumen</title>
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
	<link rel="stylesheet" href="../../assets/css/dashboard.css?v=<?= time(); ?>" class="css">

</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<a href="../" class="logo text-white">
					<img src="../assets/img/Aldy.png?v=<?= time(); ?>" alt="smart dokumen" width="70">
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
						<h4 class="page-title">Edit Data Surat Keluar</h4>
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
								<a href="surat-keluar">Data Surat Keluar</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Edit Data Surat Keluar</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<form action="" method="post" class="user" enctype="multipart/form-data">
									<input type="hidden" name="id" value="<?= $queryIdSuratKeluar["id"]; ?>">
									<input type="hidden" name="id_user" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["id"]))))))))); ?>">
									<input type="hidden" name="file_lama" value="<?= $queryIdSuratKeluar["file"]; ?>">
									<div class="card-body row form-add">
										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<input id="no_agenda" name="no_agenda" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSuratKeluar["no_agenda"]; ?>">
											<label for="no_agenda" class="placeholder"><img src="../../assets/img/flaticon/number-one.png?v=<?= time(); ?>" alt=""> Nomor Agenda</label>
										</div>

										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<input id="kode_klasifikasi" name="kode_klasifikasi" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSuratKeluar["kode_klasifikasi"]; ?>">
											<label for="kode_klasifikasi" class="placeholder"><img src="../../assets/img/flaticon/bookmark.png?v=<?= time(); ?>" alt=""> Kode Klasifikasi</label>
										</div>
									</div>

									<div class="card-body row form-add">
										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<input id="tujuan_surat" name="tujuan_surat" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSuratKeluar["tujuan_surat"]; ?>">
											<label for="tujuan_surat" class="placeholder"><img src="../../assets/img/flaticon/location.png?v=<?= time(); ?>" alt=""> Tujuan Surat</label>
										</div>

										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<input id="no_surat" name="no_surat" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSuratKeluar["no_surat"]; ?>">
											<label for="no_surat" class="placeholder"><img src="../../assets/img/flaticon/number-2.png?v=<?= time(); ?>" alt=""> Nomor Surat</label>
										</div>
									</div>

									<div class="card-body row form-add">
										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<input id="keterangan" name="keterangan" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSuratKeluar["keterangan"]; ?>">
											<label for="keterangan" class="placeholder"><img src="../../assets/img/flaticon/menu.png?v=<?= time(); ?>" alt=""> Keterangan</label>
										</div>

										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<input id="isi" name="isi" type="text" class="form-control input-border-bottom" required="" value="<?= $queryIdSuratKeluar["isi"]; ?>">
											<label for="isi" class="placeholder"><img src="../../assets/img/flaticon/edit-info.png?v=<?= time(); ?>" alt=""> Isi Ringkas</label>
										</div>
									</div>

									<input type="hidden" name="tgl_diterima" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($queryIdSuratKeluar["tgl_diterima"]))))))))); ?>">

									<div class="card-body row form-add">
										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<label for="tgl_surat"><img src="../../assets/img/flaticon/calendar.png?v=<?= time(); ?>" alt=""> Tanggal Surat</label>
											<input id="tgl_surat" name="tgl_surat" type="date" class="form-control input-border-bottom" required="" value="<?= $queryIdSuratKeluar["tgl_surat"]; ?>">
										</div>

										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<label for="file"><img src="../../assets/img/flaticon/add-file.png?v=<?= time(); ?>" alt=""> Upload file/scan gambar surat keluar</label>
											<input id="file" name="file" type="file" accept=".jpg,.jpeg,.png,.doc,.docx,.pdf" class="form-control input-border-bottom">
											<span class="text-danger"> *Format file yang diperbolehkan *.JPG, *.PNG, *.DOC, *.DOCX, *.PDF dan ukuran maksimal file 5 MB! </span>
											<p>File Lama : <a href="../../uploads/surat-keluar/<?= $queryIdSuratKeluar["file"]; ?>">Download</a> </p>
										</div>
									</div>

									<input type="text" hidden name="status_read" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($queryIdSuratKeluar["status_read"]))))))))); ?>">
									<input type="text" hidden name="status_read_all" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($queryIdSuratKeluar["status_read_all"]))))))))); ?>">
									<input type="text" hidden name="date" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($queryIdSuratKeluar["date"]))))))))); ?>">
									<input type="text" hidden name="time" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($queryIdSuratKeluar["time"]))))))))); ?>">

									<div class="card-body row form-add">
										<div class="form-group form-floating-label col-sm-6 mb-3 mb-sm-0">
											<button type="submit" name="edit_surat_keluar" class="btn btn-primary btn-addsm">SIMPAN <i class="fa fa-save"></i></button>
											<button type="reset" class="btn btn-danger btn-addsm">RESET <i class="fa fa-times"></i></button>
											<a href="javascript:window.history.go(-1);" class="btn btn-secondary btn-addsm">BATAL</a>
										</div>
									</div>

								</form>
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