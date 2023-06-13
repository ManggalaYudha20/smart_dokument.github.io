-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Okt 2022 pada 04.38
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arsip_document`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_arsip`
--

CREATE TABLE `tb_arsip` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `seri_arsip` varchar(20) NOT NULL,
  `jenis_arsip` varchar(100) NOT NULL,
  `berkas_no` varchar(50) NOT NULL,
  `media_penyimpanan` varchar(50) NOT NULL,
  `tingkat_perkembangan` varchar(100) NOT NULL,
  `kurun_waktu` varchar(50) NOT NULL,
  `jumlah` varchar(1550) NOT NULL,
  `ket_nasib_akhir` varchar(50) NOT NULL,
  `file` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_arsip`
--

INSERT INTO `tb_arsip` (`id`, `id_user`, `seri_arsip`, `jenis_arsip`, `berkas_no`, `media_penyimpanan`, `tingkat_perkembangan`, `kurun_waktu`, `jumlah`, `ket_nasib_akhir`, `file`) VALUES
(3, 3, '12.12', 'Jenis Arsip', '24', 'Karung', 'Asli', '2 hari', '23', 'Dinilai Kembali', 'CV.docx_6303aa439f2d0.docx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_disposisi`
--

CREATE TABLE `tb_disposisi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_surat` int(11) NOT NULL,
  `tujuan_disposisi` varchar(255) NOT NULL,
  `isi_disposisi` varchar(500) NOT NULL,
  `batas_waktu` varchar(100) NOT NULL,
  `sifat` varchar(50) NOT NULL,
  `catatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_disposisi`
--

