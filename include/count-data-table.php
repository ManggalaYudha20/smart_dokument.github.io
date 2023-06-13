<?php 
// ==================================================================
	// HITUNG BERAPA JUMLAH AKUN TERDAFTAR
	// ==================================================================
	$jmlhAkun = $conn->query("SELECT COUNT(*) jmlhAkun FROM tb_users");
	$resultAkun = mysqli_fetch_assoc($jmlhAkun);

	// ==================================================================
	// HITUNG BERAPA JUMLAH AKUN TERDAFTAR (LEVEL SUPER ADMIN)
	// ==================================================================
	$jmlhAkunLevelSuperAdmin = $conn->query("SELECT COUNT(*) jmlhAkunLevelSuperAdmin FROM tb_users WHERE level = 'superadmin' ");
	$resultAkunLevelSuperAdmin = mysqli_fetch_assoc($jmlhAkunLevelSuperAdmin);

	// ==================================================================
	// HITUNG BERAPA JUMLAH AKUN TERDAFTAR (LEVEL KABAN)
	// ==================================================================
	$jmlhAkunLevelKaban = $conn->query("SELECT COUNT(*) jmlhAkunLevelKaban FROM tb_users WHERE level = 'kaban' ");
	$resultAkunLevelKaban = mysqli_fetch_assoc($jmlhAkunLevelKaban);

	// ==================================================================
	// HITUNG BERAPA JUMLAH AKUN TERDAFTAR (LEVEL USER)
	// ==================================================================
	$jmlhAkunLevelUser = $conn->query("SELECT COUNT(*) jmlhAkunLevelUser FROM tb_users WHERE level = 'user' ");
	$resultAkunLevelUser = mysqli_fetch_assoc($jmlhAkunLevelUser);

	// ==================================================================
	// HITUNG BERAPA JUMLAH SURAT MASUK
	// ==================================================================
	$jmlhSuratMasuk = $conn->query("SELECT COUNT(*) jmlhSuratMasuk FROM tb_surat_masuk");
	$resultSuratMasuk = mysqli_fetch_assoc($jmlhSuratMasuk);

	// ==================================================================
	// HITUNG BERAPA JUMLAH SURAT KELUAR
	// ==================================================================
	$jmlhSuratKeluar = $conn->query("SELECT COUNT(*) jmlhSuratKeluar FROM tb_surat_keluar");
	$resultSuratKeluar = mysqli_fetch_assoc($jmlhSuratKeluar);

	// ==================================================================
	// HITUNG BERAPA JUMLAH SURAT DISPOSISI
	// ==================================================================
	$jmlhSuratDisposisi = $conn->query("SELECT COUNT(*) jmlhSuratDisposisi FROM tb_disposisi");
	$resultSuratDisposisi = mysqli_fetch_assoc($jmlhSuratDisposisi);

	// ==================================================================
	// HITUNG BERAPA JUMLAH KLASIFIKASI SURAT
	// ==================================================================
	$jmlhKlasifikasiSurat = $conn->query("SELECT COUNT(*) jmlhKlasifikasiSurat FROM tb_klasifikasi");
	$resultKlasifikasiSurat = mysqli_fetch_assoc($jmlhKlasifikasiSurat);

	// ==================================================================
	// HITUNG BERAPA JUMLAH UMPAN BALIK/FEEDBACK
	// ==================================================================
	$jmlhFeedback = $conn->query("SELECT COUNT(*) jmlhFeedback FROM tb_feedback");
	$resultFeedback = mysqli_fetch_assoc($jmlhFeedback);

	// ==================================================================
	// HITUNG BERAPA JUMLAH UMPAN BALIK/FEEDBACK (SANGAT BAIK)
	// ==================================================================
	$jmlhFeedbackSangatBaik = $conn->query("SELECT COUNT(*) jmlhFeedbackSangatBaik FROM tb_feedback WHERE response = 'Sangat Baik' ");
	$resultFeedbackSangatBaik = mysqli_fetch_assoc($jmlhFeedbackSangatBaik);

	// ==================================================================
	// HITUNG BERAPA JUMLAH UMPAN BALIK/FEEDBACK (BAIK)
	// ==================================================================
	$jmlhFeedbackBaik = $conn->query("SELECT COUNT(*) jmlhFeedbackBaik FROM tb_feedback WHERE response = 'Baik' ");
	$resultFeedbackBaik = mysqli_fetch_assoc($jmlhFeedbackBaik);

	// ==================================================================
	// HITUNG BERAPA JUMLAH UMPAN BALIK/Feedback (SEDANG)
	// ==================================================================
	$jmlhFeedbackSedang = $conn->query("SELECT COUNT(*) jmlhFeedbackSedang FROM tb_feedback WHERE response = 'Sedang' ");
	$resultFeedbackSedang = mysqli_fetch_assoc($jmlhFeedbackSedang);

	// ==================================================================
	// HITUNG BERAPA JUMLAH UMPAN BALIK/Feedback (BURUK)
	// ==================================================================
	$jmlhFeedbackBuruk = $conn->query("SELECT COUNT(*) jmlhFeedbackBuruk FROM tb_feedback WHERE response = 'Buruk' ");
	$resultFeedbackBuruk = mysqli_fetch_assoc($jmlhFeedbackBuruk);

	// ==================================================================
	// HITUNG BERAPA JUMLAH UMPAN BALIK/Feedback (SANGAT BURUK)
	// ==================================================================
	$jmlhFeedbackSangatBuruk = $conn->query("SELECT COUNT(*) jmlhFeedbackSangatBuruk FROM tb_feedback WHERE response = 'Sangat Buruk' ");
	$resultFeedbackSangatBuruk = mysqli_fetch_assoc($jmlhFeedbackSangatBuruk);
