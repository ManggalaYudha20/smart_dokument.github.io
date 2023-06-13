<?php
// ====================================================
// PENGKONDISIAN SEND MESSAGE
// ====================================================
// SEND DATA MESSAGE
if (isset($_POST["send_message"])) {
  if (sendMessage($_POST) > 0) {
    echo "
    <script>
      alert('Terimakasih sudah memberikan Message kepada kami. Pesanmu sudah kami terima');
      document.location.href = '';
    </script>";
  } else {
    echo "
    <script>
      alert('GAGAL!');
      document.location.href = '';
    </script>";
  }
}
// UPDATE DATA MESSAGE
if (isset($_POST["update_message"])) {
  if (updateMessage($_POST) > 0) {
    echo "
    <script>
      alert('Pesan berhasil diubah');
      document.location.href = '';
    </script>";
  } else {
    echo "
    <script>
      alert('GAGAL!');
      document.location.href = '';
    </script>";
  }
}

$readMessage = "1";
$readAllMessage = "0";
$statusUpdateMessage0 = "0";
$statusUpdateMessage1 = "1";

$MessagekUser = $conn->query("SELECT * FROM tb_message WHERE id_user = $idSession ");
$rowMessagekUser = mysqli_fetch_assoc($MessagekUser);

$resultMessagekUser = mysqli_query($conn, "SELECT id_user FROM tb_message WHERE id_user = '$idSession' ");
