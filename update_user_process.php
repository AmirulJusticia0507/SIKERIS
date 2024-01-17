<?php
// Koneksi ke database
include 'koneksibaru.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $userid = isset($_POST['userid']) ? $_POST['userid'] : '';

    // Check if userid is set and not empty
    if (empty($userid)) {
        echo "Error: User ID not provided.";
        // You may want to redirect or provide some other response
        exit;
    }

    $updateUsername = $_POST['updateUsername'];
    $updateFullname = $_POST['updateFullname'];
    $updatePassword = $_POST['updatePassword'];
    $updateUserRole = $_POST['updateUserRole'];

    // Initialize $hashedPassword outside of the condition
    $hashedPassword = '';

    // Cek apakah password diubah atau tidak
    if (!empty($updatePassword)) {
        // Generate salt dan hashed password menggunakan bcrypt
        $hashedPassword = password_hash($updatePassword, PASSWORD_BCRYPT);
    }

    // Lakukan pembaruan data pengguna ke database dengan prepared statement
    $query = "UPDATE db_mobile_collection.users_new 
              SET username = ?, 
                  PASSWORD = ?, 
                  fullname = ?, 
                  user_role = ? 
              WHERE userid = ?";

    $stmt = $connectionServernew->prepare($query);

    if (!$stmt) {
        echo "Error in preparing statement: " . $connectionServernew->error;
        exit;
    }

    // Bind parameters
    $stmt->bind_param("ssssi", $updateUsername, $hashedPassword, $updateFullname, $updateUserRole, $userid);

    // Execute the statement
    $result = $stmt->execute();

    // Check if the update was successful
    if ($result) {
        // Redirect kembali ke halaman utama setelah berhasil memperbarui pengguna
        header("Location: usermanagements.php?page=usermanagements");
        exit;
    } else {
        // Tampilkan pesan kesalahan jika pembaruan gagal
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Jika bukan metode POST, alihkan ke halaman lain atau berikan respons sesuai kebutuhan
    header('Location: usermanagements.php?page=usermanagements');
    exit();
}
?>
