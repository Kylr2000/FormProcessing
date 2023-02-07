<?php
// Connection details for the database
$db_host = "localhost";
$db_user = "root";
$db_password = "Hello";
$db_name = "test1";

// Connect to the database
$db = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check the connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the student's email address
$student_email = $_POST['email'];

// Query to retrieve the staff user information
$query = "SELECT * FROM staff_members WHERE student_email = '$student_email'";

// Execute the query
$result = mysqli_query($db, $query);

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
    $headers = "From: Advisory Team <kyle.jaimungal@gmail.com>" . "\r\n" .
               "Reply-To: Advisory Team <kyle.jaimungal@gmail.com>" . "\r\n" .
               "MIME-Version: 1.0" . "\r\n" .
               "Content-Type: text/plain; charset=UTF-8" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Attach the form to the email
    $pdf = $_FILES['pdf_file'];
    $pdf_content = file_get_contents($pdf['tmp_name']);
    $pdf_encoded = chunk_split(base64_encode($pdf_content));

    // Form the email body
    $body = "--PHP-mixed-".uniqid()."\r\n" .
            "Content-Type: text/plain; charset=UTF-8\r\n" .
            "Content-Transfer-Encoding: 7bit\r\n\r\n" .
            $message . "\r\n\r\n" .
            "--PHP-mixed-".uniqid()."\r\n" .
            "Content-Type: application/pdf; name=\"form.pdf\"\r\n" .
            "Content-Transfer-Encoding: base64\r\n" .
            "Content-Disposition: attachment\r\n\r\n" .
            $pdf_encoded . "\r\n" . "--";
        
                // Send the email
    if (mail($to, $subject, $body, $headers)) {
        // Email was sent successfully
        echo "Advisory form sent to $staff_name ($staff_email) successfully.";
    } else {
        // Email sending failed
        echo "Error sending the advisory form to $staff_name ($staff_email). Please try again later.";
    }
}  

else {
    // No staff user was found with the specified email address
    echo "No staff user was found with the email address '$student_email'.";
}

// Close the database connection
mysqli_close($db);
?>

