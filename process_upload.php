<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan bahwa form telah disubmit
    $messageId = $_POST['message_id'];

    // Proses upload file PDF
    $pdfUploadDir = "uploads/pdf/"; // Sesuaikan dengan direktori penyimpanan file PDF
    $pdfUploadFile = $pdfUploadDir . basename($_FILES['pdfFile']['name']);

    if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdfUploadFile)) {
        // File PDF berhasil diupload, masukkan informasi ke database
        // Selanjutnya, Anda dapat menyimpan path file PDF ini ke dalam tabel sesuai dengan message_id

        // Proses upload file gambar
        $imageUploadDir = "uploads/images/"; // Sesuaikan dengan direktori penyimpanan file gambar
        $imageUploadFile = $imageUploadDir . basename($_FILES['imageFile']['name']);

        if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $imageUploadFile)) {
            // File gambar berhasil diupload, masukkan informasi ke database
            // Selanjutnya, Anda dapat menyimpan path file gambar ini ke dalam tabel sesuai dengan message_id

            // Tambahkan kueri SQL untuk menyimpan path file ke dalam tabel
            // $server = "localhost";
            $server = "192.168.1.184";
            $username = "root";
            $password = "";
            $database = "db_mobile_collection";

            $connectionServernew = new mysqli($server, $username, $password, $database);

            if ($connectionServernew->connect_error) {
                $hasil['STATUS'] = "000199";
                die(json_encode($hasil));
            }

            $pdfFilePath = $pdfUploadFile; // Sesuaikan dengan kolom yang sesuai di tabel Anda
            $imageFilePath = $imageUploadFile; // Sesuaikan dengan kolom yang sesuai di tabel Anda

            $query = "UPDATE db_mobile_collection.chat_messages SET file_pdf = '$pdfFilePath', file_image = '$imageFilePath' WHERE id = $messageId";
            $result = $connectionServernew->query($query);

            if ($result) {
                echo "File berhasil diupload dan informasi disimpan ke database.";
                header("Location: chat_dialog.php?page=chat_dialog");
                exit;
            } else {
                echo "Gagal menyimpan informasi ke database.";
            }
        } else {
            echo "Gagal upload file gambar.";
        }
    } else {
        echo "Gagal upload file PDF.";
    }
} else {
    echo "Metode request tidak valid.";
}
?>
