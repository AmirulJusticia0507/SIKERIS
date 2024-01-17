<?php
// process_chat.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = $_POST['from'];
    $receiver = $_POST['to'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Simpan data ke database
    $server = "192.168.1.184";
    // $server = "localhost";
    $username = "root";
    $password = "";
    $database = "db_mobile_collection";

    $connection = new mysqli($server, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Gunakan parameterized query untuk mencegah SQL injection
    $query = $connection->prepare("INSERT INTO db_mobile_collection.chat_messages (sender, receiver, subject, message) VALUES (?, ?, ?, ?)");
    $query->bind_param("ssss", $sender, $receiver, $subject, $message);

    if ($query->execute()) {
        echo "Data berhasil disimpan ke database.";

        // Tambahkan logika pengiriman pesan WhatsApp di sini
        sendWhatsAppMessage($receiver, $message);

        header("Location: chat_dialog.php?page=chat_dialog");
        exit;
    } else {
        echo "Gagal menyimpan data ke database.";
    }

    $query->close();
    $connection->close();
} else {
    echo "Metode request tidak valid.";
}

// Fungsi untuk mengirim pesan WhatsApp
function sendWhatsAppMessage($receiver, $message) {
    // Ganti URL dan parameter sesuai dengan API WhatsApp Business
    $whatsappApiUrl = 'https://api.whatsapp.com/send?phone=' . urlencode($receiver) . '&text=' . urlencode($message);

    // Buat permintaan ke API WhatsApp menggunakan cURL
    $ch = curl_init($whatsappApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    // Periksa apakah permintaan berhasil atau tidak
    if ($response === false) {
        echo 'Gagal mengirim pesan WhatsApp.';
    } else {
        echo 'Pesan WhatsApp berhasil dikirim.';
        header("Location: chat_dialog.php?page=chat_dialog");
        exit;
    }

    // Tutup koneksi cURL
    curl_close($ch);
}
?>
