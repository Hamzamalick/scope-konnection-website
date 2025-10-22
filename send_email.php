<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    
    // Email details
    $to = "zarghamabass2222@gmail.com";
    $subject = "New Contact Form Submission from $first_name $last_name";
    
    // Email content
    $email_content = "New contact form submission:\n\n";
    $email_content .= "First Name: $first_name\n";
    $email_content .= "Last Name: $last_name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Message:\n$message\n";
    
    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Send email
    if (mail($to, $subject, $email_content, $headers)) {
        // Success message
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Message Sent</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f7fa; }
                .success { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 500px; margin: 0 auto; }
                .btn { background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='success'>
                <h2>Thank You!</h2>
                <p>Your message has been sent successfully. We'll get back to you soon.</p>
                <a href='contact.html' class='btn'>Back to Contact Form</a>
            </div>
        </body>
        </html>";
    } else {
        // Error message
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Error</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f7fa; }
                .error { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); max-width: 500px; margin: 0 auto; }
                .btn { background: #e74c3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class='error'>
                <h2>Sorry</h2>
                <p>There was an error sending your message. Please try again or email us directly.</p>
                <a href='contact.html' class='btn'>Back to Contact Form</a>
            </div>
        </body>
        </html>";
    }
} else {
    // Redirect if accessed directly
    header("Location: contact.html");
    exit();
}
?>
