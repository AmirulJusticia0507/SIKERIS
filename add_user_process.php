<?php
// Koneksi ke database
include 'koneksibaru.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];
    $userRole = $_POST['user_role'];

    // Lakukan penambahan pengguna ke database dengan prepared statement
    $query = "INSERT INTO db_mobile_collection.users_new (username, PASSWORD, fullname, user_role) VALUES (?, ?, ?, ?)";
    $stmt = $connectionServernew->prepare($query);

    if ($stmt) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("ssss", $username, $hashedPassword, $fullname, $userRole);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect kembali ke halaman utama setelah berhasil menambahkan pengguna
            header("Location: usermanagements.php?page=usermanagements");
            exit;
        } else {
            // Tampilkan pesan kesalahan jika penambahan gagal
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Tampilkan pesan kesalahan jika prepared statement gagal
        echo "Error: " . $connectionServernew->error;
    }
} else {
    // Jika bukan metode POST, alihkan ke halaman lain atau berikan respons sesuai kebutuhan
    header('Location: usermanagements.php?page=usermanagements');
    exit();
}
?>
