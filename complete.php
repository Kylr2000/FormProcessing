<?php

// Connection details for the database
include 'header.php';

$conn = get_db_connection();


if(isset($_POST['student_id']) && isset($_POST['email']) && isset($_FILES['pdf_file']) && isset($_POST['form_type'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $form_type = mysqli_real_escape_string($conn, $_POST['form_type']);
    $date_submitted = mysqli_real_escape_string($conn, $_POST['date_submitted']);

    // check if a file was uploaded
    if (count($_FILES) > 0) {
        if (is_uploaded_file($_FILES['pdf_file']['tmp_name'])) {
            $imgData = file_get_contents($_FILES['pdf_file']['tmp_name']);
            $imgType = $_FILES['pdf_file']['type'];

            // prepare the statement to insert the file data into the form_submissions table
            $sql = "INSERT INTO form_submissions (form_pdf, form_type, student_id, email_address, date_submitted) VALUES (?, ?, ?, ?, ?)";
            $statement = $conn->prepare($sql);
            $statement->bind_param('sssss', $imgData, $form_type, $student_id, $email, $date_submitted);

            // execute the statement
            if ($statement->execute()) {
                echo "Form submission successful!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Error: No file uploaded or invalid file.";
        }
    }
}




// Get the workflow definition for the form

$query = "SELECT metadata FROM forms WHERE type = '$form_type'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$workflow = $row["metadata"];

// Convert the workflow definition from JSON to an array
$workflow_array = json_decode($workflow, true);




// Get the first person in the array and send them an email notification
$first_person = $workflow_array[0];
$to_email = get_staff_email_by_name($first_person); // get the email address of the staff member
$subject = 'New form submission for approval';
$message = 'A new form has been submitted and requires your approval. Please login to the form processing system to review the form.';
send_email($to_email, $subject, $message); // send the email notification

// Update the current_workflow field in the form_submissions table
$current_workflow = $first_person;

$query = "SELECT submission_id FROM form_submissions WHERE student_id = '$student_id' AND form_type = '$form_type' AND date_submitted = '$date_submitted'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$form_submission_id = $row["submission_id"];


update_form_submission_current_workflow($form_submission_id, $current_workflow);


// Close the statement and connection
$conn->close();


?>
