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

$queryAccount = query("SELECT * FROM tb_users");

// ====================================================
// PENGKONDISIAN ACCOUNT SUPER ADMIN, KEPALA BADAN, USER
// ====================================================
// TAMBAH ACCOUUNT
if (isset($_POST["add_account"])) {
  if (addAccount($_POST) > 0) {
    echo "
    <script>
      document.location.href = '';
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
  <title>Akun Pengguna - smart dokument</title>
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

  <!-- Style Dashboard -->
  <link rel="stylesheet" href="../../assets/css/dashboard.css?v=<?= time(); ?>" class="css">

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
                <h2 class="text-white pb-2 fw-bold">Akun Pengguna</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-inner mt--5">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body card-account">
                  <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
                    <li class="nav-item col-md-6 ">
                      <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="pills-profile" aria-selected="true"><i class="fa fa-user"></i> Semua Akun</a>
                    </li>
                    <li class="nav-item col-md-6">
                      <a class="nav-link" id="pills-account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="pills-account" aria-selected="false"><i class="fa fa-user"></i> Tambah Akun</a>
                    </li>
                  </ul>
                  <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                      <div class="card-body">
                        <div class="table-responsive table-photo">
                          <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Nama Pengguna</th>
                                <th>Kata Sandi</th>
                                <th>Level</th>
                                <th style="width: 10%">Opsi</th>
                              </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Nama Depan</th>
                                <th>Nama Belakang</th>
                                <th>Nama Pengguna</th>
                                <th>Kata Sandi</th>
                                <th>Level</th>
                                <th style="width: 10%">Opsi</th>
                              </tr>
                            </tfoot>
                            <tbody>
                              <?php $noTable = 1; ?>
                              <?php foreach ($queryAccount as $row) : ?>
                                <tr>
                                  <td><?= $noTable; ?></td>
                                  <td>
                                    <a href="../../assets/img/photo-profile/<?= $row["gambar"]; ?>" title="<?= $row["first_name"]; ?> <?= $row["last_name"]; ?>" target="_BLANK">
                                      <img src="../../assets/img/photo-profile/<?= $row["gambar"]; ?>" alt="" width="50">
                                    </a>
                                  </td>
                                  <td><?= $row["first_name"]; ?></td>
                                  <td><?= $row["last_name"]; ?></td>
                                  <td><?= $row["username"]; ?></td>
                                  <td><?= $row["password2"]; ?></td>
                                  <td><?= $row["level"]; ?></td>
                                  <td>
                                    <div class="form-button-action">
                                      <div class="dropdown show">
                                        <a class="show-opsi bg-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Opsi
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-opsi" aria-labelledby="dropdownMenuLink">
                                          <a class="dropdown-item text-light bg-primary" href="edit-user?id_user=<?= $row["id"]; ?>"><i class="fa fa-edit"></i> Edit</a>

                                          <a class="dropdown-item text-light bg-danger" href="#" data-toggle="modal" data-target="#delete-account<?= $row["id"]; ?>"><i class=" fa fa-trash"></i> Hapus</a>
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

                    <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="pills-account-tab">
                      <div class="data-account">
                        <form action="" method="post" enctype="multipart/form-data">
                          <div class="form-group row">
                            <div class="col-sm-6">
                              <label for="first_name"><i class="fas fa-user"></i> Nama Depan</label>
                              <input type="text" name="first_name" id="first_name" placeholder="Masukan nama lengkap" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nama depan harus diisi!')" oninput="setCustomValidity('')" value="<?= $userAccount["first_name"]; ?>">
                            </div>
                            <div class="col-sm-6">
                              <label for="last_name"><i class="fas fa-user"></i> Nama Belakang</label>
                              <input type="text" name="last_name" id="last_name" placeholder="Masukan nama lengkap" class="form-control form-control-user" value="<?= $userAccount["last_name"]; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-12">
                              <label for="username"><i class="fa fa-user"></i> Nama pengguna</label>
                              <input type="text" name="username" id="username" placeholder="Masukan nama lengkap" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Nama pengguna harus diisi!')" oninput="setCustomValidity('')" value="<?= $userAccount["username"]; ?>" autocomplete="off">
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-6">
                              <label for="password"><i class="fa fa-lock"></i> Kata Sandi</label>
                              <input type="password" name="password" id="password" placeholder="Masukan kata sandi baru" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Kata sandi harus diisi!')" oninput="setCustomValidity('')">
                            </div>
                            <div class="col-sm-6">
                              <label for="password2"><i class="fa fa-lock"></i> Konfirmasi Kata Sandi</label>
                              <input type="password" name="password2" id="password2" placeholder="Konfirmasi kata sandi baru" class="form-control form-control-user">
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-6">
                              <label for="level"><i class="fa fa-level-up-alt"></i> Level Akun</label>
                              <select name="level" id="level" placeholder="Masukan kata sandi baru" class="form-control form-control-user" required oninvalid="this.setCustomValidity('Kata sandi harus diisi!')" oninput="setCustomValidity('')">
                                <option value="superadmin">Super Admin</option>
                                <option value="kaban">Kepala Bappeda</option>
                                <option value="user">User</option>
                              </select>
                            </div>
                            <div class="col-sm-6">
                              <label for="gambar"><i class="fa fa-image"></i> Foto Profil</label>
                              <input type="file" name="gambar" id="gambar" class="form-control form-control-user">
                            </div>
                            <div class="col-sm-12">
                              <button type="submit" name="add_account" class="btn btn-primary"><i class="fa fa-save"></i> Tambah Akun</button>
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


  <!-- Modal Delete Surat Masuk-->
  <?php foreach ($queryAccount as $row) : ?>
    <div class="modal fade" id="delete-account<?= $row["id"]; ?>" tabindex=" -1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Hapus Akun Ini?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body modal-delete">
            <table>
              <tr>
                <td><strong>Foto Profil</strong></td>
                <td>:
                  <a href="../../assets/img/photo-profile/<?= $row["gambar"]; ?>" title="<?= $row["first_name"]; ?> <?= $row["last_name"]; ?>" target="_BLANK">
                    <img src="../../assets/img/photo-profile/<?= $row["gambar"]; ?>" alt="Foto Profil">
                  </a>
                </td>
              </tr>
              <tr>
                <td><strong>Nama</strong></td>
                <td>: <?= $row["first_name"]; ?> <?= $row["last_name"]; ?></td>
              </tr>
              <tr>
                <td><strong>Nama Pengguna</strong></td>
                <td>: <?= $row["username"]; ?></td>
              </tr>
              <tr>
                <td><strong>Kata Sandi</strong></td>
                <td>: <?= $row["password2"]; ?></td>
              </tr>
              <tr>
                <td><strong>Level</strong></td>
                <td>: <?= $row["level"]; ?></td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
            <a href="delete-user?id_user=<?= $row["id"]; ?>" type="button" class="btn btn-danger">Hapus</a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>


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