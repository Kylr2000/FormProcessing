<?php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "Hello";
$dbname = "test1";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the workflow definition for the form
$form_type = $_POST["form_type"];
$sql = "SELECT metadata FROM forms WHERE type = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $form_type);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$workflow = $row["metadata"];

// Convert the workflow definition from JSON to an array
$workflow_array = json_decode($workflow, true);

// Get the first name from the workflow definition array
$first_name = $workflow_array[0];

// Send the PDF form and email notification to the staff user
// Get the PDF form from the forms table


// Email the PDF form to the staff user
$to = "$first_name@gmail.com";
$subject = "New Form Submission";
$message = "A new form has been submitted for your review. Please find the attached form.";
$headers = "From: kyle.jaimungal@gmail.com\r\n";
mail($to, $subject, $message, $headers);

// Close the statement and connection
$stmt->close();
$conn->close();

?>
