<?php
// Koneksi ke database
include 'koneksibaru.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $userid = $_POST['userid'];

    // Query untuk mendapatkan detail pengguna berdasarkan userid
    $query = "SELECT * FROM db_mobile_collection.users_new WHERE userid = $userid";
    $result = $connectionServernew->query($query);

    if ($result->num_rows > 0) {
        // Ambil data pengguna
        $user = $result->fetch_assoc();

        // Tampilkan detail pengguna dalam format HTML
        echo "<h5>User ID: {$user['userid']}</h5>";
        echo "<p>Username: {$user['username']}</p>";
        echo "<p>Fullname: {$user['fullname']}</p>";
        echo "<p>Created At: {$user['created_at']}</p>";
        echo "<p>User Role: {$user['user_role']}</p>";
    } else {
        // Jika pengguna tidak ditemukan
        echo "User not found.";
    }
} else {
    // Jika bukan metode POST, berikan pesan kesalahan
    echo "Invalid request.";
}
?>
