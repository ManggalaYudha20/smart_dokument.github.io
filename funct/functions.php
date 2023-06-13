<?php
// KONEKSI DATABASE
$host = "localhost";
$username = "id20872943_arsip_document";
$password = "root";
$database = "id20872943_arsip_document";

$conn = mysqli_connect($host, $username, $password, $database);

// ===============
// FUNCTION QUERY
// ===============
function query($query)
{
  global $conn;

  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

// =================
// FUNCTION REGISTER
// =================
function register($data)
{
  global $conn;

  $firstName = htmlspecialchars($data["first_name"]);
  $lastName = htmlspecialchars($data["last_name"]);
  $username = stripslashes(strtolower($data["username"]));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);
  $level = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["level"]))))))))));

  // CEK MANIPULASI LEVEL AKUN
  if (!base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["level"])))))))))) {
    echo "
    <script>
      alert('Periksa kembali data-data anda!');   
      document.location.href = 'register'; 
    </script>
    ";
    return false;
  }

  // CEK MANIPULASI NAMA DEPAN
  if (empty($firstName)) {
    echo "
    <script>
      alert('Nama depan tidak boleh kosong!');   
      document.location.href = 'register'; 
    </script>
    ";
    return false;
  }

  // CEK MANIPULASI USERNAME / NAMA PENGGUNA
  if (empty($username)) {
    echo "
    <script>
      alert('Nama pengguna atau alamat email tidak boleh kosong!');   
      document.location.href = 'register'; 
    </script>
    ";
    return false;
  }

  // CEK MANIPULASI KATA SANDI
  if (empty($password)) {
    echo "
    <script>
      alert('Kata sandi tidak boleh kosong!');   
      document.location.href = 'register'; 
    </script>
    ";
    return false;
  }
  if (strlen($password) < 8) {
    echo "
    <script>
      alert('Untuk menjaga keamanan akun anda, gunakan minimal 8 karakter kata sandi!');   
      document.location.href = 'register'; 
    </script>
    ";
    return false;
  }

  // CEK MANIPULASI LEVEL AKUN
  if (empty($level)) {
    echo "
    <script>
      alert('Pendaftaran akun gagal!');   
      document.location.href = 'register'; 
    </script>
    ";
    return false;
  }


  // CEK DOUBLE USERNAME
  $result = mysqli_query($conn, "SELECT username FROM tb_users WHERE username = '$username' ");
  if (mysqli_fetch_assoc($result)) {
    echo "
    <script>
      alert('Nama pengguna atau alamat email ini sudah terdaftar. Silahkan gunakan yang lain!');   
      document.location.href = 'register'; 
    </script>
    ";
    return false;
  }

  // CEK KONFIRMASI KATA SANDI
  if ($password !== $password2) {
    echo "
    <script>
      alert('Konfirmasi kata sandi tidak sesuai!');   
      document.location.href = 'register'; 
    </script>
    ";
    return false;
  }

  // ENKRIPSI KATA SANDI
  $password = password_hash($password, PASSWORD_DEFAULT);

  // INSERT DATA
  $query = "INSERT INTO tb_users VALUES(null, '$firstName', '$lastName', '$username', '$password', '$password2', '$level')";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// =================================================
// FUNCTION SURAT MASUK
// =================================================
// TAMBAH DATA SURAT MASUK
function tambahDataSuratMasuk($data)
{
  global $conn;

  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $noAgenda = htmlspecialchars($data["no_agenda"]);
  $kodeKlasifikasi = htmlspecialchars($data["kode_klasifikasi"]);
  $asalSurat = htmlspecialchars($data["asal_surat"]);
  $indeks = htmlspecialchars($data["indeks"]);
  $noSurat = htmlspecialchars($data["no_surat"]);
  $isi = htmlspecialchars($data["isi"]);
  $tglDiterima = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["tgl_diterima"]))))))))));
  $tglSurat = htmlspecialchars($data["tgl_surat"]);
  $keterangan = htmlspecialchars($data["keterangan"]);

  $file = uploadFileMasuk();
  if (!$file) {
    return false;
  }

  $statusRead = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_read"]))))))))));
  $statusReadAll = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_read_all"]))))))))));
  $date = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["date"]))))))))));
  $time = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["time"]))))))))));

  $notif = htmlspecialchars($data["notif"]);

  $query1 = "INSERT INTO tb_surat_masuk VALUES(null, '$idUser', '$noAgenda', '$kodeKlasifikasi', '$asalSurat', '$indeks', '$noSurat', '$isi', '$tglDiterima', '$tglSurat', '$keterangan', '$file') ";

  $query2 = "INSERT INTO tb_notification VALUES(null, '$notif', '$noSurat', '$statusRead', '$statusReadAll', '$date', '$time') ";

  mysqli_query($conn, $query1);
  mysqli_query($conn, $query2);
  return mysqli_affected_rows($conn);
}


