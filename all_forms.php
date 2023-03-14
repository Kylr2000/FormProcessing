<!DOCTYPE html>
<html>
<head>
    <title>All Forms</title>
</head>
<body>
    <nav>
        <p>Welcome, Staff User</p>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>All Forms</h1>

    <table>
        <tr>
            <th>Form ID</th>
            <th>Form Type</th>
            <th>Student ID</th>
            <th>Email</th>
            <th>Date Submitted</th>
            <th>Actions</th>
        </tr>
        <?php
            $db_host = "localhost";
            $db_user = "root";
            $db_password = "Hello";
            $db_name = "test1";
            // Connect to the database
            $db = mysqli_connect($db_host, $db_user,$db_password, $db_name);
            $sql = "SELECT * FROM form_submissions";
            $result = mysqli_query($db, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['submission_id'] . "</td>";
                echo "<td>" . $row['form_type'] . "</td>";
                echo "<td>" . $row['student_id'] . "</td>";
                echo "<td>" . $row['email_address'] . "</td>";
                echo "<td>" . $row['date_submitted'] . "</td>";
                echo "<td><a href='view_form.php?id=" . $row['submission_id'] . "'>View</a> | <a href='download_form.php?id=" . $row['submission_id'] . "'>Download</a> | <a href='approve_form.php?id=" . $row['submission_id'] . "'>Approve</a> | <a href='reject_form.php?id=" . $row['submission_id'] . "'>Reject</a> </td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>
