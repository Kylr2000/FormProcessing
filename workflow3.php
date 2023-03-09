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


// find if the name Admin is in the array switch case
switch($workflow_array) {
    case in_array("Advisor", $workflow_array):
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
            $subject = "Advisory and Course Map Form";//course map same as advising form
            $message = "Dear $staff_name,\n\nPlease find attached the Advisory and CourseMap Form for a student.\n\nBest regards,\nAdvisory Team";
            $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
            //send email
            if(mail($to, $subject, $message, $headers)){
                // Email was sent successfully
                echo $staff_name;
            } else {
                // Email sending failed
                echo "Error sending the form to $staff_name. Please try again later.";
            }
            echo " Advisor form submission successful!";
        }

        break;
    case in_array("Dean", $workflow_array)://Transfer coursework form
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
            $subject = "Form Submission";
            $message = "Dear $staff_name,\n\nPlease find attached the Form for a student.\n\nBest regards,\nAdvisory Team";
            $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
            //send email
            if(mail($to, $subject, $message, $headers)){
                // Email was sent successfully
                echo $staff_name;
            } else {
                // Email sending failed
                echo "Error sending the course map form to $staff_name. Please try again later.";
            }
        }
        echo " Dean has received the form";
        break;
    case in_array("HOD", $workflow_array):
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

         // get student email from the form submission and match it with the staff member from staff database
         $student_email = $_POST['email'];
         // Query to retrieve the staff user information based on if the staff role matches the Dean role in the array
         $query = "SELECT * FROM staff_members WHERE student_email = '$student_email' AND role = 'HOD'";
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
             $subject = "Course Map Form";
             $message = "Dear $staff_name,\n\nPlease find attached the Course Map Form for a student.\n\nBest regards,\nAdvisory Team";
             $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
             //send email
             if(mail($to, $subject, $message, $headers)){
                 // Email was sent successfully
                 echo $staff_name;
             } else {
                 // Email sending failed
                 echo "Error sending the course map form to $staff_name. Please try again later.";
             }
         }
        echo " HOD has recieved the form";
        break;
    case in_array("Admin", $workflow_array):
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

        // get student email from the form submission and match it with the staff member from staff database
        $student_email = $_POST['email'];
        // Query to retrieve the staff user information based on if the staff role matches the Dean role in the array
        $query = "SELECT * FROM staff_members WHERE student_email = '$student_email' AND role = 'Admin'";
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
            $subject = "Form Submission";
            $message = "Dear $staff_name,\n\nPlease find attached the Form for a student.\n\nBest regards,\nAdvisory Team";
            $headers = "From: Advisory Team <kyle.jaimungal@gmail.con>";
            //send email
            if(mail($to, $subject, $message, $headers)){
                // Email was sent successfully
                echo $staff_name;
            } else {
                // Email sending failed
                echo "Error sending the course map form to $staff_name. Please try again later.";
            }
        }
        echo " Admin has recieved the form";
        break;
    default:
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
    
        
        // get student email from form submission and match it with the staff member from staff database
        //$student_email = $_POST['email'];
        // Loop through each step in the workflow array
        
        foreach ($workflow_array as $step) {
            // Query to recieve the staff member associated with this step from the database
            $query = "SELECT * FROM staff_members WHERE name = '$step'";
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
                $subject = "Form Submission";
                $message = "Dear $staff_name,\n\nPlease find form submission for a student.\n\nBest regards,\nAdvisory Team";
                $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
                //send email
                if(mail($to, $subject, $message, $headers)){
                    // Email was sent successfully
                    echo $staff_name;
                } else {
                    // Email sending failed
                    echo "Error sending the form to $staff_name. Please try again later.";
                }
            }
        }

        echo " Form Submitted to staff members";
        break;
    
}

$conn->close();

?>