// EDIT/UBAH DATA SURAT MASUK
function editDataSuratMasuk($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $noAgenda = htmlspecialchars($data["no_agenda"]);
  $kodeKlasifikasi = htmlspecialchars($data["kode_klasifikasi"]);
  $asalSurat = htmlspecialchars($data["asal_surat"]);
  $indeks = htmlspecialchars($data["indeks"]);
  $noSurat = htmlspecialchars($data["no_surat"]);
  $tglSurat = htmlspecialchars($data["tgl_surat"]);
  $tglDiterima = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["tgl_diterima"]))))))))));
  $isi = htmlspecialchars($data["isi"]);
  $keterangan = htmlspecialchars($data["keterangan"]);

  $fileLama = htmlspecialchars($data["file_lama"]);

  if ($_FILES['file']['error'] === 4) {
    $file = $fileLama;
  } else {
    $file = uploadFileMasuk();
  }

  $query = "UPDATE tb_surat_masuk SET
  id_user = '$idUser', 
  no_agenda = '$noAgenda', 
  kode_klasifikasi = '$kodeKlasifikasi', 
  asal_surat = '$asalSurat', 
  indeks = '$indeks', 
  no_surat = '$noSurat', 
  tgl_surat = '$tglSurat', 
  tgl_diterima = '$tglDiterima', 
  isi = '$isi', 
  keterangan = '$keterangan', 
  file = '$file'
  WHERE id = '$id' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION UPLOAD FILE SURAT MASUK
function uploadFileMasuk()
{

  $namaFile = $_FILES['file']['name'];
  $ukuranFile = $_FILES['file']['size'];
  $error = $_FILES['file']['error'];
  $tmpName = $_FILES['file']['tmp_name'];

  // cek apakah ada file yang diupload atau tidak
  if ($error === 4) {
    echo "
		<script>
			alert('Pilih file terlebih dahulu');
      document.location.href = 'register';
		</script>";
    return false;
  }

  // cek apakah yang diupload adalah file
  $ekstensiFileValid = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if (!in_array($ekstensiFile, $ekstensiFileValid)) {
    echo "
		<script>
			alert('Yang anda upload bukan format file yang diminta');
      document.location.href = '';
		</script>";
    return false;
  }

  // cek ukuran file file yang diupload
  if ($ukuranFile > 5000000) {
    echo "
		<script>
			alert('Ukuran file terlalu besar');
      document.location.href = '';
		</script>";
    return false;
  }

  // lolos pengecekan, file siap di upload
  // generate nama file baru
  $namaFileBaru = uniqid($namaFile . '_');
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiFile;

  move_uploaded_file($tmpName, '../../uploads/surat-masuk/' . $namaFileBaru);
  return $namaFileBaru;
}


// FUNCTION DELETE/HAPUS DATA SURAT MASUK
function deleteSuratMasuk($id)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM tb_surat_masuk WHERE id = '$id' ");
  return mysqli_affected_rows($conn);
}



// =================================================
// FUNCTION SURAT KELUAR
// =================================================
// TAMBAH DATA SURAT KELUAR
function tambahDataSuratKeluar($data)
{
  global $conn;

  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $noAgenda = htmlspecialchars($data["no_agenda"]);
  $kodeKlasifikasi = htmlspecialchars($data["kode_klasifikasi"]);
  $tujuanSurat = htmlspecialchars($data["tujuan_surat"]);
  $noSurat = htmlspecialchars($data["no_surat"]);
  $keterangan = htmlspecialchars($data["keterangan"]);
  $isi = htmlspecialchars($data["isi"]);
  $tglDiterima = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["tgl_diterima"]))))))))));
  $tglSurat = htmlspecialchars($data["tgl_surat"]);

  $file = uploadFileKeluar();
  if (!$file) {
    return false;
  }

  $statusRead = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_read"]))))))))));
  $statusReadAll = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_read_all"]))))))))));
  $date = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["date"]))))))))));
  $time = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["time"]))))))))));

  $notif = htmlspecialchars($data["notif"]);

  $query1 = "INSERT INTO tb_surat_keluar VALUES(null, '$idUser', '$noAgenda', '$kodeKlasifikasi', '$tujuanSurat',  '$noSurat', '$keterangan',  '$isi', '$tglDiterima', '$tglSurat',  '$file') ";

  $query2 = "INSERT INTO tb_notification VALUES(null, '$notif', '$noSurat', '$statusRead', '$statusReadAll', '$date', '$time') ";

  mysqli_query($conn, $query1);
  mysqli_query($conn, $query2);
  return mysqli_affected_rows($conn);
}


