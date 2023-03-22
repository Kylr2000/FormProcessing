<?php

// Connection details for the co$conn
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


// find if the name Advisor is in the array switch case
switch($workflow_array) {
    case in_array("Advisor", $workflow_array):
        date_default_timezone_set('America/New_York');

        if(isset($_POST['student_id']) && isset($_FILES['pdf_file']) && isset($_POST['form_type'])) {
            $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $form_type = mysqli_real_escape_string($conn, $_POST['form_type']);
            $date_submitted = date('Y-m-d H:i:s');
        
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


        // get student email from the form submission and match it with the staff member from staff database
        $student_email = $_POST['email'];
        // Query to retrieve the staff user information
        $query = "SELECT * FROM staff_members WHERE student_email = '$student_email'AND role = 'Advisor'";
        // Execute the query
        $result = mysqli_query($conn, $query);
        // Check if a staff user was found
        if (mysqli_num_rows($result) > 0) {
            // Retrieve the staff user information
            $row = mysqli_fetch_assoc($result);
            $staff_email = $row['email'];
            $staff_name = $row['name'];
            // Form the email headers
            $to = $staff_email;
            $subject = "$form_type";//course map same as advising form
            $message = "Dear $staff_name,\n\nPlease find attached the $form_type for a student.\n\nBest regards,\nAdvisory Team";
            $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
            //send email
            if(mail($to, $subject, $message, $headers)){
                // Email was sent successfully
                echo "Thank you for submitting the form to $staff_name.";
            } else {
                // Email sending failed
                echo "Error sending the form to $staff_name. Please try again later.";
            }
        }

        break;
    case in_array("Dean", $workflow_array)://Transfer coursework form
        date_default_timezone_set('America/New_York');

        if(isset($_POST['student_id']) && isset($_FILES['pdf_file']) && isset($_POST['form_type'])) {
            $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $form_type = mysqli_real_escape_string($conn, $_POST['form_type']);
            $date_submitted = date('Y-m-d H:i:s');
        
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

        // get student email from the form submission and match it with the staff member from staff database
        $student_email = $_POST['email'];
        // Query to retrieve the staff user information based on if the staff role matches the Dean role in the array
        $query = "SELECT * FROM staff_members WHERE student_email = '$student_email' AND role = 'Dean'";
        // Execute the query
        $result = mysqli_query($conn, $query);
        // Check if a staff user was found
        if (mysqli_num_rows($result) > 0) {
            // Retrieve the staff user information
            $row = mysqli_fetch_assoc($result);
            $staff_email = $row['email'];
            $staff_name = $row['name'];
            // Form the email headers
            $to = $staff_email;
            $subject = "$form_type";
            $message = "Dear $staff_name,\n\nPlease find attached the $form_type for a student.\n\nBest regards,\nAdvisory Team";
            $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
            //send email
            if(mail($to, $subject, $message, $headers)){
                // Email was sent successfully
                echo $staff_name;
            } else {
                // Email sending failed
                echo "Error sending the $form_type to $staff_name. Please try again later.";
            }
        }
        echo " Dean has received the form";
        break;
    case in_array("HOD", $workflow_array):
        date_default_timezone_set('America/New_York');

        if(isset($_POST['student_id']) && isset($_FILES['pdf_file']) && isset($_POST['form_type'])) {
            $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $form_type = mysqli_real_escape_string($conn, $_POST['form_type']);
            $date_submitted = date('Y-m-d H:i:s');
        
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

         // get student email from the form submission and match it with the staff member from staff database
         $student_email = $_POST['email'];
         // Query to retrieve the staff user information based on if the staff role matches the Dean role in the array
         $query = "SELECT * FROM staff_members WHERE role = 'HOD'";
         // Execute the query
         $result = mysqli_query($conn, $query);
         // Check if a staff user was found
         if (mysqli_num_rows($result) > 0) {
             // Retrieve the staff user information
             $row = mysqli_fetch_assoc($result);
             $staff_email = $row['email'];
             $staff_name = $row['name'];
             // Form the email headers
             $to = $staff_email;
             $subject = "$form_type";
             $message = "Dear $staff_name,\n\nPlease find attached the $form_type for a student.\n\nBest regards,\nAdvisory Team";
             $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
             //send email
             if(mail($to, $subject, $message, $headers)){
                 // Email was sent successfully
                 echo $staff_name;
             } else {
                 // Email sending failed
                 echo "Error sending the $form_type to $staff_name. Please try again later.";
             }
         }
        echo " HOD has recieved the form";
        break;
    case in_array("Admin", $workflow_array):
        date_default_timezone_set('America/New_York');

        if(isset($_POST['student_id']) && isset($_FILES['pdf_file']) && isset($_POST['form_type'])) {
            $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $form_type = mysqli_real_escape_string($conn, $_POST['form_type']);
            $date_submitted = date('Y-m-d H:i:s');
        
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

        // get student email from the form submission and match it with the staff member from staff database
        $student_email = $_POST['email'];
        // Query to retrieve the staff user information based on if the staff role matches the Dean role in the array
        $query = "SELECT * FROM staff_members WHERE role = 'Admin'";
        // Execute the query
        $result = mysqli_query($conn, $query);
        // Check if a staff user was found
        if (mysqli_num_rows($result) > 0) {
            // Retrieve the staff user information
            $row = mysqli_fetch_assoc($result);
            $staff_email = $row['email'];
            $staff_name = $row['name'];
            // Form the email headers
            $to = $staff_email;
            $subject = "$form_type";
            $message = "Dear $staff_name,\n\nPlease find attached the $form_type for a student.\n\nBest regards,\nAdvisory Team";
            $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
            //send email
            if(mail($to, $subject, $message, $headers)){
                // Email was sent successfully
                echo $staff_name;
            } else {
                // Email sending failed
                echo "Error sending the $form_type to $staff_name. Please try again later.";
            }
        }
        echo " Admin has recieved the form";
        break;
    case in_array("Course Lecturer", $workflow_array):
        date_default_timezone_set('America/New_York');

        if(isset($_POST['student_id']) && isset($_FILES['pdf_file']) && isset($_POST['form_type'])) {
            $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $form_type = mysqli_real_escape_string($conn, $_POST['form_type']);
            $date_submitted = date('Y-m-d H:i:s');
        
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

        // get student email from the form submission and match it with the staff member from staff database
        $course_code = $_POST['course_code'];
        // Query to retrieve the staff user information based on if the staff role matches role in the table
        $query = "SELECT * FROM course_code, users WHERE course_code.Course Code = '$course_code' AND users.role = 'Course Lecturer'";
        // Execute the query
        $result = mysqli_query($conn, $query);
        // Check if a staff user was found
        if (mysqli_num_rows($result) > 0) {
            // Retrieve the staff user information
            $row = mysqli_fetch_assoc($result);
            $staff_email = $row['email'];
            $staff_name = $row['name'];
            // Form the email headers
            $to = $staff_email;
            $subject = "$form_type";
            $message = "Dear $staff_name,\n\nPlease find attached the $form_type for a student.\n\nBest regards,\nAdvisory Team";
            $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
            //send email
            if(mail($to, $subject, $message, $headers)){
                // Email was sent successfully
                echo $staff_name;
            } else {
                // Email sending failed
                echo "Error sending the $form_type to $staff_name. Please try again later.";
            }
        }
        echo " Course Lecturer has recieved the form";
        break;
    default:
        date_default_timezone_set('America/New_York');

        if(isset($_POST['student_id']) && isset($_FILES['pdf_file']) && isset($_POST['form_type'])) {
            $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $form_type = mysqli_real_escape_string($conn, $_POST['form_type']);
            $date_submitted = date('Y-m-d H:i:s');
        
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
                        echo $date_submitted;
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

        echo " Form Submitted to staff members";
    break;
    
}

$conn->close();

?>