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

// DELETE/HAPUS DATA SURAT DISPOSISI
if (isset($_GET["id_disp_surat"])) {

  $idSuratDisposisi = $_GET["id_disp_surat"];
  if (deleteSuratDisposisi($idSuratDisposisi) > 0) {
    $backDisposisiSurat = "javascript:window.history.go(-3);";
    echo "
    <script>
      alert('Data berhasil di hapus!');
      document.location.href = '$backDisposisiSurat';
    </script>";
  } else {
    echo "
    <script>
      alert('Data gagal di hapus!');
      document.location.href = '';
    </script>";
  }
}

// CEK LEVEL
include("../../include/check-level.php");

if ($rowSession["level"] === $levelUser) {
  header("Location:surat-masuk");
  exit;
}
