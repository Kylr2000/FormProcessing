<?php
// Start session
session_start();



// Database connection file
require_once "db.php";
// Get a new database connection object
$conn = get_db_connection();

if(isset($_POST['username']) && isset($_POST['password'])) {
        function validate($data){
            $data = trim($data);
    
            $data = stripslashes($data);
    
            $data = htmlspecialchars($data);
    
            return $data;
    
        }


    $user_name = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($user_name)) {

        header("Location: index.php?error=User Name is required");

        exit();

    }else if(empty($password)){

        header("Location: index.php?error=Password is required");

        exit();

    }

    else{
            // Compare username and password with what is in the database
            $sql = "SELECT * FROM users WHERE username = '$user_name' and password = '$password'";
            $result = mysqli_query($conn, $sql);


            if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if($row['username'] === $user_name && $row['password'] === $password){
                
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['userid'];
                $_SESSION['type'] = $row['type'];
                // Redirect user to their dashboard
                $user_type = $row['type'];
                if($user_type == "admin") {
                    header("Location: Admin.php");
                    $query = "UPDATE users SET last_login_time = NOW() WHERE username = '$user_name'";
                    $result = mysqli_query($conn, $query);
                    exit();
                } else if($user_type == "staff") {
                    header("Location: Staff.php");
                    $query = "UPDATE users SET last_login_time = NOW() WHERE username = '$user_name'";
                    $result = mysqli_query($conn, $query);
                    exit();
                }
           

            }
            else{
                header("Location: index.php?error=Incorect User name or password");

                exit();
                
            }
        }
    }
}

else {
    header("Location: index.php");

    exit();
}
                    
                
         
        
    
    
    // Close connection
    $conn->close();

?>


