<?php

if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE username = '$username' ");

  // CEK USERNAME 
  if (mysqli_num_rows($result) === 1) {

    $row = mysqli_fetch_assoc($result);

    // CEK PASSWORD
    if (password_verify($password, $row["password"])) {

      // SET SESSION
      $_SESSION["login"] = true;
      $_SESSION["username"] = $username;

      header("Location:../dashboard/");
      exit;
    }
  }
  $error = true;
}
