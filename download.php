<?php
   $db_host = "localhost";
   $db_user = "root";
   $db_password = "Hello";
   $db_name = "test1";
   
   // Connect to the database
   $db = mysqli_connect($db_host, $db_user,$db_password, $db_name);

   // Get the submission ID from the query string
   $form_id = $_GET['id'];
   $query = "SELECT file FROM forms WHERE id = '$form_id'";
   $result = mysqli_query($db, $query);
   if (mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_assoc($result);
   header("Content-Type: application/pdf");
   header("Content-Length: " . strlen($row['file']));
   header("Content-Disposition: attachment; filename=submission.pdf");
   echo $row['file'];
   } else {
       echo "No PDF file found for this submission.";
   }
   mysqli_close($db);
?>