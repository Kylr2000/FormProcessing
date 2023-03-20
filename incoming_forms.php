<?php
// Database connection file
include "db.php";
session_start();

// Get a new database connection object
$conn = get_db_connection();

if (!isset($_SESSION['username'])) {
  // Redirect to login page if user is not logged in
  echo "You are not logged in. Redirecting to login page...";
  exit();
}

// Get the logged in user's ID
$user_name = $_SESSION['username'];

// Query the database for all forms that require approval from the logged in user
$query = "SELECT * FROM form_submissions, staff_members WHERE form_submissions.email_address = staff_members.student_email AND name = '$user_name'";
$result = mysqli_query($conn, $query);

// Display the forms in a table
echo '<table>';
echo '<tr>
    <th>Form ID</th>
    <th>Form Type</th>
    <th>Student ID</th>
    <th>Email</th>
    <th>Date Submitted</th>
    <th>Actions</th>
  </tr>';

while ($form = mysqli_fetch_assoc($result)) {
    echo '<tr>
        <td>' . $form['id'] . '</td>
        <td>' . $form['form_type'] . '</td>
        <td>' . $form['student_id'] . '</td>
        <td>' . $form['email'] . '</td>
        <td>' . $form['date_submitted'] . '</td>
        <td>
          <a href="view_form.php?form_id=' . $form['id'] . '">View</a>
          <a href="approve_form.php?form_id=' . $form['id'] . '">Approve</a>
          <a href="reject_form.php?form_id=' . $form['id'] . '">Reject</a>
        </td>
      </tr>';
}
echo '</table>';

mysqli_free_result($result);
mysqli_close($conn);
?>
