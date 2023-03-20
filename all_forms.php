<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Forms</title>
    <meta charset="utf-8">
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
                <li><a href="all_forms.php">All Forms</a></li>
                <li><a href="approved_forms.php">Approved Forms</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <?php
        include "db.php";

        // Connect to the database
        $conn = get_db_connection();

        // Check for errors
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Select all rows from the form_submissions table
        $sql = "SELECT * FROM form_submissions";
        $result = mysqli_query($conn, $sql);
    ?>
   
    <div class="container">
    <h1>All Forms</h1>
    <p>Click on the "View" button to view the form. Click on the "Download" button to download the form. Click on the "Approve" button to approve the form. Click on the "Reject" button to reject the form.</p>
    <body>
    <table class="table table-bordered">
        <thead>
            <tr>
                
                <th>Form Type</th>
                <th>Student ID</th>
                <th>Email</th>
                <th>Date Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    
                    <td><?= $row['form_type'] ?></td>
                    <td><?= $row['student_id'] ?></td>
                    <td><?= $row['email_address'] ?></td>
                    <td><?= $row['date_submitted'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#view-form-<?= $row['submission_id'] ?>">View</button>
                        <div id="view-form-<?= $row['submission_id'] ?>" class="collapse">
                            <!-- Include code for displaying the form -->
                            <iframe src="view_form.php?id=<?= $row['submission_id'] ?>" style="width: 100%; height: 500px;"></iframe>
                        </div>
                        <a href='download_form.php?id=<?= $row['submission_id'] ?>' class="btn btn-primary" role="button">Download</a>
                        <a href='approve_form.php?id=<?= $row['submission_id'] ?>' class="btn btn-primary" role="button">Approve</a>
                        <a href='reject_form.php?id=<?= $row['submission_id'] ?>' class="btn btn-primary" role="button">Reject</a>
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