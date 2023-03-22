<?php
   include "db.php";
   // Connect to the database 
   $conn = get_db_connection();

    

    // Check for errors
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

        // Get the form data
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $type = $_POST['type'];
        $role = $_POST['role'];
        $course_id = $_POST['course_id'];

        // Insert the data into the users table
        $sql = "INSERT INTO users (username, password, email, type, role, course_id) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $conn->prepare($sql);
        $statement->bind_param('ssssss', $username, $password, $email, $type, $role, $course_id);
        $result = $statement->execute();
        // Check for errors
        if ($result === false) {
            echo "Error: " . mysqli_error($conn);
        } else {
            echo "User added successfully!";
        }
?>