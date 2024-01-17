<?php
include 'koneksibaru.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $notarisid = $_POST['notaris_id'];
    $namalengkapnotaris = $_POST['updateNamaLengkapNotaris'];
    $kantornotaris = $_POST['updateKantorNotaris'];
    $alamat = $_POST['updateAlamat'];
    $telepon = $_POST['updateTelepon'];
    $email = $_POST['updateEmail'];
    $npwp = $_POST['updateNPWP'];
    $tgl_berdiri = $_POST['updateBerdiri'];

    // Query untuk mengupdate data notaris
    $query = "UPDATE db_mobile_collection.notaris 
              SET namalengkapnotaris = '$namalengkapnotaris', kantornotaris = '$kantornotaris', 
                  alamat = '$alamat', telepon = '$telepon', email = '$email', 
                  npwp = '$npwp', tgl_berdiri = '$tgl_berdiri' 
              WHERE notaris_id = $notarisid";

    if ($connectionServernew->query($query) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Notaris updated successfully.';
        header("Location: settingnotaris.php?page=settingnotaris");
        exit;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error updating notaris: ' . $connectionServernew->error;
    }

    echo json_encode($response);
} else {
    echo "Invalid request.";
}
?>
