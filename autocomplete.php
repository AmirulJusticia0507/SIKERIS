<?php
$server = "192.168.1.184";
$username = "root";
$password = "";
$database = "db_mobile_collection";

$connectionServernew = new mysqli($server, $username, $password, $database);

if ($connectionServernew->connect_error) {
    die("Connection failed: " . $connectionServernew->connect_error);
}

// Get the search term from the user input
$searchTerm = $_GET['term'];

// Query to fetch matching notaris names
$query = "SELECT namalengkapnotaris FROM db_mobile_collection.notaris WHERE namalengkapnotaris LIKE '%$searchTerm%'";
$result = $connectionServernew->query($query);

// Fetch results and store in an array
$notarisNames = array();
while ($row = $result->fetch_assoc()) {
    $notarisNames[] = $row['namalengkapnotaris'];
}

// Return the results as JSON
echo json_encode($notarisNames);
?>
