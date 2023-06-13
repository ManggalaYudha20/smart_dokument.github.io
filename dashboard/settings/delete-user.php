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

// DELETE/HAPUS ACCOUNT
if (isset($_GET["id_user"])) {

  $idAccount = $_GET["id_user"];
  if (deleteAccount($idAccount) > 0) {
    echo "
    <script>
      alert('Akun berhasil di hapus!');
      document.location.href = 'user';
    </script>";
  } else {
    echo "
    <script>
      alert('Akun gagal di hapus!');
      document.location.href = '';
    </script>";
  }
}

// CEK LEVEL
include("../../include/check-level.php");

if ($rowSession["level"] !== $levelSuperAdmin) {
  header("Location:../");
  exit;
}