// EDIT/UBAH DATA SURAT KELUAR
function editDataSuratKeluar($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $noAgenda = htmlspecialchars($data["no_agenda"]);
  $kodeKlasifikasi = htmlspecialchars($data["kode_klasifikasi"]);
  $tujuanSurat = htmlspecialchars($data["tujuan_surat"]);
  $noSurat = htmlspecialchars($data["no_surat"]);
  $keterangan = htmlspecialchars($data["keterangan"]);
  $isi = htmlspecialchars($data["isi"]);
  $tglDiterima = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["tgl_diterima"]))))))))));
  $tglSurat = htmlspecialchars($data["tgl_surat"]);

  $fileLama = htmlspecialchars($data["file_lama"]);

  if ($_FILES['file']['error'] === 4) {
    $file = $fileLama;
  } else {
    $file = uploadFileKeluar();
  }

  $statusRead = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_read"]))))))))));
  $statusReadAll = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_read_all"]))))))))));
  $date = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["date"]))))))))));
  $time = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["time"]))))))))));

  $query = "UPDATE tb_surat_keluar SET
  id_user = '$idUser', 
  no_agenda = '$noAgenda', 
  kode_klasifikasi = '$kodeKlasifikasi', 
  tujuan_surat = '$tujuanSurat', 
  no_surat = '$noSurat', 
  keterangan = '$keterangan', 
  isi = '$isi', 
  tgl_diterima = '$tglDiterima', 
  tgl_surat = '$tglSurat', 
  file = '$file',
  status_read = '$statusRead',
  status_read_all = '$statusReadAll',
  date = '$date',
  time = '$time'
  WHERE id = '$id' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION UPLOAD FILE SURAT KELUAR
function uploadFileKeluar()
{

  $namaFile = $_FILES['file']['name'];
  $ukuranFile = $_FILES['file']['size'];
  $error = $_FILES['file']['error'];
  $tmpName = $_FILES['file']['tmp_name'];

  // cek apakah ada file yang diupload atau tidak
  if ($error === 4) {
    echo "
		<script>
			alert('Pilih file terlebih dahulu');
      document.location.href = 'register';
		</script>";
    return false;
  }

  // cek apakah yang diupload adalah file
  $ekstensiFileValid = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if (!in_array($ekstensiFile, $ekstensiFileValid)) {
    echo "
		<script>
			alert('Yang anda upload bukan format file yang diminta');
      document.location.href = '';
		</script>";
    return false;
  }

  // cek ukuran file file yang diupload
  if ($ukuranFile > 2000000) {
    echo "
		<script>
			alert('Ukuran file terlalu besar');
      document.location.href = '';
		</script>";
    return false;
  }

  // lolos pengecekan, file siap di upload
  // generate nama file baru
  $namaFileBaru = uniqid($namaFile . '_');
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiFile;

  move_uploaded_file($tmpName, '../../uploads/surat-keluar/' . $namaFileBaru);
  return $namaFileBaru;
}

// FUNCTION DELETE/HAPUS DATA SURAT KELUAR
function deleteSuratKeluar($id)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM tb_surat_keluar WHERE id = '$id' ");
  return mysqli_affected_rows($conn);
}



