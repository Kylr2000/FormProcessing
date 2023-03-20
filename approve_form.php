<?php
    include 'header.php';
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
    

    
   

  
    
    // Get the form type from forms database in order to get the workflow definition
    $query = "SELECT form_type FROM form_submissions WHERE submission_id = '$submission_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $form_type = $row["form_type"];
    echo $form_type;


    $query = "SELECT metadata FROM forms WHERE type = '$form_type'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $workflow = $row["metadata"];
    echo $workflow;

    // Convert the workflow definition from JSON to an array
    $workflow_array = json_decode($workflow, true);
   

    $query = "SELECT email_address FROM form_submissions WHERE submission_id = '$submission_id' AND form_type = '$form_type'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $form_submission_id = $submission_id;
    $student_email = $row["email_address"];

    // check workflow array to see if the current user has already approved the form
    $workflow_approvals = get_form_submission_workflow_approvals($form_submission_id);

    echo $workflow_approvals;

    // Convert JSON string into array
    $workflow_approvals_true = json_decode($workflow_approvals, true);

    echo $workflow_approvals_true;
  



    //if the current user has approved the form, then move onto the next next_person in the workflow
    if ($user_name == $workflow_approvals_true) {
        // Get the next next_person in the workflow
        $next_person_index = array_search($user_name, $workflow_array) + 1;
        $next_person = $workflow_array[$next_person_index];
    }

    echo $next_person;



    // update the current_workflow column in the form_submissions table with the next next_person in the workflow
    update_form_submission_current_workflow($form_submission_id, $next_person);
    


        // Check if the next next_person is the last next_person in the workflow

        // Get the staff member's email address

    
    if ($next_person) {
    $to_email = get_staff_email_by_name($next_person);
    // Send an email notification to the staff member
    $subject = 'Form submission for approval';
    $message = 'A form submission requires your approval. Please login to the form processing system to review the form.';
    send_email($to_email, $subject, $message);
    }

    if (count($workflow_approvals_true) === count($workflow_array)) {
        // Add the form to the completed_workflow archive lookup table
        add_form_submission_to_completed_workflow($form_submission_id);
        
        // Send an email notification to the student that the form has been approved
        $to_email = $student_email;
        $subject = 'Form submission approved';
        $message = 'Your form submission has been approved. Thank you for submitting the form.';
        send_email($to_email, $subject, $message);
        
        // Update the form_submission status to 'approved'
        update_form_submission_status($form_submission_id, 'Approved');
    }

   


        // find the index of the next_person in the workflow array
    /*   $next_person_index = array_search($next_person, $workflow_array);


        
        // Get the previous next_person who approved the form
        $prev_person = $workflow_array[$next_person_index - 1];
        
        // Check if the previous approved the form
        $prev_approval = get_form_submission_workflow_approval($form_submission_id, $prev_person);
        
        if ($prev_approval != $next_person) {
            // Get the current approval status for this next_person
            $current_approval = get_form_submission_workflow_approval($form_submission_id, $next_person);
            
            // Check if this next_person has not yet approved the form
            if (!$current_approval) {
                // Send an email notification to the staff member
                $subject = 'Form submission for approval';
                $message = 'A form submission requires your approval. Please login to the form processing system to review the form.';
                send_email($to_email, $subject, $message);
            } else {
                // Update the current_workflow field in the form_submissions table
                $current_workflow = $next_person;
                update_form_submission_current_workflow($form_submission_id, $current_workflow);
                
                // Exit the loop until this next_person approves the form
                break;
            }
            
        } */
    

    // Check if the form has been approved by all necessary staff members or roles
    //$workflow_approvals = get_form_submission_workflow_approvals($form_submission_id);

    



       

    // Close the database connection
    $conn->close();
?>
