<?php
include 'koneksibaru.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $namalengkapnotaris = $_POST['namalengkapnotaris'];
    $kantornotaris = $_POST['kantornotaris'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $npwp = $_POST['npwp'];
    $tgl_berdiri = $_POST['tgl_berdiri'];

    // Query untuk menambahkan data notaris
    $query = "INSERT INTO db_mobile_collection.notaris 
              (namalengkapnotaris, kantornotaris, alamat, telepon, email, npwp, tgl_berdiri) 
              VALUES ('$namalengkapnotaris', '$kantornotaris', '$alamat', '$telepon', '$email', '$npwp', '$tgl_berdiri')";

    if ($connectionServernew->query($query) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Notaris added successfully.';
        header("Location: settingnotaris.php?page=settingnotaris");
        exit;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error adding notaris: ' . $connectionServernew->error;
    }

    echo json_encode($response);
} else {
    echo "Invalid request.";
}
?>
