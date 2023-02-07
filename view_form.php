<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "Hello";
    $db_name = "test1";
    
    // Connect to the database
    $db = mysqli_connect($db_host, $db_user,$db_password, $db_name);
    
    // Get the submission ID from the query string
    $submission_id = $_GET['id'];
    $query = "SELECT form_pdf FROM form_submissions WHERE submission_id = '$submission_id'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    header("Content-Type: application/pdf");
    header("Content-Length: " . strlen($row['form_pdf']));
    header("Content-Disposition: inline; filename=submission.pdf");
    echo $row['form_pdf'];
    } else {
        echo "No PDF file found for this submission.";
    }
    mysqli_close($db);
?>
