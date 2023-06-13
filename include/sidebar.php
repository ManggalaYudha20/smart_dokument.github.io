<?php
// ERROR REPORTING
error_reporting(1);

// =================
// CEK MENU ACTIVE
// =================

// KONFIGURASI URL ACTIVE (ONLINE)
// $urlActive = "";

// KONFIGURASI URL ACTIVE (LOCAL)
$urlActive = "/arsip-baplitbang";

// GET URL
$url =  $_SERVER["REQUEST_URI"];

// Transaksi Surat
$idSuratMasukActive = $_GET["id_surat_masuk"];
$idSuratKeluarActive = $_GET["id_surat_keluar"];
$idEditDisposisiActive = $_GET["id_disp_surat"];

// Buku Agenda
$idAgendaSuratFromTglActive = $_GET["dari"];
$idAgendaSuratToTglActive = $_GET["ke"];
$idAgendaSuratArsipActive = $_GET["ket_nasib_akhir"];

// Arsip Dokumen
$idEditArsipActive = $_GET["id_arsip"];
$idEditUserActive = $_GET["id_user"];

// referensi
$idEditKlasifikasiActive = $_GET["id_klasifikasi"];

// MENU ACTIVE DASHBOARD
if ($url === "$urlActive/dashboard/") {
  $activeDashboard = "active";
}

// MENU ACTIVE BUKU AGENDA
if (

  // surat masuk
  $url === "$urlActive/dashboard/buku-agenda/surat-masuk" or
  $url === "$urlActive/dashboard/buku-agenda/surat-masuk?dari=$idAgendaSuratFromTglActive&ke=$idAgendaSuratToTglActive&filter=" or

  // surat keluar
  $url === "$urlActive/dashboard/buku-agenda/surat-keluar" or
  $url === "$urlActive/dashboard/buku-agenda/surat-keluar?dari=$idAgendaSuratFromTglActive&ke=$idAgendaSuratToTglActive&filter=" or

  // klasifikasi surat
  $url === "$urlActive/dashboard/buku-agenda/klasifikasi-surat" or
  $url === "$urlActive/dashboard/buku-agenda/klasifikasi-surat?dari=$idAgendaSuratFromTglActive&ke=$idAgendaSuratToTglActive&filter=" or

  // arsip
  $url === "$urlActive/dashboard/buku-agenda/arsip" or
  $url === "$urlActive/dashboard/buku-agenda/arsip?ket_nasib_akhir=$idAgendaSuratArsipActive&filter="

) {
  $activeBukuAgenda = "active";
}

// MENU ACTIVE TRANSAKSI SURAT
if (
  $url === "$urlActive/dashboard/transaksi-surat/surat-masuk" or
  $url === "$urlActive/dashboard/transaksi-surat/add-surat-masuk" or
  $url === "$urlActive/dashboard/transaksi-surat/edit-surat-masuk?id_surat_masuk=$idSuratMasukActive" or
  $url === "$urlActive/dashboard/transaksi-surat/disposisi-surat?id_surat_masuk=$idSuratMasukActive" or
  $url === "$urlActive/dashboard/transaksi-surat/add-disposisi?id_surat_masuk=$idSuratMasukActive" or
  $url === "$urlActive/dashboard/transaksi-surat/edit-disposisi?id_disp_surat=$idEditDisposisiActive" or
  $url === "$urlActive/dashboard/transaksi-surat/surat-keluar" or
  $url === "$urlActive/dashboard/transaksi-surat/add-surat-keluar" or
  $url === "$urlActive/dashboard/transaksi-surat/edit-surat-keluar?id_surat_keluar=$idSuratKeluarActive"
) {
  $activeTransaksiSurat = "active";
}

// MENU ACTIVE ARSIP DOKUMEN
if (
  $url === "$urlActive/dashboard/arsip-document/arsip" or
  $url === "$urlActive/dashboard/arsip-document/add-arsip" or
  $url === "$urlActive/dashboard/arsip-document/edit-arsip?id_arsip=$idEditArsipActive"
) {
  $activeArsip = "active";
}

// MENU ACTIVE REFERENSI
if (
  $url === "$urlActive/dashboard/referensi/klasifikasi-surat" or
  $url === "$urlActive/dashboard/referensi/add-klasifikasi-surat" or
  $url === "$urlActive/dashboard/referensi/edit-klasifikasi-surat?id_klasifikasi=$idEditKlasifikasiActive"
) {
  $activeReferensi = "active";
}


// MENU ACTIVE SETTINGS
if (
  $url === "$urlActive/dashboard/settings/user" or
  $url === "$urlActive/dashboard/settings/add-user" or
  $url === "$urlActive/dashboard/settings/edit-user?id_user=$idEditUserActive"
) {
  $activeSettings = "active";
}

