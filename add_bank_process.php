<?php
// add_bank_process.php

// Koneksi ke database
include 'koneksibaru.php';

// Set default response
$response = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $nama_bank = $_POST['nama_bank'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $website = $_POST['website'];
    // $tanggal_berdiri = $_POST['tanggal_berdiri'];
    $kode_bank = $_POST['kode_bank'];
    $jenis_bank = $_POST['jenis_bank'];

    // Query untuk menyimpan data ke dalam tabel "bank"
    // $query = "INSERT INTO db_mobile_collection.bank (nama_bank, alamat, telepon, website, tanggal_berdiri, kode_bank, jenis_bank)VALUES ('$nama_bank', '$alamat', '$telepon', '$website', '$tanggal_berdiri', '$kode_bank', '$jenis_bank')";
    $query = "INSERT INTO db_mobile_collection.bank (nama_bank, alamat, telepon, website, kode_bank, jenis_bank)VALUES ('$nama_bank', '$alamat', '$telepon', '$website','$kode_bank', '$jenis_bank')";

    if ($connectionServernew->query($query) === TRUE) {
        // Jika data berhasil disimpan
        $response = "Data bank berhasil ditambahkan.";
        header("Location: settingbank.php?page=settingbank");
        exit;
    } else {
        // Jika terjadi kesalahan
        $response = "Error: " . $query . "<br>" . $connectionServernew->error;
    }
} else {
    // Jika bukan metode POST, berikan pesan kesalahan
    $response = "Invalid request.";
}

// Mengembalikan response
echo $response;
?>
