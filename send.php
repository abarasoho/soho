<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Destination email explicitly set for the client
    $to = "info@abara.co.uk"; 
    
    // 2. Collect and clean incoming form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    
    // Validate that fields aren't empty
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?status=error");
        exit;
    }
    
    // 3. Construct the email content
    $subject = "New Subscriber - Aba Ra! Soho";
    
    $message = "You have a new subscriber from the landing page:\n\n";
    $message .= "Name: " . $name . "\n";
    $message .= "Email: " . $email . "\n";
    
    // 4. Set secure email headers using the matching domain to prevent spam filters
    $headers = "From: Aba Ra Website <no-reply@abara.co.uk>\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // 5. Send the mail and redirect back with a success flag
    if (mail($to, $subject, $message, $headers)) {
        header("Location: index.html?status=success");
        exit;
    } else {
        header("Location: index.html?status=error");
        exit;
    }
} else {
    // Redirect hackers or accidental visitors back to the landing page
    header("Location: index.html");
    exit;
}
?>