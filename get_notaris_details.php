<?php
include 'koneksibaru.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $notarisid = $_POST['notaris_id'];

    // Query untuk mendapatkan detail notaris berdasarkan ID
    $query = "SELECT * FROM db_mobile_collection.notaris WHERE notaris_id = $notarisid";
    $result = $connectionServernew->query($query);

    if ($result->num_rows > 0) {
        // Ambil data notaris
        $notaris = $result->fetch_assoc();

        // Tampilkan detail notaris dalam format HTML
        echo "<h5>Notaris ID: {$notaris['notaris_id']}</h5>";
        echo "<p>Nama Notaris: {$notaris['namalengkapnotaris']}</p>";
        echo "<p>Kantor Notaris: {$notaris['kantornotaris']}</p>";
        echo "<p>Alamat: {$notaris['alamat']}</p>";
        echo "<p>Telepon: {$notaris['telepon']}</p>";
        echo "<p>Email: {$notaris['email']}</p>";
        echo "<p>NPWP: {$notaris['npwp']}</p>";
        echo "<p>Tanggal Berdiri: {$notaris['tgl_berdiri']}</p>";
    } else {
        // Jika notaris tidak ditemukan
        echo "Notaris not found.";
    }
} else {
    // Jika bukan metode POST, berikan pesan kesalahan
    echo "Invalid request.";
}
?>
