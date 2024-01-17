<?php
// get_bank_details.php

// Koneksi ke database
include 'koneksibaru.php';

// Set default response
$response = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Ambil data dari formulir
    $id = $_POST['id'];

    // Query untuk mendapatkan detail bank berdasarkan id
    $query = "SELECT * FROM db_mobile_collection.bank WHERE id = $id";
    $result = $connectionServernew->query($query);

    if ($result->num_rows > 0) {
        // Ambil data bank
        $bank = $result->fetch_assoc();

        // Tampilkan detail bank dalam format HTML
        $response .= "<p>Nama Bank: {$bank['nama_bank']}</p>";
        $response .= "<p>Alamat: {$bank['alamat']}</p>";
        $response .= "<p>Telepon: {$bank['telepon']}</p>";
        $response .= "<p>Website: {$bank['website']}</p>";
        $response .= "<p>Tanggal Berdiri: {$bank['tanggal_berdiri']}</p>";
        $response .= "<p>Kode Bank: {$bank['kode_bank']}</p>";
        $response .= "<p>Jenis Bank: {$bank['jenis_bank']}</p>";
    } else {
        // Jika bank tidak ditemukan
        $response = "Bank not found.";
    }
} else {
    // Jika bukan metode POST, berikan pesan kesalahan
    $response = "Invalid request.";
}

// Mengembalikan response
echo $response;
?>