// FUNCTION TAMBAH DATA DISPOSISI SURAT
function tambahDataDisposisiSurat($data)
{
  global $conn;

  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $idSurat = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_surat"]))))))))));
  $tujuanDisposisi = htmlspecialchars($data["tujuan_disposisi"]);
  $isiDisposisi = htmlspecialchars($data["isi_disposisi"]);
  $batasWaktu = htmlspecialchars($data["batas_waktu"]);
  $sifat = htmlspecialchars($data["sifat"]);
  $catatan = htmlspecialchars($data["catatan"]);

  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($idUser)))))))))) {
    echo "
    <script>
      alert('Data gagal ditambahkan!');
      document.location.href = '';
    </script>";
    return false;
  }

  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($idSurat)))))))))) {
    echo "
    <script>
      alert('Data gagal ditambahkan!');
      document.location.href = '';
    </script>";
    return false;
  }

  $query = "INSERT INTO tb_disposisi VALUES(null, '$idUser', '$idSurat', '$tujuanDisposisi', '$isiDisposisi', '$batasWaktu', '$sifat', '$catatan' ) ";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// FUNCTION TAMBAH DATA DISPOSISI SURAT
function editDataDisposisiSurat($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $idSurat = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_surat"]))))))))));
  $tujuanDisposisi = htmlspecialchars($data["tujuan_disposisi"]);
  $isiDisposisi = htmlspecialchars($data["isi_disposisi"]);
  $batasWaktu = htmlspecialchars($data["batas_waktu"]);
  $sifat = htmlspecialchars($data["sifat"]);
  $catatan = htmlspecialchars($data["catatan"]);

  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($idUser)))))))))) {
    echo "
    <script>
      alert('Data gagal ditambahkan!');
      document.location.href = '';
    </script>";
    return false;
  }

  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($idSurat)))))))))) {
    echo "
    <script>
      alert('Data gagal ditambahkan!');
      document.location.href = '';
    </script>";
    return false;
  }

  $query = "UPDATE tb_disposisi SET
  id_user = '$idUser', 
  id_surat = '$idSurat', 
  tujuan_disposisi = '$tujuanDisposisi', 
  isi_disposisi = '$isiDisposisi', 
  batas_waktu = '$batasWaktu', 
  sifat = '$sifat',
  catatan = '$catatan'
  WHERE id = '$id' ";
  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION DELETE/HAPUS DATA SURAT DISPOSISI
function deleteSuratDisposisi($idSuratDisposisi)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM tb_disposisi WHERE id = '$idSuratDisposisi' ");
  return mysqli_affected_rows($conn);
}


// =================================================
// FUNCTION KLASIFIKASI SURAT
// =================================================
// TAMBAH DATA SURAT MASUK
function tambahDataKlasifikasiSurat($data)
{
  global $conn;

  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $kode = htmlspecialchars($data["kode"]);
  $nama = htmlspecialchars($data["nama"]);
  $uraian = htmlspecialchars($data["uraian"]);
  $tglDiterima = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["tgl_diterima"]))))))))));

  $query = "INSERT INTO tb_klasifikasi VALUES(null, '$idUser', '$kode', '$nama', '$uraian', '$tglDiterima') ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// TAMBAH DATA SURAT MASUK
function editDataKlasifikasiSurat($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $kode = htmlspecialchars($data["kode"]);
  $nama = htmlspecialchars($data["nama"]);
  $uraian = htmlspecialchars($data["uraian"]);
  $tglDiterima = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["tgl_diterima"]))))))))));

  $query = "UPDATE tb_klasifikasi SET
  id_user = '$idUser', 
  kode = '$kode', 
  nama = '$nama', 
  uraian = '$uraian',
  tgl_diterima = $tglDiterima
  WHERE id = '$id' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}
// FUNCTION DELETE/HAPUS DATA KLASIFIKASI SURAT
function deleteKlasifikasiSurat($idKlasifikasiSurat)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM tb_klasifikasi WHERE id = '$idKlasifikasiSurat' ");
  return mysqli_affected_rows($conn);
}


