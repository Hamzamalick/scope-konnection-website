<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log file for debugging
file_put_contents('form_debug.log', "Form submitted at: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    file_put_contents('form_debug.log', "POST data received\n", FILE_APPEND);
    
    // Log all POST data
    foreach ($_POST as $key => $value) {
        file_put_contents('form_debug.log', "$key: $value\n", FILE_APPEND);
    }
    
    // Check if required fields exist
    if (!isset($_POST['first_name']) || !isset($_POST['second_name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
        echo "Missing required fields";
        file_put_contents('form_debug.log', "Missing required fields\n", FILE_APPEND);
        exit;
    }
    
    // Sanitize data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $second_name = htmlspecialchars(trim($_POST['second_name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : '';
    $message = htmlspecialchars(trim($_POST['message']));
    
    file_put_contents('form_debug.log', "Sanitized data - First: $first_name, Second: $second_name, Email: $email\n", FILE_APPEND);
    
    // Validation
    $errors = [];
    
    if (empty($first_name)) {
        $errors[] = "First name is required";
    }
    
    if (empty($second_name)) {
        $errors[] = "Second name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    if (!empty($errors)) {
        file_put_contents('form_debug.log', "Validation errors: " . implode(", ", $errors) . "\n", FILE_APPEND);
        echo implode(", ", $errors);
        exit;
    }
    
    // Try to send email
    $to = "info@scopesoftware.co.uk";
    $subject = "New Signup Form Submission";
    
    $email_content = "New Signup Form Submission:\n\n";
    $email_content .= "First Name: $first_name\n";
    $email_content .= "Second Name: $second_name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Message:\n$message\n";
    
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    file_put_contents('form_debug.log', "Attempting to send email to: $to\n", FILE_APPEND);
    
    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
        file_put_contents('form_debug.log', "Email sent successfully\n", FILE_APPEND);
        
        // Send confirmation to client
        $client_subject = "Thank you for your submission";
        $client_message = "Dear $first_name,\n\nThank you for contacting us. We have received your message and will get back to you shortly.\n\nBest regards,\nScope Software Team";
        $client_headers = "From: info@scopesoftware.co.uk\r\n";
        
        mail($email, $client_subject, $client_message, $client_headers);
        
        echo "success";
    } else {
        file_put_contents('form_debug.log', "Email failed to send\n", FILE_APPEND);
        echo "Email could not be sent. Please try again later.";
    }
    
} else {
    file_put_contents('form_debug.log', "Invalid request method: " . $_SERVER["REQUEST_METHOD"] . "\n", FILE_APPEND);
    echo "Invalid request method";
}
?>
