
<?php
include 'db.php';
// Connect to the database
$conn = get_db_connection();
$form_submission_id = $_GET['id'];
// Prepare the delete statement to remove the form submission from form_submissions
        $delete_query = "DELETE FROM completed_workflow WHERE submission_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, 'i', $form_submission_id);
        $success2 = mysqli_stmt_execute($delete_stmt);
        if ($succeess2 == true) {
            echo "Form $form_submission_id removed successfully.";
        } else {
            echo "Error: " . $delete_stmt->error;
        }

?>