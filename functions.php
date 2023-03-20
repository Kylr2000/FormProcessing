<?php


function get_staff_email_by_name($name) {
    $conn = get_db_connection();
    // Query to retrieve the staff user information
    $query = "SELECT * FROM staff_members WHERE name = '$name'";
    // Execute the query
    $result = mysqli_query($conn, $query);
    // Get the row from the result set
    $row = mysqli_fetch_assoc($result);
    // Get the email address from the row
    $email = $row["email"];
    return $email; 

    // This function retrieves the email address of a staff member given their name
}

function send_email($to_email, $subject, $message) {
    // This function sends an email to the specified email address
    // Replace the code below with your implementation
    $success = mail($to_email, $subject, $message);
    return $success;
}

function update_form_submission_current_workflow($form_submission_id, $next_person) {
    // This function updates the current_workflow field in the form_submissions table
    // Replace the code below with your implementation
    // Connect to the database
    $conn = get_db_connection();
    $query = "UPDATE form_submissions SET current_workflow = ? WHERE submission_id = ?";
          $stmt = $conn->prepare($query);
          // Bind the parameters
          $stmt->bind_param("si", $next_person, $form_submission_id);
  
          // Execute the statement
          $success = $stmt->execute();
          $stmt->close();
    return $success;
   
}

function get_form_submission_workflow_approval($form_submission_id, $person) {
    // This function retrieves the workflow approval status for a particular person in a form submission
    // Replace the code below with your implementation
    $conn = get_db_connection();
    $query = "SELECT * FROM form_submissions, staff_members WHERE form_submissions.submission_id = '$form_submission_id' AND staff_members.name = '$person'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $approval = $row["workflow_approvals"];
    return $approval;
}

function update_form_submission_status($form_submission_id, $status) {
    // This function updates the status field in the form_submissions table
    // Replace the code below with your implementation
    $success = false;
    // Connect to the database
    $conn = get_db_connection();
    if ($conn) {
        // Prepare the update statement
        $stmt = mysqli_prepare($conn, "UPDATE form_submissions SET status = ? WHERE submission_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $status, $form_submission_id);
        // Execute the update statement
        $success = mysqli_stmt_execute($stmt);
        // Close the statement and the database connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    return $success;
}

function get_form_submission_workflow_approvals($form_submission_id) {
    // This function retrieves an array of all the staff members who have approved a form submission
    // Replace the code below with your implementation
    $conn = get_db_connection();
    $query = "SELECT * FROM form_submissions WHERE submission_id = '$form_submission_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $approvals = $row["workflow_approvals"];
    return $approvals;
}

function add_form_submission_to_completed_workflow($form_submission_id) {
    // This function adds a form submission to the completed_workflow archive lookup table
    // Replace the code below with your implementation
    $success1 = false;
    $success2 = false;

    // Connect to the database

    $conn = get_db_connection();
    if ($conn) {
        // Prepare the insert statement to move the form submission to completed_workflow
        $insert_query = "INSERT INTO completed_workflow SELECT * FROM form_submissions WHERE submission_id = ?";
        $insert_stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, 'i', $form_submission_id);
        $success1 = mysqli_stmt_execute($insert_stmt);
      
        // Prepare the delete statement to remove the form submission from form_submissions
        $delete_query = "DELETE FROM form_submissions WHERE submission_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, 'i', $form_submission_id);
        $success2 = mysqli_stmt_execute($delete_stmt);
      
        mysqli_close($conn);
      
       
      }
      
    return $success2 && $success1;
}

?>
