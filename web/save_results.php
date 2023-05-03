<?php
// Retrieve the value parameter from the AJAX request
$value = $_POST['value'];

// Get the current date and time
$datetime = date('Y-m-d H:i:s');

// Insert the data into the database
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "results";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO $dbname (Result, Date) VALUES ('$value', '$datetime')";

if (mysqli_query($conn, $sql)) {
    $response = array("success" => true);
    echo json_encode($response);
} else {
    $response = array("success" => false);
    echo json_encode("Error: " . $sql . "<br>" . mysqli_error($conn));
}

mysqli_close($conn);
?>