// =================================================
// FUNCTION ACCOUNT SUPER ADMIN, KEPALA BADAN, USER
// =================================================
// FUNCTION TAMBAH ACCOUNT
function addAccount($data)
{
  global $conn;

  $gambar = uploadPhotoProfile();
  if (!$gambar) {
    return false;
  }

  $firstName = htmlspecialchars($data["first_name"]);
  $lastName = htmlspecialchars($data["last_name"]);
  $username = strtolower(stripslashes($data["username"]));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);
  $level = mysqli_real_escape_string($conn, $data["level"]);

  // check empty data
  if (empty($firstName)) {
    echo "
    <script>
      alert('Nama tidak boleh kosong!');
    </script>
    ";
    return false;
  }

  // check empty data
  if (empty($username)) {
    echo "
    <script>
      alert('Nama tidak boleh kosong!');
    </script>
    ";
    return false;
  }

  // check empty data
  if (empty($password)) {
    echo "
    <script>
      alert('Nama tidak boleh kosong!');
    </script>
    ";
    return false;
  }

  // check empty data
  if (empty($level)) {
    echo "
    <script>
      alert('Nama tidak boleh kosong!');
    </script>
    ";
    return false;
  }

  // check double username
  $result = mysqli_query($conn, "SELECT username FROM tb_users WHERE username = '$username' ");
  if (mysqli_fetch_assoc($result)) {
    echo "
    <script>
      alert('Nama pengguna ini sudah di ada. Silahkan gunakan nama pengguna yang lain');
    </script>
    ";
    return false;
  }

  // check confirmation password
  if ($password !== $password2) {
    echo "
    <script>
      alert('Konfirmasi kata sandi tidak sesuai!');
    </script>
    ";
    return false;
  }

  // enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  // query
  $query = "INSERT INTO tb_users VALUES(null, '$gambar', '$firstName', '$lastName', '$username', '$password', '$password2', '$level') ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// =================================================
// FUNCTION EDIT ACCOUNT
// =================================================
// FUNCTION EDIT FOTO PROFIL
function editPhotoProfile($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $imgOld = htmlspecialchars($data["img_old"]);

  if ($_FILES['gambar']['error'] === 4) {
    $gambar = $imgOld;
  } else {
    $gambar = uploadPhotoProfile();
  }


  $query = "UPDATE tb_users SET 
  gambar = '$gambar'
  WHERE id = '$id'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION UPLOAD FOTO PROFIL
function uploadPhotoProfile()
{
  $namaFile = $_FILES['gambar']['name'];
  $ukuranFile = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmpName = $_FILES['gambar']['tmp_name'];

  // cek apakah ada gambar yang diupload atau tidak
  if ($error === 4) {
    echo "
		<script>
			alert('Pilih gambar terlebih dahulu');
      document.location.href = '';
		</script>";
    return false;
  }

  // cek apakah yang diupload adalah gambar
  $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = explode('.', $namaFile);
  $ekstensiGambar = strtolower(end($ekstensiGambar));
  if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
    echo "
		<script>
			alert('Yang anda upload bukan gambar');
      document.location.href = '';
		</script>";
    return false;
  }

  // cek ukuran file gambar yang diupload
  if ($ukuranFile > 5000000) {
    echo "
		<script>
			alert('Ukuran gambar terlalu besar');
      document.location.href = '';
		</script>";
    return false;
  }

  // lolos pengecekan, gambar siap di upload
  // generate nama gambar baru
  $namaFileBaru = uniqid($namaFile . '_');
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiGambar;

  move_uploaded_file($tmpName, '../../assets/img/photo-profile/' . $namaFileBaru);
  return $namaFileBaru;
}


// FUNCTION EDIT NAMA 
function editName($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $firstName = htmlspecialchars($data["first_name"]);
  $lastName = htmlspecialchars($data["last_name"]);

  $query = "UPDATE tb_users SET 
  first_name = '$firstName',
  last_name = '$lastName'
  WHERE id = '$id'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION EDIT NAMA PENGGUNA 
function editUsername($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $username = htmlspecialchars($data["username"]);

  $result = mysqli_query($conn, "SELECT username FROM tb_users WHERE username = '$username' ");
  if (mysqli_fetch_assoc($result)) {
    echo "
    <script>
      alert('Nama pengguna ini sudah digunakan. Silahkan gunakan nama pengguna yang lain!');
    </script>
    ";
    return false;
  }

  $query = "UPDATE tb_users SET 
  username = '$username'
  WHERE id = '$id'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION EDIT NAMA PENGGUNA 
function editPassword($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);

  if ($password !== $password2) {
    echo "
    <script>
      alert('Konfirmasi kata sandi tidak sesuai!');
    </script>
    ";
    return false;
  }

  $password = password_hash($password, PASSWORD_DEFAULT);

  $query = "UPDATE tb_users SET 
  password = '$password',
  password2 = '$password2'
  WHERE id = '$id'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION LEVEL ACCOUNT 
function editLevel($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $levelAccount = htmlspecialchars($data["level"]);

  $query = "UPDATE tb_users SET 
  level = '$levelAccount'
  WHERE id = '$id'";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// FUNCTION DELETE ACCOUNT
function deleteAccount($idAccount)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM tb_users WHERE id = '$idAccount' ");
  return mysqli_affected_rows($conn);
}



// =================================================
// FUNCTION MESSAGE
// =================================================
// FUNCTION SEND MESSAGE
function sendMessage($data)
{
  global $conn;

  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $gambar = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["gambar"]))))))))));
  $firstName = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["first_name"]))))))))));
  $lastName = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["last_name"]))))))))));
  $description = htmlspecialchars($data["description"]);

  $file = uploadFileMessage();
  if (!$file) {
    return false;
  }

  $date = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["date"]))))))))));
  $time = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["time"]))))))))));
  $status = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status"]))))))))));
  $statusAll = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_all"]))))))))));
  $statusUpdate = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_update"]))))))))));

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($idUser)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($gambar)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($firstName)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($date)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($time)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($status)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($statusAll)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($statusUpdate)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($lastName)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // query
  $query = "INSERT INTO tb_message VALUES(null, '$idUser', '$gambar', '$firstName', '$lastName', '$description', '$file', '$date', '$time', '$status', '$statusAll', '$statusUpdate') ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION UPLOAD FILE MESSAGE
