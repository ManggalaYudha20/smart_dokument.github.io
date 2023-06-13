<?php
// query Feedback
$queryFeedback = query("SELECT * FROM tb_feedback ORDER BY id DESC");

// Check Read/Unread Message

// ==================================================================
// HITUNG BERAPA JUMLAH UMPAN BALIK/Feedback (BELUM DIBACA/UNREAD - USER)
// ==================================================================
// query feedback (status)
$queryStatusFeedback = query("SELECT * FROM tb_feedback WHERE status = '1' ");

$jmlhFeedbackUnread = $conn->query("SELECT COUNT(*) jmlhFeedbackUnread FROM tb_feedback WHERE status = '1' ");
$resultFeedbackUnread = mysqli_fetch_assoc($jmlhFeedbackUnread);

// ---------------------------------------------------------------------------------

// query Message
$queryMessage = query("SELECT * FROM tb_message WHERE id_user = '$idSession' ORDER BY id DESC");

// ==================================================================
// HITUNG BERAPA JUMLAH UMPAN BALIK/Message (BELUM DIBACA/UNREAD)
// ==================================================================
// query Message (status)
$queryStatusMessage = query("SELECT * FROM tb_message WHERE status = '1' ");

$jmlhMessageUnread = $conn->query("SELECT COUNT(*) jmlhMessageUnread FROM tb_message WHERE status = '1' ");
$resultMessageUnread = mysqli_fetch_assoc($jmlhMessageUnread);

// ---------------------------------------------------------------------------------

// query Notification 
$queryNotification = query("SELECT * FROM tb_notification ORDER BY id_notif DESC");

// ==================================================================
// HITUNG BERAPA JUMLAH Notification (BELUM DIBACA/UNREAD - KABAN)
// ==================================================================
// query Notification  (status_read)
$queryStatusNotification = query("SELECT * FROM tb_notification WHERE status_read = '1' ");

$jmlhNotificationUnread = $conn->query("SELECT COUNT(*) jmlhNotificationUnread FROM tb_notification WHERE status_read = '1' ");
$resultNotificationUnread = mysqli_fetch_assoc($jmlhNotificationUnread);

// ---------------------------------------------------------------------------------

// FORMAT TANGGAL INDONESIA
function tgl_indo_notif($tanggal)
{
  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);

  return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// include process feedback user
include("process-feedback.php");

?>

<head>
  <style>
    /* FEEDBACK */
    .card-feedback button,
    .read-all-feedback-user button {
      border: none;
      background-color: transparent;
      cursor: pointer;
      width: 100%;
      text-align: left;
      padding: 0;
      border-bottom: 1px solid #eee;
    }

    .unread-message {
      background-color: #177cff23;
    }

    .notif-img img {
      width: 40px !important;
      object-fit: cover;
      height: 40px !important;
    }
  </style>
</head>

