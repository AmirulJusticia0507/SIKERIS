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
    $namaNasabah = $_POST["namaNasabah"];
    $noSertifikat = $_POST["no_Sertifikat"];
    $pemilikSertifikat = $_POST["pemilikSertifikat"];
    $notarisId = $_POST["notarisId"]; // Mendapatkan ID notaris yang dipilih

    $entryId = uniqid();
    $_SESSION['current_entryId'] = $entryId; // Simpan entryId ke dalam sesi

    // Masukkan data ke dalam tabel menggunakan prepared statement
    $query = "INSERT INTO db_mobile_collection.entry_pengikatan_berkas (namaNasabah, noSertifikat, pemilikSertifikat, notarisId, entryId) VALUES (?, ?, ?, ?, ?)";

    // Persiapkan statement
    $stmt = $connectionServernew->prepare($query);

    // Periksa apakah statement berhasil dipersiapkan
    if ($stmt) {
        // Bind parameter ke statement
        $stmt->bind_param("sssss", $namaNasabah, $noSertifikat, $pemilikSertifikat, $notarisId, $entryId);

        // Eksekusi statement
        if ($stmt->execute()) {
            echo "Data berhasil dimasukkan.";
            header("Location: progesspengikatan.php?page=progesspengikatan");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "Error: " . $connectionServernew->error;
    }
}
?>
