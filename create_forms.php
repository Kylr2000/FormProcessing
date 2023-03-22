<!DOCTYPE html>
<html lang="en"> 
    <head>
        <meta charset="utf-8">
        <title>Create Forms</title>
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
                    <li><a href="approved_forms.php">Approved Forms</a></li>
                    <li><a href="create_forms.php">Create Forms</a></li>
                    <li><a href="create_user.php">Create New User</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="wrapper">
            <h1>Create New Forms</h1>
            <p>Fill out the information below then, click on the "Create Form" button to create a new form.</p>
            <body>
                </form>
                <form class="form-horizontal" method="post" action="create.php" enctype="multipart/form-data">
                    <label class="control-label col-sm2">Select PDF File:</label>
                    <input class="form-control" type="file" name="pdf_file" required>
                    <br>
                    <label class="control-label col-sm2">Form Type:</label>
                    <input class="form-control" type="text" name="form_type" required>
                    <br>
                    <label class="control-label col-sm2">Workflow Definition:</label>
                    <input class="form-control" type="text" name="workflow_def" required>
                    <br>
                    <button class="btn btn-primary btn-block" type="submit">Create Form</button>
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