<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

  <div class="container-fluid">
    <!-- search -->
    <div class="collapse" id="search-nav">
      <form class="navbar-left navbar-form nav-search mr-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <button type="submit" class="btn btn-search pr-1">
              <i class="fa fa-search search-icon"></i>
            </button>
          </div>
          <input type="text" placeholder="Cari ..." class="form-control">
        </div>
      </form>
    </div>
    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
      <li class="nav-item toggle-nav-search hidden-caret">
        <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
          <i class="fa fa-search"></i>
        </a>
      </li>
      <!-- end search -->

      <?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
        <!-- Feedback -->
        <li class="nav-item dropdown hidden-caret">
          <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-comments"></i>
            <!-- check count feedback -->
            <?php if (!empty($queryStatusFeedback)) : ?>
              <span class="notification bg-danger"><?php echo "{$resultFeedbackUnread["jmlhFeedbackUnread"]}"; ?></span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
            <li>
              <div class="dropdown-title d-flex justify-content-between align-items-center">
                Feedback
                <?php if (!empty($queryStatusFeedback)) : ?>
                  <span><?php echo "{$resultFeedbackUnread["jmlhFeedbackUnread"]}"; ?> Feedback belum dibaca</span>
                <?php endif; ?>
              </div>
            </li>
            <li>
              <div class="message-notif-scroll scrollbar-outer">
                <div class="notif-center card-feedback">
                  <?php foreach ($queryFeedback as $row) : ?>
                    <form action="<?php include("url.php"); ?>dashboard/feedback/user?id=<?= $row["id"]; ?>&view=" method="post">
                      <button type="submit" name="read_feedback_user">
                        <input type="text" hidden name="id" value="<?= $row["id"]; ?>">
                        <input type="text" hidden name="status" value="">
                        <a href="<?php include("url.php"); ?>dashboard/feedback/user?id=<?= $row["id"]; ?>&view=" class="<?php if ($row["status"] === "1") : ?>unread-message<?php endif; ?>">
                          <div class="notif-img">
                            <img src="<?php include("url.php"); ?>assets/img/photo-profile/<?= $row["gambar"]; ?>" alt="Img Profile">
                          </div>
                          <div class="notif-content">
                            <span class="subject"><?= $row["first_name"]; ?> <?= $row["last_name"]; ?></span>
                            <span class="block">
                              <?= $row["description"]; ?>
                            </span>
                            <span class="time">
                              <?= $row["date"]; ?>, Pukul : <?= $row["time"]; ?>
                            </span>
                          </div>
                        </a>
                      </button>
                    </form>
                  <?php endforeach; ?>
                </div>
              </div>
            </li>
            <li>
              <div class="read-all-feedback-user">
                <form action="<?php include("url.php"); ?>dashboard/feedback/user" method="post">
                  <button type="submit" name="read_all_feedback_user">
                    <input type="text" hidden name="status_all" value="0">
                    <input type="text" hidden name="status" value="">
                    <a class="see-all">Lihat semua feedback<i class="fa fa-angle-right"></i> </a>
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- end Feedback -->
      <?php endif; ?>

      <?php if ($rowSession["level"] === $levelUser) : ?>
        <!-- Message -->
        <li class="nav-item dropdown hidden-caret">
          <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Pesan">
            <i class="fa fa-envelope"></i>
            <!-- check count Message -->
            <?php if (!empty($queryStatusMessage)) : ?>
              <span class="notification bg-danger"><?php echo "{$resultMessageUnread["jmlhMessageUnread"]}"; ?></span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
            <li>
              <div class="dropdown-title d-flex justify-content-between align-items-center">
                Pesan
                <?php if (!empty($queryStatusMessage)) : ?>
                  <span><?php echo "{$resultMessageUnread["jmlhMessageUnread"]}"; ?> Pesan belum dibaca</span>
                <?php endif; ?>
              </div>
            </li>
            <li>
              <div class="message-notif-scroll scrollbar-outer">
                <div class="notif-center card-feedback">
                  <?php foreach ($queryMessage as $row) : ?>
                    <form action="<?php include("url.php"); ?>dashboard/message/message?id=<?= $row["id"]; ?>&view=" method="post">
                      <button type="submit" name="read_message_user">
                        <input type="text" hidden name="id" value="<?= $row["id"]; ?>">
                        <input type="text" hidden name="status" value="">
                        <a href="<?php include("url.php"); ?>dashboard/message/message?id=<?= $row["id"]; ?>&view=" class="<?php if ($row["status"] === "1") : ?>unread-message<?php endif; ?>">
                          <div class="notif-img">
                            <img src="<?php include("url.php"); ?>assets/img/photo-profile/<?= $row["gambar"]; ?>" alt="Img Profile">
                          </div>
                          <div class="notif-content">
                            <span class="subject"><?= $row["first_name"]; ?> <?= $row["last_name"]; ?></span>
                            <span class="block"><?= $row["description"]; ?></span>
                            <span class="block">
                              <strong>Download File : <?= $row["file"]; ?></strong>
                            </span>
                            <span class="time">
                              <?= $row["date"]; ?>, Pukul : <?= $row["time"]; ?>
                            </span>
                          </div>
                        </a>
                      </button>
                    </form>
                  <?php endforeach; ?>
                </div>
              </div>
            </li>
            <li>
              <div class="read-all-feedback-user">
                <form action="<?php include("url.php"); ?>dashboard/message/message" method="post">
                  <button type="submit" name="read_all_message_user">
                    <input type="text" hidden name="status_all" value="0">
                    <input type="text" hidden name="status" value="">
                    <a class="see-all">Lihat semua pesan<i class="fa fa-angle-right"></i> </a>
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- end Message -->
      <?php endif; ?>

      <?php if ($rowSession["level"] === $levelUser) : ?>
        <!-- Feedback -->
        <li class="nav-item dropdown hidden-caret">
          <a class="nav-link dropdown-toggle" title="Feedback" href="#" id="messageDropdown" role="button" data-toggle="modal" data-target="#feedBack" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-comments"></i>
          </a>
        </li>
        <!-- end Feedback -->
      <?php endif; ?>


      <?php if ($rowSession["level"] === $levelKaban) : ?>
        <!-- Notification -->
        <li class="nav-item dropdown hidden-caret">
          <a class=" nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Notifikasi">
            <i class="fa fa-bell"></i>
            <!-- check count Notification -->
            <?php if (!empty($queryStatusNotification)) : ?>
              <span class="notification bg-danger">
                <?php
                echo
                "{$resultNotificationUnread["jmlhNotificationUnread"]}";
                ?>
              </span>
            <?php endif; ?>
          </a>
          <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
            <li>
              <div class="dropdown-title">Anda memiliki
                <?php
                echo
                "{$resultNotificationUnread["jmlhNotificationUnread"]}";
                ?>
                notifikasi baru</div>
            </li>
            <li>
              <div class="notif-scroll scrollbar-outer">
                <div class="notif-center card-feedback">

                  <?php if (!empty($queryNotification)) : ?>
                    <?php foreach ($queryNotification as $row) : ?>
                      <form action="<?php include("url.php"); ?>dashboard/notification/notification?id_notif=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($row["id_notif"]))))))); ?>&view=" method="post">

                        <button type="submit" name="read_notification">
                          <input type="text" hidden name="id_notif" value="<?= $row["id_notif"]; ?>">
                          <input type="text" hidden name="status_read" value="">

                          <a href="<?php include("url.php"); ?>dashboard/notification/notification?id_notif=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($row["id_notif"]))))))); ?>&view=" class="<?php if ($row["status_read"] === "1") : ?>unread-message<?php endif; ?>">

                            <?php if ($row["notif"] === "tsm") : ?>
                              <div class="notif-icon notif-success"> <i class="fa fa-envelope"> <sup class="fa fa-plus"></sup></i> </div>
                            <?php endif; ?>

                            <?php if ($row["notif"] === "tsk") : ?>
                              <div class="notif-icon notif-danger"> <i class="fa fa-envelope-open"> <sup class="fa fa-plus"></sup></i> </div>
                            <?php endif; ?>

                            <div class="notif-content">
                              <span class="block">
                                <?php if ($row["notif"] === "tsm") : ?>
                                  Surat Masuk Ditambahkan
                                <?php endif; ?>
                                <?php if ($row["notif"] === "tsk") : ?>
                                  Surat Keluar Ditambahkan
                                <?php endif; ?>
                              </span>
                              <span class="block">
                                No. Surat : <strong><?= $row["no_surat"]; ?></strong>
                              </span>
                              <span class="time">
                                <i class="fa fa-calendar"></i>
                                <?= tgl_indo_notif(date($row["date"])); ?>,
                                <i class="fa fa-clock"></i>
                                <?= substr($row["time"], 0, -3); ?>
                              </span>
                            </div>
                          </a>

                        </button>

                      </form>
                    <?php endforeach; ?>
                  <?php endif; ?>

                </div>
              </div>
            </li>
            <li>
              <div class="read-all-feedback-user">
                <form action="<?php include("url.php"); ?>dashboard/notification/notification" method="post">
                  <button type="submit" name="read_all_notification">
                    <input type="text" hidden name="status_read_all" value="0">
                    <input type="text" hidden name="status_read" value="">
                    <a class="see-all">Lihat semua notifikasi<i class="fa fa-angle-right"></i> </a>
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- end Notification -->
      <?php endif; ?>

      <?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
        <!-- shortcut -->
        <li class="nav-item dropdown hidden-caret">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="fas fa-layer-group"></i>
          </a>
          <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
            <div class="quick-actions-header">
              <span class="title mb-1">Opsi Cepat</span>
              <span class="subtitle op-8">Jalan pintas</span>
            </div>
            <div class="quick-actions-scroll scrollbar-outer">
              <div class="quick-actions-items">
                <div class="row m-0">
                  <a class="col-6 col-md-4 p-0" href="<?php include("url.php"); ?>dashboard/transaksi-surat/add-surat-masuk">
                    <div class="quick-actions-item">
                      <i class="flaticon-file"></i>
                      <span class="text">Tambah Surat Masuk</span>
                    </div>
                  </a>
                  <a class="col-6 col-md-4 p-0" href="<?php include("url.php"); ?>dashboard/transaksi-surat/add-surat-keluar">
                    <div class="quick-actions-item">
                      <i class="flaticon-file"></i>
                      <span class="text">Tambah Surat Keluar</span>
                    </div>
                  </a>
                  <a class="col-6 col-md-4 p-0" href="<?php include("url.php"); ?>dashboard/arsip-document/add-arsip">
                    <div class="quick-actions-item">
                      <i class="flaticon-file"></i>
                      <span class="text">Tambah Arsip Dokumen</span>
                    </div>
                  </a>
                  <a class="col-6 col-md-4 p-0" href="<?php include("url.php"); ?>dashboard/referensi/add-klasifikasi-surat">
                    <div class="quick-actions-item">
                      <i class="flaticon-file"></i>
                      <span class="text">Tambah Klasifikasi Surat</span>
                    </div>
                  </a>
                  <a class="col-6 col-md-4 p-0" href="<?php include("url.php"); ?>dashboard/settings/user">
                    <div class="quick-actions-item">
                      <i class="flaticon-user"></i>
                      <span class="text">Tambah Akun</span>
                    </div>
                  </a>
                  <a class="col-6 col-md-4 p-0" href="<?php include("url.php"); ?>dashboard/account-settings/account?id_account=<?= $rowSession["id"]; ?>">
                    <div class="quick-actions-item">
                      <i class="flaticon-pen"></i>
                      <span class="text">Ubah Profil</span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <!-- end shortcut -->
      <?php endif; ?>

      <?php if ($rowSession["level"] === $levelKaban || $rowSession["level"] === $levelUser) : ?>
        <!-- shortcut -->
        <li class="nav-item dropdown hidden-caret">
          <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <i class="fas fa-layer-group"></i>
          </a>
          <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
            <div class="quick-actions-header">
              <span class="title mb-1">Opsi Cepat</span>
              <span class="subtitle op-8">Jalan pintas</span>
            </div>
            <div class="quick-actions-scroll scrollbar-outer">
              <div class="quick-actions-items">
                <div class="row m-0">
                  <a class="col-6 col-md-4 p-0" href="<?php include("url.php"); ?>dashboard/account-settings/account?id_account=<?= $rowSession["id"]; ?>">
                    <div class="quick-actions-item">
                      <i class="flaticon-pen"></i>
                      <span class="text">Ubah Profil</span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <!-- end shortcut -->
      <?php endif; ?>


      <!-- profile -->
      <li class="nav-item dropdown hidden-caret">
        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
          <div class="avatar-sm">
            <img src="<?php include("url.php"); ?>assets/img/photo-profile/<?= $rowSession["gambar"]; ?>" alt="..." class="avatar-img rounded-circle">
          </div>
        </a>
        <ul class="dropdown-menu dropdown-user animated fadeIn">
          <div class="dropdown-user-scroll scrollbar-outer">
            <li>
              <div class="user-box">
                <div class="avatar-lg"><img src="<?php include("url.php"); ?>assets/img/photo-profile/<?= $rowSession["gambar"]; ?>" alt="image profile" class="avatar-img rounded"></div>
                <div class="u-text">
                  <h4><?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?></h4>
                  <p class="text-muted"><?= $rowSession["username"]; ?></p>
                  <a href="<?php include("url.php"); ?>dashboard/account-settings/account?id_account=<?= $rowSession["id"]; ?>" class="btn btn-xs btn-secondary btn-sm">Lihat Profil</a>
                </div>
              </div>
            </li>
            <li>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php include("url.php"); ?>dashboard/account-settings/account?id_account=<?= $rowSession["id"]; ?>">Pengaturan Akun</a>
              <div class="dropdown-divider"></div>
              <?php if ($rowSession["level"] === $levelSuperAdmin || $rowSession["level"] === $levelKaban) : ?>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Keluar</a>
              <?php endif; ?>

              <?php if ($rowSession["level"] === $levelUser) : ?>
                <?php if (empty($rowFeedbackUser)) : ?>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#feedBack">Keluar</a>
                <?php endif; ?>

                <?php if (!empty($rowFeedbackUser)) : ?>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Keluar</a>
                <?php endif; ?>
              <?php endif; ?>

            </li>
          </div>
        </ul>
      </li>
      <!-- end profile -->

    </ul>
  </div>
</nav>