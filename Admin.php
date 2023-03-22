<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <nav>
        <div class="wrapper">
            <ul>
                <li><a href="#">Welcome, Staff User</a></li>
                <li><a href="Admin.php"> Home</a></li>
                <li><a href="allforms_admin.php">All Forms</a></li>
                <li><a href="Approveforms_admin.php">Approved Forms</a></li>
                <li><a href="create_forms.php">Create Forms</a></li>
                <li><a href="create_user.php">Create New User</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="wrapper">
    <h1>
        Admin Dashboard
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </h1>

            <?php
            include "db.php";            
            // Connect to database
            $conn = get_db_connection();

            // Query to get staff users who haven't logged in for 7 days
            $sql = "SELECT * FROM users WHERE type = 'staff' AND last_login_time < DATE_SUB(NOW(), INTERVAL 1 HOUR)";
            $result = mysqli_query($conn, $sql);

            // put the result set into an array
            $users = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row['username'];
            }
            // Send notification to admin user dashboard
            if (!empty($users)) {
            $message = count($users) . " staff user(s) haven't logged in for 7 days.";
            //convert array to JSON
            $usernames = json_encode($users);
            $date_submitted = date('Y-m-d H:i:s');
            // Insert notification into the database
            $stmt = $conn->prepare("INSERT INTO admin_inbox (username, message, created_at) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $usernames, $message, $date_submitted);
            $stmt->execute();
            $stmt->close();
            }
        ?>


    <?php

        // Check for errors
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Select all rows from the form_submissions table
        $sql = "SELECT * FROM admin_inbox";
        $result = mysqli_query($conn, $sql);
    ?>


    <h2>My Inbox</h2>
    <p> This is the admin inbox. You recieve notices from the system here if a user has not been active. You can clear a notice once it has been resolved by clicking the "Clear" button.</p>
    <body>
    <table class="table table-bordered">
        <thead>
            <tr>
                
                <th>Usernames</th>
                <th>Message</th>
                <th>Date Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['message'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href='Clear.php?created_at=<?= $row['created_at'] ?>' class="btn btn-primary" role="button">Clear</a>
                    </td>
                </tr>
            <?php endwhile ?>
        </tbody>
    </table>
    <?php 
        // Close the database connection
        mysqli_close($conn) 
    ?>
    </body>
    </div>
</body>
</html>

<style type="text/css">
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

nav {
    background-color: #0047AB;
    color: #fff;
    padding: 10px;
}

nav ul {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    justify-content: space-evenly;
}

nav li {
    display: inline-block;
    margin-right: 100px;
    line-height: 50px;
}

nav a {
    color: #fff;
    text-decoration: none;
}

nav img.img-logo {
    width: 50px;
    height: 50px;
}

.wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

h1 {
    text-align: center;
    padding: 20px;
}


ul li a:hover {
    color: red;
}