INSERT INTO `tb_disposisi` (`id`, `id_user`, `id_surat`, `tujuan_disposisi`, `isi_disposisi`, `batas_waktu`, `sifat`, `catatan`) VALUES
(3, 3, 4, 'Kepala Bappeda - Gorontalo', 'berikut ini adalah contoh untuk disposisi pada bagian isi disposisi', '2022-08-12', 'Rahasia', 'Segera lanjutkan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_feedback`
--

CREATE TABLE `tb_feedback` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `response` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `status_all` int(11) NOT NULL,
  `status_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_feedback`
--

INSERT INTO `tb_feedback` (`id`, `id_user`, `gambar`, `first_name`, `last_name`, `phone`, `email`, `description`, `response`, `date`, `time`, `status`, `status_all`, `status_update`) VALUES
(8, 3, '287707999_3233565923637816_806394560881023534_n(1).jpg_6303a8669c644.jpg', 'Singgi', 'Mokodompit', '082346455079', 'singgimokodompit.it@gmail.com', 'Terimakasih ', 'Baik', '25 Aug 2022', '12:35', 0, 0, 0),
(9, 3, '287707999_3233565923637816_806394560881023534_n(1).jpg_6303a8669c644.jpg', 'Singgi', 'Mokodompit', '082346455079', 'singgimokodompit.it@gmail.com', 'Terimakasih ', 'Baik', '25 Aug 2022', '12:35', 0, 0, 0),
(11, 7, '292109299_1451774091937263_5290469128589612919_n.jpg_630843742b726.jpg', 'Abdul', 'Halid Suma', '082345455567', 'w3b.indonesia@gmail.com', 'saya butuh file disposisi pak', 'Sangat Baik', '26 Aug 2022', '11:57', 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_klasifikasi`
--

CREATE TABLE `tb_klasifikasi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `uraian` varchar(800) NOT NULL,
  `tgl_diterima` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_klasifikasi`
--

INSERT INTO `tb_klasifikasi` (`id`, `id_user`, `kode`, `nama`, `uraian`, `tgl_diterima`) VALUES
(3, 3, '123', 'Singgi Mokodompit', 'Contoh penulisan uraian dalam klasifikasi surat', '2022-08-23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_message`
--

CREATE TABLE `tb_message` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  `file` varchar(500) NOT NULL,
  `date` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `status_all` int(11) NOT NULL,
  `status_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_message`
--

INSERT INTO `tb_message` (`id`, `id_user`, `gambar`, `first_name`, `last_name`, `description`, `file`, `date`, `time`, `status`, `status_all`, `status_update`) VALUES
(15, 7, '287707999_3233565923637816_806394560881023534_n(1).jpg_6303a8669c644.jpg', 'Singgi', 'Mokodompit', 'Terimakasih sudah memberikan feedback kepada kami', 'CV 1.docx_630844e03627d.docx', '26 Aug 2022', '11:58', 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_notification`
--

CREATE TABLE `tb_notification` (
  `id_notif` int(11) NOT NULL,
  `notif` varchar(500) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `status_read` int(11) NOT NULL,
  `status_read_all` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_notification`
--

INSERT INTO `tb_notification` (`id_notif`, `notif`, `no_surat`, `status_read`, `status_read_all`, `date`, `time`) VALUES
(9, 'tsm', '001/sm/VIII/2022', 0, 0, '2022-08-26', '11:42:00'),
(10, 'tsk', '001/sk/VIII/2022', 0, 0, '2022-08-26', '11:47:00'),
(11, 'tsk', '002/sk/VIII/2022', 0, 0, '2022-08-26', '11:49:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_surat_keluar`
--

CREATE TABLE `tb_surat_keluar` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `no_agenda` int(11) NOT NULL,
  `kode_klasifikasi` varchar(30) NOT NULL,
  `tujuan_surat` varchar(250) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `isi` varchar(255) NOT NULL,
  `tgl_diterima` varchar(20) NOT NULL,
  `tgl_surat` varchar(10) NOT NULL,
  `file` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_surat_keluar`
--

INSERT INTO `tb_surat_keluar` (`id`, `id_user`, `no_agenda`, `kode_klasifikasi`, `tujuan_surat`, `no_surat`, `keterangan`, `isi`, `tgl_diterima`, `tgl_surat`, `file`) VALUES
(19, 3, 23781, '001', 'Kepala Bappeda Bone Bolango', '001/sk/VIII/2022', 'keterangan dalam penulisan surat keluar', 'Berikut ini adalah contoh penulisan isi ringkas surat', '2022-08-26', '2022-08-19', 'CV 1.docx_6308425008329.docx'),
(20, 3, 23781, '001', 'Kepala Bappeda Bone Bolango', '002/sk/VIII/2022', 'keterangan dalam penulisan surat keluar', 'Berikut ini adalah contoh penulisan isi ringkas surat', '2022-08-26', '2022-08-26', 'CV 1.docx_630842ca25936.docx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_surat_masuk`
--

CREATE TABLE `tb_surat_masuk` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `no_agenda` int(11) NOT NULL,
  `kode_klasifikasi` varchar(30) NOT NULL,
  `asal_surat` varchar(250) NOT NULL,
  `indeks` varchar(30) NOT NULL,
  `no_surat` varchar(50) NOT NULL,
  `isi` mediumtext NOT NULL,
  `tgl_diterima` varchar(20) NOT NULL,
  `tgl_surat` varchar(10) NOT NULL,
  `keterangan` varchar(250) NOT NULL,
  `file` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_surat_masuk`
--

INSERT INTO `tb_surat_masuk` (`id`, `id_user`, `no_agenda`, `kode_klasifikasi`, `asal_surat`, `indeks`, `no_surat`, `isi`, `tgl_diterima`, `tgl_surat`, `keterangan`, `file`) VALUES
(15, 3, 23781, '001', 'Gorontalo', 'ABC01', '001/sm/VIII/2022', 'Berikut ini adalah contoh penulisan isi ringkas surat', '2022-08-26', '2022-08-26', 'Untuk Disosialisasikan (Internal)', 'CV 1.docx_630842043897a.docx');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `password2` varchar(200) NOT NULL,
  `level` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id`, `gambar`, `first_name`, `last_name`, `username`, `password`, `password2`, `level`) VALUES
(3, '287707999_3233565923637816_806394560881023534_n(1).jpg_6303a8669c644.jpg', 'Singgi', 'Mokodompit', 'super_admin', '$2y$10$BUaO6zNE.JuoGIcCzTD/IeJdwJB77etBsG17EVn4Y5G/kWvPZYBay', '@super_admin123', 'superadmin'),
(7, '292109299_1451774091937263_5290469128589612919_n.jpg_630843742b726.jpg', 'Abdul', 'Halid Suma', 'abdulhalidsuma', '$2y$10$o7aXkXyHd65NPWxlxOj.6u7k.wZ/ldoZ7QH3SdoJ5NsTkt/yNriCC', 'user123', 'user'),
(9, '20220527_134045.jpg_63046b3c8ee75.jpg_63083efd11e28.jpg', 'Basir ', 'Noho', 'kaban', '$2y$10$NB/9xAkZff8B3Sk/hfDjEuVQrrC0PJxgax.u6X0g3ddUMY2hQB90y', 'kaban', 'kaban');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_arsip`
--
ALTER TABLE `tb_arsip`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_disposisi`
--
ALTER TABLE `tb_disposisi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_feedback`
--
ALTER TABLE `tb_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_klasifikasi`
--
ALTER TABLE `tb_klasifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_message`
--
ALTER TABLE `tb_message`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_notification`
--
ALTER TABLE `tb_notification`
  ADD PRIMARY KEY (`id_notif`);

--
-- Indeks untuk tabel `tb_surat_keluar`
--
ALTER TABLE `tb_surat_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_surat_masuk`
--
ALTER TABLE `tb_surat_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_arsip`
--
ALTER TABLE `tb_arsip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_disposisi`
--
ALTER TABLE `tb_disposisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_feedback`
--
ALTER TABLE `tb_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_klasifikasi`
--
ALTER TABLE `tb_klasifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_message`
--
ALTER TABLE `tb_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_notification`
--
ALTER TABLE `tb_notification`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_surat_keluar`
--
ALTER TABLE `tb_surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tb_surat_masuk`
--
ALTER TABLE `tb_surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
