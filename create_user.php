<!DOCTYPE html>
<html lang="en">
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
                <li><a href="#">Welcome, Admin User</a></li>
                <li><a href="Admin.php"> Home</a></li>
                <li><a href="Approveforms_admin.php">Approved Forms</a></li>
                <li><a href="create_forms.php">Create Forms</a></li>
                <li><a href="create_user.php">Create New User</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    
    <?php
    // Database connection file
    include "db.php";
    // Get a new database connection object
    $conn = get_db_connection();
    ?>



<div class="wrapper">
    <h2>Create New User</h2>
    <p>Fill out the information below then, click on the "Add User" button to create a new user.</p>
    <body>
    </form>
        <form class="form-horizontal" method="post" action="create_users.php" enctype="multipart/form-data">
                <label class="control-label col-sm2">Username:</label>
                <input class="form-control" type="text" name="username" required>
                <br>
                <label class="control-label col-sm2">Password:</label>
                <input class="form-control" type="password" name="password" required>
                <br>
                <label class="control-label col-sm2">Email:</label>
                <input class="form-control" type="email" name="email" required>
                <br>
                <label class="control-label col-sm2">Role:</label>
                <input class="form-control" type="text" name="role" required>
                <br>
                <label class="control-label col-sm2">User Type:</label>
                <select class="form-control" name="type" required>
                    <option value="admin">admin</option>
                    <option value="staff">staff</option>
                </select>
                <br>
                <label for="course_id" class="control-label col-sm2">Choose Course Code:</label>
                <select class="form-control" name="course_id" id="course_id" required>
                    <option value="">Select Course</option>
                    <?php
                    $sql = "SELECT * FROM course_code";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['course_id'] . "'>" . $row['Course_Code'] . "</option>";
                    }
                    ?>
                </select>
                <br>
                <button class="btn btn-primary btn-block" type="submit">Add User</button>
    </form>
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