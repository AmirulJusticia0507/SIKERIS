<?php
$server = "192.168.1.184";
// $server = "e31d0e0561e3.sn.mynetname.net";
// $server = "localhost";
$username = "root";
// $password = "royalmaa2*123";
$password = "";
$database = "db_mobile_collection";
// $database = "loginmobilecollect_db";

// Buat koneksi ke server
$connectionServernew = new mysqli($server, $username, $password, $database);

// Periksa koneksi ke server
if ($connectionServernew->connect_error) {
    $hasil['STATUS'] = "000199";
    die(json_encode($hasil));
}
?>