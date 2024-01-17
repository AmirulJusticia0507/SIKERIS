<?php
// update_bank_process.php

// Koneksi ke database
include 'koneksibaru.php';

// Set default response
$response = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $bank_id = $_POST['bankid'];
    $nama_bank = $_POST['updateNamaBank'];
    $alamat = $_POST['updateAlamat'];
    $telepon = $_POST['updateTelepon'];
    $website = $_POST['updateWebsite'];
    // $tanggal_berdiri = $_POST['updateBerdiri'];
    $kode_bank = $_POST['updateKodeBank'];
    $jenis_bank = $_POST['updateJenisBank'];

    // Query untuk memperbarui data di tabel "bank"
    $query = "UPDATE db_mobile_collection.bank 
              SET nama_bank = '$nama_bank', 
                  alamat = '$alamat', 
                  telepon = '$telepon', 
                  website = '$website', 
                --   tanggal_berdiri = '$tanggal_berdiri', 
                  kode_bank = '$kode_bank', 
                  jenis_bank = '$jenis_bank'
              WHERE id = $bank_id";

    if ($connectionServernew->query($query) === TRUE) {
        // Jika data berhasil diperbarui
        $response = "Data bank berhasil diperbarui.";
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
