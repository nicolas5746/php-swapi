<?php
// Create session
session_start();
// Use connection
include(__DIR__ . "/conn/conn.php");
// Select all columns
$sql = "SELECT * FROM characters";
// Parsing the requested path
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
// Perform query in database
if ($result = mysqli_query($conn, $sql)) {
    $count = mysqli_num_rows($result); // Number of rows
    $valid_path = false; // Set path as invalid by default
    if ($uri === "/") {
        $valid_path = true; // Valid path
        require __DIR__ . "/views/home.php";
    }
    // Loop throughout rows
    for ($i = 0; $i <= $count + 1; $i++) {
        $path = "/character/id/" . $i; // Path of id, plus id number
        if ($uri === $path) {
            $valid_path = true; // Valid path
            require __DIR__ . "/views/character.php";
        }
        $_SESSION['id'] = $i + 1; // Since index starts at 0, set session id plus 1 to match row
    }
    // If path has not been set as valid, will redirect to Not Found page
    if (!$valid_path) {
        require __DIR__ . "/views/not_found.php";
        die(); // Terminate the current script
    }
}
?>