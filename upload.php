<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "Hello";
$db_name = "test1";

// Connect to the database
$db = mysqli_connect($db_host, $db_user,$db_password, $db_name);

// Check if the connection was successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error()); 
}

if(isset($_POST['student_id']) && isset($_POST['email']) && isset($_FILES['pdf_file']) && isset($_POST['form_type'])) {
    $student_id = mysqli_real_escape_string($db, $_POST['student_id']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $form_type = mysqli_real_escape_string($db, $_POST['form_type']);
    $date_submitted = mysqli_real_escape_string($db, $_POST['date_submitted']);

    // check if a file was uploaded
    if (count($_FILES) > 0) {
        if (is_uploaded_file($_FILES['pdf_file']['tmp_name'])) {
            $imgData = file_get_contents($_FILES['pdf_file']['tmp_name']);
            $imgType = $_FILES['pdf_file']['type'];

            // prepare the statement to insert the file data into the form_submissions table
            $sql = "INSERT INTO form_submissions (form_pdf, form_type, student_id, email_address, date_submitted) VALUES (?, ?, ?, ?, ?)";
            $statement = $db->prepare($sql);
            $statement->bind_param('sssss', $imgData, $form_type, $student_id, $email, $date_submitted);

            // execute the statement
            if ($statement->execute()) {
                echo "Form submission successful!";
            } else {
                echo "Error: " . mysqli_error($db);
            }
        } else {
            echo "Error: No file uploaded or invalid file.";
        }
    }
}

mysqli_close($db);
?>



?>