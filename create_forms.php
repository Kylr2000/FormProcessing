<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Create Forms</title>
        
    </head>
    <body>
        <nav>
            <div class="wrapper">
                <ul>
                    <li><img class="img-logo" src="UWI-Logo.jpg" alt="UWI Logo"></li>
                    <li><a href="Admin.php"> Home</a></li>
                    <li><a href="About.php"> About</a></li>
                    <li><a href="Logout.php"> Logout</a></li>
                </ul>
            </div>
        </nav>
        <div class="wrapper">
            <h1>
                Admin Dashboard
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            </h1>
            <body>
               
                </form>
                <form method="post" action="create.php" enctype="multipart/form-data">
                    <label>Select PDF File:</label>
                    <input type="file" name="pdf_file" required>
                    <br>
                    <label>Form Type:</label>
                    <input type="text" name="form_type" required>
                    <br>
                    <label>Workflow Definition:</label>
                    <input type="text" name="workflow_def" required>
                    <br>
                    <input type="submit" value="Upload">
                </form>

            </body>
        </div>
    </body>
    
    
</html>