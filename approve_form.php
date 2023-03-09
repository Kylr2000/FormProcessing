<?php
    // Start the session and check if the user is logged in
    session_start();
    if (!isset($_SESSION['username'])) {
        // Redirect to login page if user is not logged in
        echo "You are not logged in. Redirect to login page...";
        exit();
      }
      
      // Get the logged in user's ID
    $user_name = $_SESSION['username'];

    // Get the form id from the URL parameter
    $submission_id = $_GET['form_id'];

    // Connect to the database
    require_once "db.php";

    // Update the form status to "Approved"
    $query = "UPDATE forms_submission SET status = '$user_name has approved the form' WHERE id = $submission_id";
    if ($conn->query($query) === TRUE) {
        echo "Form approved successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
?>
