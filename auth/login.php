<?php
session_start();
if (isset($_SESSION["login"])) {
  header("Location:../dashboard/");
  exit;
}
require('../funct/functions.php');
include("proses-login.php");


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
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <title>Masuk Akun - smart dokument</title>

  <!-- FONTAWESOME -->
  <link rel="stylesheet" href="../assets/fontawesome-free-6.1.1-web/css/all.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

  <!-- MY STYLE CSS -->
  <link rel="stylesheet" href="../assets/css/style.css?v=<?= time(); ?>">

  <!-- CSS Files -->
  <link rel="stylesheet" href="../dashboard/assets/css/bootstrap.min.css">

  <link rel="icon" href="../dashboard/assets/img/Aldy.png?v=<?= time(); ?>" type="image/x-icon" />


</head>

<body class="bg-img">

  <div class="container">

    <div class="card col-md-6 ml-auto mr-auto border-0 col-lg-6 shadow-lg my-5 box-form">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-4">
              <div class="text-center">
                <img src="../assets/img/flaticon/archive.png" alt="">
                <h1 class="h4 mb-4">
                  SISTEM INFORMASI<br>
                  SMART DOKUMENT
                </h1>
                <span class="text-secondary">Selamat Datang di Sistem Informasi smart dokument.
                </span>
              </div>

              <!-- SUKSES PENDAFTARAN AKUN -->
              <?php if (isset($_POST["register"])) : ?>
                <?php if (register($_POST) > 0) : ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-check"></i></strong> Akun anda berhasil didaftarkan silahkan masuk.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                <?php endif; ?>
              <?php endif; ?>

              <!-- ERROR LOGIN/MASUK AKUN -->
              <?php if (isset($error)) : ?>
                <div class="my-2 alert alert-danger alert-dismissible fade show" role="alert">
                  <strong><i class="fa fa-exclamation-triangle"></i></strong> Nama pengguna atau kata sandi yang anda masukan tidak sesuai!
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <form action="" method="post" class="my-form user my-3">
                <table>
                  <tr>
                    <td class="icon-input"><i class="bi bi-person-fill"></i></td>
                    <td>
                      <input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" placeholder="Nama Pengguna" required oninvalid="this.setCustomValidity('Nama pengguna harus diisi!')" oninput="setCustomValidity('')" autofocus autocomplete="off">
                    </td>
                  </tr>
                  <tr>
                    <td class="icon-input"><i class="bi bi-lock-fill"></i></td>
                    <td>
                      <input type="password" name="password" class="form-control form-control-user" placeholder="Kata Sandi" id="myInput">
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>
                      <input type="checkbox" onclick="myFunction()" id="show-password">
                      <label for="show-password">Lihat kata sandi</label>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>
                      <button type="submit" name="login" class="btn btn-primary btn-user">Masuk Akun</button>
                    </td>
                  </tr>
                </table>
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

  <!-- VIEW / HIDE PASSWORD -->
  <script>
    function myFunction() {
      var x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>

</body>

</html>