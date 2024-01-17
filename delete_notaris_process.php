<?php
// Koneksi ke database
include 'koneksibaru.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil data notaris_id dari parameter GET
    $notaris_id = $_GET['notaris_id'];

    // Lakukan penghapusan pengguna dari database
    $query = "DELETE FROM db_mobile_collection.notaris WHERE notaris_id = $notaris_id";
    $result = $connectionServernew->query($query);

    if ($result) {
        // Redirect kembali ke halaman utama setelah berhasil menghapus pengguna
        header("Location: settingnotaris.php?page=settingnotaris");
        exit;
    } else {
        // Tampilkan pesan kesalahan jika penghapusan gagal
        echo "Error: " . $connectionServernew->error;
    }
} else {
    // Jika bukan metode GET, alihkan ke halaman lain atau berikan respons sesuai kebutuhan
    header('Location: settingnotaris.php?page=settingnotaris');
    exit();
}
?>
