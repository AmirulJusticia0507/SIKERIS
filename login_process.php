<?php
session_start();

require_once('koneksibaru.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan informasi pengguna berdasarkan username
    $query = "SELECT * FROM db_mobile_collection.users_new WHERE username = ?";
    $stmt = $connectionServernew->prepare($query);

    if (!$stmt) {
        $hasil['STATUS'] = "000199";
        die(json_encode($hasil));
    }

    $stmt->bind_param("s", $username);

    if (!$stmt->execute()) {
        $hasil['STATUS'] = "000199";
        die(json_encode($hasil));
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi kata sandi menggunakan password_verify
        if (password_verify($password, $row['password'])) {
            // Login berhasil
            $_SESSION['userid'] = $row['userid'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['user_role'] = $row['user_role'];

            // Redirect sesuai dengan peran pengguna
            if ($row['user_role'] == 'Superadmin') {
                header("Location: index.php");
                exit;
            } elseif ($row['user_role'] == 'Notaris') {
                header("Location: index.php");
                exit;
            } else {
                // Peran pengguna tidak valid
                $hasil['STATUS'] = "000199";
                die(json_encode($hasil));
            }
        } else {
            // Password tidak sesuai
            $hasil['STATUS'] = "000198";
            die(json_encode($hasil));
        }
    } else {
        // Pengguna tidak ditemukan
        $hasil['STATUS'] = "000197";
        die(json_encode($hasil));
    }
} else {
    // Jika bukan metode POST, alihkan ke halaman login
    header('Location: login.php');
    exit();
}
?>
