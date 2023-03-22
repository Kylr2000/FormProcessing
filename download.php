<?php
    include "db.php";
    // Get a new database connection object
    $conn = get_db_connection();


   // Get the submission ID from the query string
   $form_type = $_GET['type'];
   $query = "SELECT file FROM forms WHERE type = '$form_type'";
   $result = mysqli_query($conn, $query);
   if (mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_assoc($result);
   header("Content-Type: application/pdf");
   header("Content-Length: " . strlen($row['file']));
   header("Content-Disposition: attachment; filename=submission.pdf");
   echo $row['file'];
   } else {
       echo "No PDF file found for this submission.";
   }
   mysqli_close($conn);
?>