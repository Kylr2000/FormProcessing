<?php

// Connection details for the db
include 'db.php';

// Get a new database connection object
$conn = get_db_connection();

// Get the workflow definition for the form
$form_type = $_POST["form_type"];
$query = "SELECT metadata FROM forms WHERE type = '$form_type'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$workflow = $row["metadata"];

// Convert the workflow definition from JSON to an array
$workflow_array = json_decode($workflow, true);


// find if the name Admin is in the array switch case
switch($workflow_array) {
    case in_array("Advisor", $workflow_array):
        // get student email from the form submission and match it with the staff member from staff database
        $student_email = $_POST['email'];
        // Query to retrieve the staff user information
        $query = "SELECT * FROM staff_members WHERE student_email = '$student_email'";
        // Execute the query
        $result = mysqli_query($conn, $query);
        // Check if a staff user was found
        if (mysqli_num_rows($result) > 0) {
            // Retrieve the staff user information
            $row = mysqli_fetch_assoc($result);
            $staff_email = $row['email'];
            $staff_name = $row['name'];
            // Form the email headers
            $to = $staff_email;
            $subject = "Advisory Form";
            $message = "Dear $staff_name,\n\nPlease find attached the Advisory Form for a student.\n\nBest regards,\nAdvisory Team";
            $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>";
            //send email
            if(mail($to, $subject, $message, $headers)){
                // Email was sent successfully
                echo $first_name;
            } else {
                // Email sending failed
                echo "Error sending the advisory form to $firstname. Please try again later.";
            }
            echo "Advisor is in the array";
        }

        break;
    case in_array("Dean", $workflow_array)://same as advising form
        echo "Dean is in the array";
        break;
    case in_array("Admin", $workflow_array):
        echo "Admin is in the array";
        break;
    case in_array("Student", $workflow_array):
        echo "Student is in the array";
        break;
    default:
        echo "No user in the array";
        break;
}

$conn->close();

?>
