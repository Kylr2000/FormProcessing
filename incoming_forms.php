<?php
// Connect to the database
require_once 'db_config.php';
$db = mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the logged in user's ID
$user_id = $_SESSION['user_id'];

// Query the database for all forms that require approval from the logged in user
$query = "SELECT * FROM form_submissions WHERE staff_id = $user_id AND status = 'pending'";
$result = mysqli_query($db, $query);

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
mysqli_close($db);
?>
