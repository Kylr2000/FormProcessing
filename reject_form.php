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
    require_once "db_connection.php";

    // Update the form status to "Rejected"
    $query = "UPDATE forms SET status = 'Form has been Rejected by $user_name' WHERE id = $submission_id";
    if ($conn->query($query) === TRUE) {
        echo "Form rejected successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
?>
