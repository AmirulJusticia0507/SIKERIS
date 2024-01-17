<?php
// Koneksi ke database
include 'koneksibaru.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ambil data userid dari parameter GET
    $userid = $_GET['userid'];

    // Lakukan penghapusan pengguna dari database
    $query = "DELETE FROM db_mobile_collection.users_new WHERE userid = $userid";
    $result = $connectionServernew->query($query);

    if ($result) {
        // Redirect kembali ke halaman utama setelah berhasil menghapus pengguna
        header("Location: usermanagements.php?page=usermanagements");
        exit;
    } else {
        // Tampilkan pesan kesalahan jika penghapusan gagal
        echo "Error: " . $connectionServernew->error;
    }
} else {
    // Jika bukan metode GET, alihkan ke halaman lain atau berikan respons sesuai kebutuhan
    header('Location: usermanagements.php?page=usermanagements');
    exit();
}
?>
