<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['message_id'])) {
    $messageId = $_GET['message_id'];

    // Konfigurasi koneksi ke database
    $server = "192.168.1.184";
    $username = "root";
    $password = "";
    $database = "db_mobile_collection";

    $connection = new mysqli($server, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Hapus chat dari database berdasarkan message_id
    $query = $connection->prepare("DELETE FROM db_mobile_collection.chat_messages WHERE id = ?");
    $query->bind_param("i", $messageId);

    if ($query->execute()) {
        echo "Chat successfully deleted.";
        header("Location: chat_dialog.php?page=chat_dialog");
        exit;
    } else {
        echo "Failed to delete chat.";
    }

    $query->close();
    $connection->close();
} else {
    echo "Invalid request.";
}
?>
