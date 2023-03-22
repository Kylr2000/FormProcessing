<?php
    include "db.php";

    // Get a new database connection object
    $conn = get_db_connection();
    
    
    // Get the submission ID from the query string
    $submission_id = $_GET['id'];
    $query = "SELECT form_pdf FROM completed_workflow WHERE submission_id = '$submission_id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    header("Content-Type: application/pdf");
    header("Content-Length: " . strlen($row['form_pdf']));
    header("Content-Disposition: inline; filename=submission.pdf");
    echo $row['form_pdf'];
    } else {
        echo "No PDF file found for this submission.";
    }
    mysqli_close($conn);
?>
