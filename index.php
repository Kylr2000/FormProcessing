<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Form Processing</title>
        
    </head>
    <body>
        <nav>
            <div class="wrapper">
                <ul>
                    <li><img class="img-logo" src="UWI-Logo.jpg" alt="UWI Logo"></li>
                    <li><a href="index.php"> Home</a></li>
                    <li><a href="About.php"> About</a></li>
                    <li><a href="login_form.php"> Login</a></li>
                </ul>
            </div>
        </nav>
        <div class="wrapper">
            <h1>
                Student Dashboard
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            </h1>
            <body>
                <?php
                $db_host = "localhost";
                $db_user = "root";
                $db_password = "Hello";
                $db_name = "test1";
                        
                // Connect to the database
                $conn = mysqli_connect($db_host, $db_user,$db_password, $db_name);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve data from table
                $listforms = "SELECT type FROM forms";
                $results = $conn->query($listforms);

                if ($results->num_rows > 0) {
                    //output data table
                    echo "<table><tr><th>FormType</th><th>Download</th></tr>";
                    while($rows = $results->fetch_assoc()){
                        echo "<td>" . $rows["type"] . "</td>";
                        echo "<td><a href='download.php?type=" . $rows['type'] . "'>Download</a></td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No forms found!";
                }


                ?>
                
                <form method="post" action="workflow3.php" enctype="multipart/form-data">
                    <label>Select PDF File:</label>
                    <input type="file" name="pdf_file" required>
                    <br>
                    <label>Student ID:</label>
                    <input type="text" name="student_id" required>
                    <br>
                    <label>Email:</label>
                    <input type="email" name="email" required>
                    <br>
                    <label for="Form Type" >Choose a form type:</label>
                    <select id="Form Type" name="form_type" required>
                    <?php
                        
                            // Query the database for form types
                            $sql = "SELECT DISTINCT type FROM forms";
                            $result = $conn->query($sql);

                            // If query is successful and rows are returned, populate the select element with options
                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["type"] . "'>" . $row["type"] . "</option>";
                                }
                            } 

                            // Close database connection
                            $conn->close();
                        ?>
                    </select>
                    <br>
                    <label>Date:</label>
                    <input type="text" name="date_submitted" required>
                    <br>
                    <input type="submit" value="Upload">
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
    background-color: #333;
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


