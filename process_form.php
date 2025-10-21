<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $second_name = htmlspecialchars(trim($_POST['second_name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));
    
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
    
    // If no errors, process the form
    if (empty($errors)) {
        // Email settings
        $to = "info@scopesoftware.co.uk";
        $subject = "New Signup Form Submission";
        
        // Email content
        $email_content = "New Signup Form Submission:\n\n";
        $email_content .= "First Name: $first_name\n";
        $email_content .= "Second Name: $second_name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone: $phone\n";
        $email_content .= "Message:\n$message\n";
        
        // Email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Send email to you
        $mail_sent = mail($to, $subject, $email_content, $headers);
        
        // Send confirmation email to client
        if ($mail_sent) {
            $client_subject = "Thank you for your submission";
            $client_message = "Dear $first_name,\n\nThank you for contacting us. We have received your message and will get back to you shortly.\n\nBest regards,\nScope Software Team";
            
            $client_headers = "From: info@scopesoftware.co.uk\r\n";
            mail($email, $client_subject, $client_message, $client_headers);
        }
        
        // Return success response
        echo "success";
    } else {
        // Return errors
        echo implode(", ", $errors);
    }
} else {
    echo "Invalid request method";
}
?>
