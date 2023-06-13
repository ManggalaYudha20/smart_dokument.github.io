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

$idAccount = $_GET["id_account"];
$userAccount = query("SELECT * FROM tb_users WHERE id = '$idAccount' ")[0];

// ====================================================
// PENGKONDISIAN EDIT ACCOUNT
// ====================================================
// EDIT FOTO PROFIL
if (isset($_POST["save_img_profile"])) {
	if (editPhotoProfile($_POST) > 0) {
		echo "
    <script>
      document.location.href = '';
    </script>";
	}
}
// EDIT NAMA
if (isset($_POST["save_name"])) {
	if (editName($_POST) > 0) {
		echo "
    <script>
      document.location.href = '';
    </script>";
	}
}

// EDIT NAMA PENGGUNA
if (isset($_POST["save_username"])) {
	if (editUsername($_POST) > 0) {
		echo "
    <script>
      alert('SUKSES! Nama pengguna berhasil diubah. Silahkan masuk kembali');
      document.location.href = '';
    </script>";
	}
}

// EDIT KATA SANDI
if (isset($_POST["save_password"])) {
	if (editPassword($_POST) > 0) {
		echo "
    <script>
      alert('SUKSES! Kata sandi berhasil diubah. Silahkan masuk kembali');
      document.location.href = '../../auth/logout';
    </script>";
	}
}

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
	<title>Dashbor - smart dokument</title>
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

	<!-- My Style Css -->
	<link rel="stylesheet" href="../../assets/css/style.css?v=<?= time(); ?>" class="css">

</head>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<a href="" class="logo text-white">
					<img src="../assets/img/Aldy.png?v=<?= time(); ?>" alt="Arsip Bappeda Litbang Bone Bolango"width="70">
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
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">Pengaturan Akun</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
					<div class="row">
						<div class="col-md-4">
							<div class="card">
								<div class="card-body card-profile">
									<div class="banner-profile">
										<img src="../../assets/img/banner-profile.jpg?v=<?= time(); ?>" alt="">
									</div>
									<div class="img-profile">
										<img src="../../assets/img/photo-profile/<?= $rowSession["gambar"]; ?>" alt="">
									</div>
									<div class="id-profile">
										<h3><?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?></h3>
									</div>
									<div class="level-profile">
										<h5>
											<?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
												Super Admin
											<?php endif; ?>

											<?php if ($rowSession["level"] === $levelKaban) : ?>
												Kepala Baeppeda
											<?php endif; ?>

											<?php if ($rowSession["level"] === $levelUser) : ?>
												User
											<?php endif; ?>
										</h5>
									</div>
									<div class="upload-img-profile">
										<form action="" method="post" enctype="multipart/form-data">
											<input type="text" hidden name="id" value="<?= $userAccount["id"]; ?>">
											<input type="text" hidden name="img_old" value="<?= $userAccount["gambar"]; ?>">
											<table>
												<tr>
													<td>
														<input type="file" name="gambar" class="fa fa-camera upload-img">
													</td>
													<td>
														<button type="submit" name="save_img_profile">
															<i class="fa fa-save"></i>
														</button>
													</td>
												</tr>
											</table>
										</form>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="card">
								<div class="card-body card-account">
									<ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
										<li class="nav-item col-md-4 ">
											<a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="pills-profile" aria-selected="true"><i class="fa fa-id-card"></i> Profil</a>
										</li>
										<li class="nav-item col-md-4">
											<a class="nav-link" id="pills-account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="pills-account" aria-selected="false"><i class="fa fa-lock"></i> Akun</a>
										</li>
										<li class="nav-item col-md-4">
											<a class="nav-link" id="pills-settings-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="pills-settings" aria-selected="false"><i class="fa fa-cog"></i> Pengaturan</a>
										</li>
									</ul>

									<div class="tab-content mt-2 mb-3" id="pills-tabContent">
										<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="pills-profile-tab">
											<div class="data-profile">
												<div class="form-group row">
													<div class="col-sm-6">
														<label>Nama Depan</label>
														<span class="form-control form-control-user"><?= $userAccount["first_name"]; ?></span>
													</div>
													<div class="col-sm-6">
														<label>Nama Belakang</label>
														<span class="form-control form-control-user"><?= $userAccount["last_name"]; ?></span>
													</div>
												</div>
												<hr>
												<div class="form-group row">
													<div class="col-sm-6">
														<label>Nama Pengguna</label>
														<span class="form-control form-control-user"><?= $userAccount["username"]; ?></span>
													</div>
													<div class="col-sm-6">
														<label>Level Akun</label>
														<span class="form-control form-control-user">
															<?php if ($userAccount["level"] === $levelSuperAdmin) : ?>
																Super Admin
															<?php endif; ?>

															<?php if ($userAccount["level"] === $levelKaban) : ?>
																Kepala Baeppeda
															<?php endif; ?>

															<?php if ($userAccount["level"] === $levelUser) : ?>
																User
															<?php endif; ?>
														</span>
													</div>
												</div>
											</div>
										</div>

										<div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="pills-account-tab">
											<div class="data-account">
												<form action="" method="post">
													<input type="text" hidden name="id" value="<?= $userAccount["id"]; ?>">
													<div class="form-group row">
														<div class="col-sm-6">
															<label for="first_name"><i class="fas fa-user"></i> Nama Depan</label>
															<input type="text" name="first_name" id="first_name" placeholder="Masukan nama lengkap" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nama depan harus diisi!')" oninput="setCustomValidity('')" value="<?= $userAccount["first_name"]; ?>">
														</div>
														<div class="col-sm-6">
															<label for="last_name"><i class="fas fa-user"></i> Nama Belakang</label>
															<input type="text" name="last_name" id="last_name" placeholder="Masukan nama lengkap" class="form-control form-control-user" value="<?= $userAccount["last_name"]; ?>">
														</div>
														<div class="col-sm-12">
															<button type="submit" name="save_name" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
														</div>
													</div>
												</form>
												<hr>
												<form action="" method="post">
													<input type="text" hidden name="id" value="<?= $userAccount["id"]; ?>">
													<div class="form-group row">
														<div class="col-sm-12">
															<label for="username"><i class="fa fa-user"></i> Nama pengguna</label>
															<input type="text" name="username" id="username" placeholder="Masukan nama lengkap" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nama pengguna harus diisi!')" oninput="setCustomValidity('')" value="<?= $userAccount["username"]; ?>">
														</div>
														<div class="col-sm-12">
															<button type="submit" name="save_username" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
														</div>
													</div>
												</form>
												<hr>
												<form action="" method="post">
													<input type="text" hidden name="id" value="<?= $userAccount["id"]; ?>">
													<div class="form-group row">
														<div class="col-sm-6">
															<label for="password"><i class="fa fa-lock"></i> Kata Sandi</label>
															<input type="password" name="password" id="password" placeholder="Masukan kata sandi baru" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Kata sandi harus diisi!')" oninput="setCustomValidity('')">
														</div>
														<div class="col-sm-6">
															<label for="password2"><i class="fa fa-lock"></i> Konfirmasi Kata Sandi</label>
															<input type="password" name="password2" id="password2" placeholder="Konfirmasi kata sandi baru" class="form-control form-control-user">
														</div>
														<div class="col-sm-12">
															<button type="submit" name="save_password" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
														</div>
													</div>
												</form>
											</div>
										</div>

										<div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="pills-settings-tab">
											<p>Pengaturan</p>
										</div>

									</div>
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

</body>

</html>