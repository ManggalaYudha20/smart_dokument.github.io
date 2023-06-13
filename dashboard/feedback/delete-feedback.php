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

// DELETE/HAPUS DATA FEEDBACK
if (isset($_GET["id_feedback"])) {

  $idFeedback = $_GET["id_feedback"];

  if (deleteFeedback($idFeedback) > 0) {
    echo "
    <script>
      alert('Data berhasil di hapus!');
      document.location.href = 'user';
    </script>";
  } else {
    echo "
    <script>
      alert('Data gagal di hapus!');
      document.location.href = 'user';
    </script>";
  }
}

// CEK LEVEL
include("../../include/check-level.php");

if ($rowSession["level"] !== $levelSuperAdmin) {
  header("Location:surat-masuk");
  exit;
}
