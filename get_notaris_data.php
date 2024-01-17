<?php
// Include session start if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$server = "192.168.1.184";
$username = "root";
$password = "";
$database = "db_mobile_collection";

// Create a connection to the server
$connectionServernew = new mysqli($server, $username, $password, $database);

// Check the connection to the server
if ($connectionServernew->connect_error) {
    die("Connection failed: " . $connectionServernew->connect_error);
}

// Get the search term from the AJAX request
$term = $_GET['term'];  // Use $_GET for consistency with AJAX request

// Query based on user role
$userRole = $_SESSION['userRole'];
if ($userRole == "Superadmin") {
    $query = "SELECT id, namalengkapnotaris FROM db_mobile_collection.notaris WHERE namalengkapnotaris LIKE '%$term%'";
} else if ($userRole == "Notaris") {
    // Adjust the query to get data relevant to the Notaris role
    $query = "SELECT userid, username, fullname FROM db_mobile_collection.users_new WHERE username LIKE '%$term%' AND user_role = 'Superadmin'";
} else {
    // Handle other user roles as needed
    $query = ""; // Adjust according to the logic for other roles
}

$result = $connectionServernew->query($query);

// Format data as a JSON array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = array(
        'value' => $row['id'], // Adjust according to the relevant column
        'label' => $row['namalengkapnotaris']
    );
}

// Send data as a JSON response
echo json_encode($data);

// Close the connection
$connectionServernew->close();
?>