?>
<div class="sidebar sidebar-style-2">
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          <img src="<?php include("url.php"); ?>assets/img/photo-profile/<?= $rowSession["gambar"]; ?>" alt="..." class="avatar-img rounded-circle">
        </div>
        <div class="info">
          <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
            <span>
              <?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?>
              <span class="user-level">
                <?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
                  Super Admin
                <?php endif; ?>

                <?php if ($rowSession["level"] === $levelKaban) : ?>
                  Kepala Bappeda
                <?php endif; ?>

                <?php if ($rowSession["level"] === $levelUser) : ?>
                  User
                <?php endif; ?>
              </span>
              <span class="caret"></span>
            </span>
          </a>
          <div class="clearfix"></div>

          <div class="collapse in" id="collapseExample">
            <ul class="nav">
              <li>
                <a href="<?php include("url.php"); ?>dashboard/account-settings/account?id_account=<?= $rowSession["id"]; ?>">
                  <span class="link-collapse">Profil Saya</span>
                </a>
              </li>
              <li>
                <a href="<?php include("url.php"); ?>dashboard/account-settings/account?id_account=<?= $rowSession["id"]; ?>">
                  <span class="link-collapse">Edit Profil</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <ul class="nav nav-primary">
        <li class="nav-item <?= $activeDashboard; ?>">
          <a href="<?php include("url.php"); ?>dashboard/" class="collapsed">
            <i class="fas fa-home"></i>
            <p>Dasbor</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Komponen</h4>
        </li>
        <li class="nav-item <?= $activeTransaksiSurat; ?>">
          <a data-toggle="collapse" href="#transaksi-surat">
            <i class="fas fa-envelope"></i>
            <p>Transaksi Surat</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="transaksi-surat">
            <ul class="nav nav-collapse">
              <li>
                <a href="<?php include("url.php"); ?>dashboard/transaksi-surat/surat-masuk">
                  <span class="sub-item">Surat Masuk</span>
                </a>
              </li>
              <li>
                <a href="<?php include("url.php"); ?>dashboard/transaksi-surat/surat-keluar">
                  <span class="sub-item">Surat Keluar</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <?php if ($rowSession["level"] !== "user") : ?>
          <li class="nav-item <?= $activeBukuAgenda; ?>">
            <a data-toggle="collapse" href="#buku-agenda">
              <i class="fas fa-book"></i>
              <p>Buku Agenda</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="buku-agenda">
              <ul class="nav nav-collapse">
                <li>
                  <a href="<?php include("url.php"); ?>dashboard/buku-agenda/surat-masuk">
                    <span class="sub-item">Surat Masuk</span>
                  </a>
                </li>
                <li>
                  <a href="<?php include("url.php"); ?>dashboard/buku-agenda/surat-keluar">
                    <span class="sub-item">Surat Keluar</span>
                  </a>
                </li>
                <li>
                  <a href="<?php include("url.php"); ?>dashboard/buku-agenda/klasifikasi-surat">
                    <span class="sub-item">Klasifikasi Surat</span>
                  </a>
                </li>
                <li>
                  <a href="<?php include("url.php"); ?>dashboard/buku-agenda/arsip">
                    <span class="sub-item">Arsip Dokumen</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        <?php endif; ?>

        <li class="nav-item <?= $activeArsip; ?>">
          <a href="<?php include("url.php"); ?>dashboard/arsip-document/arsip">
            <i class="fas fa-archive"></i>
            <p>Arsip Dokumen</p>
          </a>
        </li>
        <li class="nav-item <?= $activeReferensi; ?>">
          <a href="<?php include("url.php"); ?>dashboard/referensi/klasifikasi-surat">
            <i class="fas fa-book"></i>
            <p>Referensi</p>
          </a>
        </li>
        <?php if ($rowSession["level"] === $levelSuperAdmin) : ?>
          <li class="nav-item <?= $activeSettings; ?>">
            <a data-toggle="collapse" href="#pengaturan">
              <i class="fas fa-cog"></i>
              <p>Pengaturan</p>
              <span class="caret"></span>
            </a>
            <div class="collapse" id="pengaturan">
              <ul class="nav nav-collapse">
                <li>
                  <a href="<?php include("url.php"); ?>dashboard/settings/user">
                    <span class="sub-item">Akun Pengguna</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        <?php endif; ?>
        <li class="nav-item">

          <?php if ($rowSession["level"] === $levelSuperAdmin || $rowSession["level"] === $levelKaban) : ?>
            <a href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fa fa-sign-out-alt"></i>
              <p>Keluar</p>
            </a>
          <?php endif; ?>

          <?php if ($rowSession["level"] === $levelUser) : ?>
            <?php if (empty($rowFeedbackUser)) : ?>
              <a href="#" data-toggle="modal" data-target="#feedBack">
                <i class="fa fa-sign-out-alt"></i>
                <p>Keluar</p>
              </a>
            <?php endif; ?>

            <?php if (!empty($rowFeedbackUser)) : ?>
              <a href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fa fa-sign-out-alt"></i>
                <p>Keluar</p>
              </a>
            <?php endif; ?>
          <?php endif; ?>

        </li>
      </ul>
    </div>
  </div>
</div>