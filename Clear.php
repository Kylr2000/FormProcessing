<?php
    include "db.php";
    // Connect to the database
    $conn = get_db_connection();
    // Check for errors
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // GET date submitted from the admin_inbox table
    $date_submitted = $_GET['created_at'];

    // Delete rows from the admin_inbox table
    $sql = "DELETE FROM admin_inbox WHERE created_at = '$date_submitted'";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
    // Close the database connection
    mysqli_close($conn)


?>