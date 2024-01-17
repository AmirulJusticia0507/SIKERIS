<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}

$server = "192.168.1.184";
$username = "root";
$password = "";
$database = "db_mobile_collection";

$connectionServernew = new mysqli($server, $username, $password, $database);

if ($connectionServernew->connect_error) {
    $hasil['STATUS'] = "000199";
    die(json_encode($hasil));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $namaNasabah = isset($_POST["namaNasabah"]) ? $_POST["namaNasabah"] : '';
    $noSertifikat = isset($_POST["no_Sertifikat"]) ? $_POST["no_Sertifikat"] : '';
    $pemilikSertifikat = isset($_POST["pemilikSertifikat"]) ? $_POST["pemilikSertifikat"] : '';
    $notaris = isset($_POST["notaris_id"]) ? $_POST["notaris_id"] : '';

    // Proses upload file PDF
    $uploadDirectory = "uploads/pdf/";  // Ganti dengan direktori yang sesuai

    // Menggunakan entryId yang telah disimpan di sesi
    $entryId = $_SESSION['current_entryId'];

    // Inisialisasi array untuk menyimpan nama file
    $uploadedFiles = array();

    // Loop through each uploaded file
    foreach ($_FILES["scanSertifikatModal"]["tmp_name"] as $key => $tmp_name) {
        $pdfFileName = basename($_FILES["scanSertifikatModal"]["name"][$key]);
        $pdfFilePath = $uploadDirectory . $pdfFileName;
        $pdfFileType = pathinfo($pdfFilePath, PATHINFO_EXTENSION);

        // Memeriksa apakah file adalah file PDF
        if ($pdfFileType != "pdf") {
            echo "File harus berupa PDF.";
        } else {
            // Pindahkan file PDF ke direktori upload
            if (move_uploaded_file($_FILES["scanSertifikatModal"]["tmp_name"][$key], $pdfFilePath)) {
                // Menambahkan nama file ke dalam array
                $uploadedFiles[] = $pdfFileName;
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
            }
        }
    }

    // Menggabungkan nama file menjadi satu string menggunakan implode
    $fileListString = implode(', ', $uploadedFiles);

    // Masukkan data ke dalam tabel dengan nama file yang telah digabungkan
    $query = "INSERT INTO db_mobile_collection.entry_pengikatan_berkas (namaNasabah, noSertifikat, pemilikSertifikat, entryId, notarisId, scanSertifikatPath) VALUES ('$namaNasabah', '$noSertifikat', '$pemilikSertifikat', '$entryId', '$notaris', '$fileListString')";

    if ($connectionServernew->query($query) === TRUE) {
        echo "Data berhasil dimasukkan.";

        // Display the updated table
        include 'display_entries.php';

        header("Location: progesspengikatan.php?page=progesspengikatan");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . $connectionServernew->error;
    }
}
?>
