<?php
    include 'db.php';
    // Connect to the database

    $conn = get_db_connection();
    // Start the session and check if the user is logged in
    session_start();
    if (!isset($_SESSION['username'])) {
        // Redirect to login page if user is not logged in
        echo "You are not logged in. Redirect to login page...";
        exit();
      }
      
      // Get the logged in user's ID
    $user_name = $_SESSION['username'];
    $workflowname = json_encode($user_name);

    // Get the form id from the URL parameter
    $submission_id = $_GET['id'];
    

    
   

    // Update the form status to "Approved"

    // check if the workflow_approvals column is null

    $query = "SELECT * FROM form_submissions WHERE submission_id = $submission_id AND workflow_approvals IS NULL";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        // if it is null, insert the first approval
        $query = "UPDATE form_submissions SET workflow_approvals = ? WHERE submission_id = ?";
        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Bind the parameters
        $stmt->bind_param("si", json_encode($user_name), $submission_id);

        // Execute the statement
        $stmt->execute();
        if ($stmt->error) {
            echo "Error: " . $stmt->error;
        } else {
            echo "Form $submission_id approved by $user_name successfully.";
        }
    } else {
        $query = "UPDATE form_submissions SET workflow_approvals = JSON_ARRAY_APPEND(workflow_approvals, '$', ?) WHERE submission_id = ?";
        $stmt = $conn->prepare($query);
        // Bind the parameters
        $stmt->bind_param("si", json_encode($user_name), $submission_id);

        // Execute the statement
        $stmt->execute();
        
        if ($stmt->error) {
                echo "Error: " . $stmt->error;
            } else {
                echo "Form $submission_id approved by $user_name successfully.";
            }

    
    
    }
    $stmt->close();
    

     // Close the database connection
     $conn->close();
?>