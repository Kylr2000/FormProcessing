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
    $submission_id = $_GET['id'];

    // Connect to the database
    require_once "db.php";
    $conn = get_db_connection();

    // Update the form status to "Rejected"
    $query = "UPDATE form_submissions SET status = 'Rejected' WHERE submission_id = $submission_id";
    if ($conn->query($query) === TRUE) {
        echo "Form rejected successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

     // Send an email notification to the student that the form has been rejected
    $query = "SELECT email_address FROM form_submissions WHERE submission_id = $submission_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $to_email = $row['email_address'];
    
    $subject = 'Form submission rejected';
    $message = 'Your form submission has been rejected by ' . $user_name . ' with reason: ' . $prev_approval . '. Please make any necessary revisions and resubmit the form.';
    mail($to_email, $subject, $message);

    // Close the database connection
    $conn->close();
?>
