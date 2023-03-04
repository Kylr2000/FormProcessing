<?php

// Connect to the database
include 'db.php';

// Get a new database connection object
$conn = get_db_connection();


// Get the workflow definition for the form
$form_type = $_POST["form_type"];
$query = "SELECT metadata FROM forms WHERE type = '$form_type'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$workflow = $row["metadata"];

// Convert the workflow definition from JSON to an array
$workflow_array = json_decode($workflow, true);

// find if the name Admin is in the array switch case

// Get the first name from the workflow definition array
$first_name = $workflow_array[0];

// Send the PDF form and email notification to the staff user
// Get the PDF form from the forms table


// Email the PDF form to the staff user
$to = "$first_name@gmail.com";
$subject = "New Form Submission";
$message = "A new form has been submitted for your review. Please find the attached form.";
$headers = "From: kyle.jaimungal@gmail.com\r\n";
if(mail($to, $subject, $message, $headers)){
    // Email was sent successfully
    echo $first_name;
} else {
    // Email sending failed
    echo "Error sending the advisory form to $firstname. Please try again later.";
}
// Close the statement and connection
$conn->close();

?>
