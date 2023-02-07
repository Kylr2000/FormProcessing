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
                    <li><a href="Login.php"> Login</a></li>
                </ul>
            </div>
        </nav>
        <div class="wrapper">
            <h1>
                Student Dashboard
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            </h1>
            <body>
                <form action="download.php" method="post">
                     <input type="submit" name="submit" value="Download File" />
                </form>
                <form method="post" action="workflow.php" enctype="multipart/form-data">
                    <label>Select PDF File:</label>
                    <input type="file" name="pdf_file" required>
                    <br>
                    <label>Student ID:</label>
                    <input type="text" name="student_id" required>
                    <br>
                    <label>Email:</label>
                    <input type="email" name="email" required>
                    <br>
                    <label>Form Type:</label>
                    <input type="text" name="form_type" required>
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