function uploadFileMessage()
{
  $namaFile = $_FILES['file']['name'];
  $ukuranFile = $_FILES['file']['size'];
  $tmpName = $_FILES['file']['tmp_name'];

  // cek apakah yang diupload adalah format file yang telah ditentukan
  $ekstensiFileValid = ['jpg', 'jpeg', 'png', 'docx', 'doc', 'pdf'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if (!in_array($ekstensiFile, $ekstensiFileValid)) {
    echo "
		<script>
			alert('Yang anda upload bukan format file yang diminta');
      document.location.href = '';
		</script>";
    return false;
  }

  // cek ukuran file  yang diupload
  if ($ukuranFile > 5000000) {
    echo "
		<script>
			alert('Ukuran file terlalu besar');
      document.location.href = '';
		</script>";
    return false;
  }

  // lolos pengecekan, file siap di upload
  // generate nama file baru
  $namaFileBaru = uniqid($namaFile . '_');
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiFile;

  move_uploaded_file($tmpName, '../../uploads/message/' . $namaFileBaru);
  return $namaFileBaru;
}


// FUNCTION READ MESSAGE 
function readMessage($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $status = htmlspecialchars($data["status"]);

  $query = "UPDATE tb_message SET
  status = '$status' 
  WHERE id = '$id' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION READ ALL MESSAGE
function readAllMessage($data)
{
  global $conn;

  $statusAll = htmlspecialchars($data["status_all"]);
  $status = htmlspecialchars($data["status"]);

  $query = "UPDATE tb_message SET
  status = '$status' 
  WHERE status_all = '$statusAll' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION SEARCH/VIEW MESSAGE
function viewMessage($id)
{
  $query = "SELECT * FROM tb_message WHERE
  id = '$id'
  ";
  return query($query);
}

// FUNCTION DELETE MESSAGE
function deleteMessage($idMessage)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM tb_message WHERE id = '$idMessage' ");
  return mysqli_affected_rows($conn);
}


// =================================================
// FUNCTION FEEDBACK
// =================================================
// FUNCTION READ FEEDBACK USER
function readFeedBackUser($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $status = htmlspecialchars($data["status"]);

  $query = "UPDATE tb_feedback SET
  status = '$status' 
  WHERE id = '$id' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION READ ALL FEEDBACK USER
function readAllFeedBackUser($data)
{
  global $conn;

  $statusAll = htmlspecialchars($data["status_all"]);
  $status = htmlspecialchars($data["status"]);

  $query = "UPDATE tb_feedback SET
  status = '$status' 
  WHERE status_all = '$statusAll' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION SEND FEEDBACK
function sendFeedback($data)
{
  global $conn;

  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $gambar = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["gambar"]))))))))));
  $firstName = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["first_name"]))))))))));
  $lastName = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["last_name"]))))))))));
  $phone = htmlspecialchars($data["phone"]);
  $email = htmlspecialchars($data["email"]);
  $description = htmlspecialchars($data["description"]);
  $response = htmlspecialchars($data["response"]);
  $date = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["date"]))))))))));
  $time = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["time"]))))))))));
  $status = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status"]))))))))));
  $statusAll = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_all"]))))))))));
  $statusUpdate = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_update"]))))))))));

  // Check double feedback
  $result = mysqli_query($conn, "SELECT id_user FROM tb_feedback WHERE id_user = '$idUser' ");
  if (mysqli_fetch_assoc($result)) {
    echo "
    <script>
      alert('Kamu sudah memberikan feedback sebelumnya!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($idUser)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($gambar)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($firstName)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($date)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($time)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($status)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($statusAll)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($statusUpdate)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($lastName)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // query
  $query = "INSERT INTO tb_feedback VALUES(null, '$idUser', '$gambar', '$firstName', '$lastName', '$phone', '$email', '$description', '$response', '$date', '$time', '$status', '$statusAll', '$statusUpdate') ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// FUNCTION UPDATE FEEDBACK
function updateFeedback($data)
{
  global $conn;

  $id = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id"]))))))))));
  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $gambar = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["gambar"]))))))))));
  $firstName = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["first_name"]))))))))));
  $lastName = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["last_name"]))))))))));
  $phone = htmlspecialchars($data["phone"]);
  $email = htmlspecialchars($data["email"]);
  $description = htmlspecialchars($data["description"]);
  $response = htmlspecialchars($data["response"]);
  $date = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["date"]))))))))));
  $time = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["time"]))))))))));
  $status = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status"]))))))))));
  $statusAll = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_all"]))))))))));
  $statusUpdate = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["status_update"]))))))))));

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($id)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($idUser)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($gambar)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($firstName)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($date)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($time)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($status)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($statusAll)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($statusUpdate)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // check manipulation url
  if (base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($lastName)))))))))) {
    echo "
    <script>
      alert('Gagal!');
      document.location.href = '';
    </script>
    ";
    return false;
  }

  // query
  $query = "UPDATE tb_feedback SET
  id_user = '$idUser', 
  gambar = '$gambar', 
  first_name = '$firstName', 
  last_name = '$lastName', 
  phone = '$phone', 
  email = '$email', 
  description = '$description', 
  response = '$response', 
  date = '$date', 
  time = '$time', 
  status = '$status', 
  status_all = '$statusAll',
  status_update = '$statusUpdate' 
  WHERE id = '$id' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION SEARCH/VIEW FEEDBACK
