<?php
// ====================================================
// PENGKONDISIAN NOTIFICATION
// ====================================================
// UPDATE DATA FEEDBACK USER
if (isset($_POST["update_feedback"])) {
  if (updateFeedback($_POST) > 0) {
    echo "
    <script>
      alert('Feedbackmu berhasil diubah');
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

$readFeeadbackUser = "1";
$readAllFeeadbackUser = "0";
$statusUpdateFeedbackUser0 = "0";
$statusUpdateFeedbackUser1 = "1";

$feedbackUser = $conn->query("SELECT * FROM tb_feedback WHERE id_user = $idSession ");
$rowFeedbackUser = mysqli_fetch_assoc($feedbackUser);

$resultFeedbackUser = mysqli_query($conn, "SELECT id_user FROM tb_feedback WHERE id_user = '$idSession' ");
