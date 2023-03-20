<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <nav>
            <div class="nav-left">
                <a href="#">Welcome, Admin User</a>
            </div>
            <div class="nav-right">
                <a href="logout.php">Logout</a>
            </div>
        </nav>
        <div class="main-content">
            <h1>Admin Dashboard</h1>
            <div class="options">
                <a href="all_forms.php">All Forms</a>
                <a href="incoming_forms.php">Incoming Forms</a>
                <a href="approved_forms.php">Approved Forms</a>
                <a href="create_forms.php">Create Forms</a>
            </div>
        </div>
    </div>
</body>
</html>

<style type="text/css">

.container {
    width: 80%;
    margin: 0 auto;
}
nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #f1f1f1;
}
nav a {
    color: #333;
    text-decoration: none;
    margin-left: 10px;
}
.main-content {
    padding: 20px;
}
.options {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
.options a {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}