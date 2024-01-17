<?php
// delete_bank_process.php

// Koneksi ke database
include 'koneksibaru.php';

// Set default response
$response = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $bank_id = $_POST['bankid'];

    // Query untuk menghapus data dari tabel "bank"
    $query = "DELETE FROM db_mobile_collection.bank WHERE id = $bank_id";

    if ($connectionServernew->query($query) === TRUE) {
        // Jika data berhasil dihapus
        $response = "Data bank berhasil dihapus.";
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
