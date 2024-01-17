<?php
// hapus_entry.php

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai entryId dari data POST
    $entryId = $_POST['entryId'];

    // Proses penghapusan data
    $query = "DELETE FROM db_mobile_collection.entry_pengikatan_berkas WHERE id = $entryId";
    $result = $connectionServernew->query($query);

    if ($result) {
        $hasil['STATUS'] = "000000";
        echo json_encode($hasil);
    } else {
        $hasil['STATUS'] = "000001";
        echo json_encode($hasil);
    }
} else {
    $hasil['STATUS'] = "000002";
    echo json_encode($hasil);
}
?>