function viewFeedback($id)
{
  $query = "SELECT * FROM tb_feedback WHERE
  id = '$id'
  ";
  return query($query);
}

// FUNCTION DELETE FEEDBACK
function deleteFeedback($idFeedback)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM tb_feedback WHERE id = '$idFeedback' ");
  return mysqli_affected_rows($conn);
}


// =================================================
// FUNCTION NOTIFICATION
// =================================================
// FUNCTION READ NOTIFICATION 
function readNotification($data)
{
  global $conn;

  $idNotification = htmlspecialchars($data["id_notif"]);
  $statusRead = htmlspecialchars($data["status_read"]);

  $query = "UPDATE tb_notification SET
  status_read = '$statusRead' 
  WHERE id_notif = '$idNotification' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}

// FUNCTION READ ALL NOTIFICATION 
function readAllNotification($data)
{
  global $conn;

  $statusReadAll = htmlspecialchars($data["status_read_all"]);
  $statusRead = htmlspecialchars($data["status_read"]);

  $query = "UPDATE tb_notification SET
  status_read = '$statusRead' 
  WHERE status_read_all = '$statusReadAll' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// FUNCTION SEARCH/VIEW NOTIFICATION
function viewNotification($idNotif)
{
  $query = "SELECT * FROM tb_notification WHERE
  id_notif = '$idNotif'
  ";
  return query($query);
}

// =================================================
// FUNCTION ARSIP DOKUMEN
// =================================================
// TAMBAH DATA ARSIP DOKUMEN
function addArsip($data)
{
  global $conn;

  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $seriArsip = htmlspecialchars($data["seri_arsip"]);
  $jenisArsip = htmlspecialchars($data["jenis_arsip"]);
  $berkasNo = htmlspecialchars($data["berkas_no"]);
  $mediaPenyimpanan = htmlspecialchars($data["media_penyimpanan"]);
  $tingkatPerkembangan = htmlspecialchars($data["tingkat_perkembangan"]);
  $kurunWaktu = htmlspecialchars($data["kurun_waktu"]);
  $jumlah = htmlspecialchars($data["jumlah"]);
  $ketNasibAkhir = htmlspecialchars($data["ket_nasib_akhir"]);

  $file = uploadFileArsip();
  if (!$file) {
    return false;
  }

  // query
  $query = "INSERT INTO tb_arsip VALUES(null, '$idUser', '$seriArsip', '$jenisArsip', '$berkasNo', '$mediaPenyimpanan', '$tingkatPerkembangan', '$kurunWaktu', '$jumlah', '$ketNasibAkhir', '$file')";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// EDIT DATA ARSIP DOKUMEN
function editArsip($data)
{
  global $conn;

  $id = htmlspecialchars($data["id"]);
  $idUser = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_user"]))))))))));
  $seriArsip = htmlspecialchars($data["seri_arsip"]);
  $jenisArsip = htmlspecialchars($data["jenis_arsip"]);
  $berkasNo = htmlspecialchars($data["berkas_no"]);
  $mediaPenyimpanan = htmlspecialchars($data["media_penyimpanan"]);
  $tingkatPerkembangan = htmlspecialchars($data["tingkat_perkembangan"]);
  $kurunWaktu = htmlspecialchars($data["kurun_waktu"]);
  $jumlah = htmlspecialchars($data["jumlah"]);
  $ketNasibAkhir = htmlspecialchars($data["ket_nasib_akhir"]);
  $fileOld = htmlspecialchars($data["file_old"]);

  if ($_FILES['file']['error'] === 4) {
    $file = $fileOld;
  } else {
    $file = uploadFileArsip();
  }

  // query
  $query = "UPDATE tb_arsip SET 
  id_user = '$idUser', 
  seri_arsip = '$seriArsip', 
  jenis_arsip = '$jenisArsip', 
  berkas_no = '$berkasNo', 
  media_penyimpanan = '$mediaPenyimpanan', 
  tingkat_perkembangan = '$tingkatPerkembangan', 
  kurun_waktu = '$kurunWaktu', 
  jumlah = '$jumlah', 
  ket_nasib_akhir = '$ketNasibAkhir', 
  file = '$file' 
  WHERE id = '$id' ";

  mysqli_query($conn, $query);
  return mysqli_affected_rows($conn);
}


// FUNCTION UPLOAD FILE ARSIP
function uploadFileArsip()
{
  $namaFile = $_FILES['file']['name'];
  $ukuranFile = $_FILES['file']['size'];
  $error = $_FILES['file']['error'];
  $tmpName = $_FILES['file']['tmp_name'];

  // cek apakah ada file yang diupload atau tidak
  if ($error === 4) {
    echo "
		<script>
			alert('Pilih file terlebih dahulu');
      document.location.href = '';
		</script>";
    return false;
  }

  // cek apakah yang diupload adalah format file yang telah ditentukan
  $ekstensiFileValid = ['jpg', 'jpeg', 'png', 'docx', 'doc', 'pdf'];
  $ekstensiFile = explode('.', $namaFile);
  $ekstensiFile = strtolower(end($ekstensiFile));
  if (!in_array($ekstensiFile, $ekstensiFileValid)) {
    echo "
		<script>
			alert('Yang anda upload bukan format file yang diminta');
      document.location.href = '';
		</script>";
    return false;
  }

  // cek ukuran file  yang diupload
  if ($ukuranFile > 5000000) {
    echo "
		<script>
			alert('Ukuran file terlalu besar');
      document.location.href = '';
		</script>";
    return false;
  }

  // lolos pengecekan, file siap di upload
  // generate nama file baru
  $namaFileBaru = uniqid($namaFile . '_');
  $namaFileBaru .= '.';
  $namaFileBaru .= $ekstensiFile;

  move_uploaded_file($tmpName, '../../uploads/arsip/' . $namaFileBaru);
  return $namaFileBaru;
}

// FUNCTION DELETE ARSIP
function deleteArsip($idArsip)
{
  global $conn;

  mysqli_query($conn, "DELETE FROM tb_arsip WHERE id = '$idArsip' ");
  return mysqli_affected_rows($conn);
}



// =================================================
// FUNCTION BUKU AGENDA
// =================================================
// FUNCTION SEARCH/FILTER ARSIP

function filterArsip($ketNasibAkhir)
{
  $query = "SELECT * FROM tb_arsip WHERE
  ket_nasib_akhir = '$ketNasibAkhir'
  ";
  return query($query);
}
