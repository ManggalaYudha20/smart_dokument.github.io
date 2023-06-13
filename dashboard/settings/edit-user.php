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
// query table users berdasarkan URL [0]
// ============================================
if (isset($_GET["id_user"])) {
  $IdUser = $_GET["id_user"];
  $queryIdUser = query("SELECT * FROM tb_users WHERE id = '$IdUser' ")[0];
}

// ====================================================
// PENGKONDISIAN ACCOUNT SUPER ADMIN, KEPALA BADAN, USER
// ====================================================
// EDIT FOTO PROFIL
if (isset($_POST["edit_photo_profile"])) {
  if (editPhotoProfile($_POST) > 0) {
    echo "
    <script>
      alert('SUKSES! Foto Profil berhasil diubah');
      document.location.href = 'user';
    </script>";
  }
}
// EDIT NAMA
if (isset($_POST["edit_nama"])) {
  if (editName($_POST) > 0) {
    echo "
    <script>
      alert('SUKSES! Nama berhasil diubah');
      document.location.href = 'user';
    </script>";
  }
}

// EDIT NAMA PENGGUNA
if (isset($_POST["edit_username"])) {
  if (editUsername($_POST) > 0) {
    echo "
    <script>
      alert('SUKSES! Nama pengguna berhasil diubah');
      document.location.href = 'user';
    </script>";
  }
}

// EDIT KATA SANDI
if (isset($_POST["edit_password"])) {
  if (editPassword($_POST) > 0) {
    echo "
    <script>
      alert('SUKSES! Kata sandi berhasil diubah');
      document.location.href = 'user';
    </script>";
  }
}

// EDIT LEVEL ACCOUNT
if (isset($_POST["edit_level"])) {
  if (editLevel($_POST) > 0) {
    echo "
    <script>
      alert('SUKSES! Level akun berhasil diubah');
      document.location.href = 'user';
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

if ($rowSession["level"] !== $levelSuperAdmin) {
  header("Location:../");
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
  <title>Edit Akun Pengguna - smart dokumen</title>
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

  <!-- My Style Css -->
  <link rel="stylesheet" href="../../assets/css/style.css?v=<?= time(); ?>" class="css">

  <!-- Style Dashboard -->
  <link rel="stylesheet" href="../../assets/css/dashboard.css?v=<?= time(); ?>" class="css">

</head>

<body>
  <div class="wrapper">
    <div class="main-header">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="blue">

        <a href="" class="logo text-white">
          <img src="../assets/img/Aldy.png?v=<?= time(); ?>" alt="smart dokumen"width="70">
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
                <h2 class="text-white pb-2 fw-bold">Edit Akun Pengguna</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-inner mt--5">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body card-account">

                  <div class="data-account">
                    <div class="col-sm-6">
                      <a href="user" class="btn-cancel">
                        <i class="flaticon-left-arrow"></i> Kembali
                      </a>
                    </div>

                    <form action="" method="post" enctype="multipart/form-data">
                      <input type="text" hidden name="id" value="<?= $queryIdUser["id"]; ?>">
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="first_name"><i class="fas fa-user"></i> Nama Depan</label>
                          <input type="text" name="first_name" id="first_name" placeholder="Masukan nama lengkap" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nama depan harus diisi!')" oninput="setCustomValidity('')" value="<?= $queryIdUser["first_name"]; ?>">
                        </div>
                        <div class="col-sm-6">
                          <label for="last_name"><i class="fas fa-user"></i> Nama Belakang</label>
                          <input type="text" name="last_name" id="last_name" placeholder="Masukan nama lengkap" class="form-control form-control-user" value="<?= $queryIdUser["last_name"]; ?>">
                        </div>
                        <div class="col-sm-12">
                          <button type="submit" name="edit_nama" class="btn btn-primary"><i class="fa fa-save"></i> Ubah Nama</button>
                        </div>
                      </div>
                    </form>

                    <form action="" method="post" enctype="multipart/form-data">
                      <input type="text" hidden name="id" value="<?= $queryIdUser["id"]; ?>">
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <label for="username"><i class="fa fa-user"></i> Nama pengguna</label>
                          <input type="text" name="username" id="username" placeholder="Masukan nama lengkap" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nama pengguna harus diisi!')" oninput="setCustomValidity('')" value="<?= $queryIdUser["username"]; ?>" autocomplete="off">
                          <button type="submit" name="edit_username" class="btn btn-primary"><i class="fa fa-save"></i> Ubah Nama Pengguna</button>
                        </div>
                      </div>
                    </form>

                    <form action="" method="post" enctype="multipart/form-data">
                      <input type="text" hidden name="id" value="<?= $queryIdUser["id"]; ?>">
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="password"><i class="fa fa-lock"></i> Kata Sandi</label>
                          <input type="password" name="password" id="password" placeholder="Masukan kata sandi baru" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Kata sandi harus diisi!')" oninput="setCustomValidity('')">
                        </div>
                        <div class="col-sm-6">
                          <label for="password2"><i class="fa fa-lock"></i> Konfirmasi Kata Sandi</label>
                          <input type="password" name="password2" id="password2" placeholder="Konfirmasi kata sandi baru" class="form-control form-control-user">
                        </div>
                        <div class="col-sm-6">
                          <button type="submit" name="edit_password" class="btn btn-primary"><i class="fa fa-save"></i> Ubah Kata Sandi</button>
                        </div>
                      </div>
                    </form>

                    <form action="" method="post" enctype="multipart/form-data">
                      <input type="text" hidden name="id" value="<?= $queryIdUser["id"]; ?>">
                      <div class="form-group row">
                        <div class="col-sm-6">
                          <label for="level"><i class="fa fa-level-up-alt"></i> Level Akun</label>
                          <select name="level" id="level" placeholder="Masukan kata sandi baru" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Kata sandi harus diisi!')" oninput="setCustomValidity('')">
                            <option value="<?= $queryIdUser["level"]; ?>">
                              <?php if ($queryIdUser["level"] === $levelSuperAdmin) : ?>
                                Super Admin
                              <?php endif; ?>

                              <?php if ($queryIdUser["level"] === $levelKaban) : ?>
                                Kepala Bappeda
                              <?php endif; ?>

                              <?php if ($queryIdUser["level"] === $levelUser) : ?>
                                User
                              <?php endif; ?>
                            </option>
                            <option value="superadmin">Super Admin</option>
                            <option value="kaban">Kepala Bappeda</option>
                            <option value="user">User</option>
                          </select>
                          <button type="submit" name="edit_level" class="btn btn-primary"><i class="fa fa-save"></i> Ubah Level</button>
                        </div>
                    </form>

                    <div class="col-sm-6 form-img">
                      <form action="" method="post" enctype="multipart/form-data">
                        <input type="text" hidden name="id" value="<?= $queryIdUser["id"]; ?>">
                        <input type="text" hidden name="img_old" value="<?= $queryIdUser["gambar"]; ?>">
                        <label for="gambar">
                          <img src="../../assets/img/photo-profile/<?= $queryIdUser["gambar"]; ?>" alt="Foto Profil">
                          Ubah Foto Profil
                        </label>
                        <input type="file" name="gambar" id="gambar" class="form-control form-control-user">
                        <button type="submit" name="edit_photo_profile" class="btn btn-primary"><i class="fa fa-save"></i> Ubah Foto Profil</button>
                      </form>
                    </div>

                    <div class="col-sm-6">
                      <a href="user" class="btn-cancel">
                        <i class="flaticon-left-arrow"></i> Kembali
                      </a>
                    </div>

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

</body>

</html>