<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Buat koneksi ke database
    $server = "192.168.1.184";
    $username = "root";
    $password = "";
    $database = "db_mobile_collection";

    $connectionServernew = new mysqli($server, $username, $password, $database);

    // Periksa koneksi ke database
    if ($connectionServernew->connect_error) {
        $hasil['STATUS'] = "000199";
        die(json_encode($hasil));
    }

    // Periksa apakah file berhasil diunggah
    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['error'] === UPLOAD_ERR_OK) {
        $entryId = $_POST['entry_id'];
        $uploadDirectory = 'uploads/'; // Sesuaikan dengan direktori penyimpanan file

        // Pastikan direktori penyimpanan tersedia
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Generate nama unik untuk file
        $fileName = uniqid('pdf_') . '.pdf';
        $filePath = $uploadDirectory . $fileName;

        // Pindahkan file ke direktori penyimpanan
        if (move_uploaded_file($_FILES['pdfFile']['tmp_name'], $filePath)) {
            // File berhasil diunggah, lakukan penyimpanan path ke database
            $cleanFilePath = ''; // Sesuaikan dengan path file bersih jika ada
            $uncleanFilePath = ''; // Sesuaikan dengan path file tidak bersih jika ada

            // Simpan ke database
            $sql = "INSERT INTO file_upload (entry_id, clean_file_path, unclean_file_path) VALUES (?, ?, ?)";
            $stmt = $connectionServernew->prepare($sql);
            $stmt->bind_param('iss', $entryId, $cleanFilePath, $uncleanFilePath);

            // Periksa keberhasilan penyimpanan
            if ($stmt->execute()) {
                // Redirect kembali ke halaman hasilpengecekan.php dengan pesan sukses
                header('Location: hasilpengecekan.php?status=success&message=File berhasil diunggah.');
                exit();
            } else {
                // Redirect kembali ke halaman hasilpengecekan.php dengan pesan error
                header('Location: hasilpengecekan.php?status=error&message=Gagal menyimpan data ke database.');
                exit();
            }
        } else {
            // Redirect kembali ke halaman hasilpengecekan.php dengan pesan error
            header('Location: hasilpengecekan.php?status=error&message=Gagal mengunggah file.');
            exit();
        }
    } else {
        // Redirect kembali ke halaman hasilpengecekan.php dengan pesan error
        header('Location: hasilpengecekan.php?status=error&message=Gagal mengunggah file.');
        exit();
    }
} else {
    // Redirect kembali ke halaman hasilpengecekan.php jika akses langsung ke file
    header('Location: hasilpengecekan.php');
    exit();
}
?>
