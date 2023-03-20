<?php

$servername = "localhost";
$username = "root";
$password = "Hello";
$dbname = "test1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$pdf = file_get_contents($_FILES["pdf_file"]["tmp_name"]);
$type = $_POST["form_type"];
$workflow = $_POST["workflow_def"];
// Encode the workflow definition as a JSON string
$str = explode(",", $workflow);
$workflow_json = json_encode($str);

// Create a prepared statement
$stmt = $conn->prepare("INSERT INTO forms (file, type, metadata) VALUES (?, ?, ?)");

// Bind the parameters to the statement
$stmt->bind_param("sss", $pdf, $type, $workflow_json);

// Execute the prepared statement
if ($stmt->execute()) {
    echo "Form data inserted successfully.";
} else {
    echo "Error inserting form data: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();


?>
