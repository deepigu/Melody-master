<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $story = $_POST['story'] ?? '';
    $preferences = $_POST['preferences'] ?? '';
    $package = $_POST['package'] ?? '';

    // Email settings
    $to = "deekarunakaran@gmail.com"; // Your email address
    $subject = "New Song Request from " . htmlspecialchars($name);

    // Create email body
    $message = "New Song Request Details:\n\n";
    $message .= "Name: " . htmlspecialchars($name) . "\n";
    $message .= "Email: " . htmlspecialchars($email) . "\n";
    $message .= "Phone: " . htmlspecialchars($phone) . "\n";
    $message .= "Package Selected: " . htmlspecialchars($package) . "\n\n";
    $message .= "Story:\n" . htmlspecialchars($story) . "\n\n";
    $message .= "Music Preferences:\n" . htmlspecialchars($preferences) . "\n";

    // Email headers
    $headers = "From: " . htmlspecialchars($email) . "\r\n";
    $headers .= "Reply-To: " . htmlspecialchars($email) . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send email
    $mailSent = mail($to, $subject, $message, $headers);

    // Send confirmation email to customer
    $customerSubject = "Thank you for your song request - Melody Master Co";
    $customerMessage = "Dear " . htmlspecialchars($name) . ",\n\n";
    $customerMessage .= "Thank you for requesting a custom song from Melody Master Co. We have received your request and will get back to you shortly.\n\n";
    $customerMessage .= "Your request details:\n";
    $customerMessage .= "Package Selected: " . htmlspecialchars($package) . "\n";
    $customerMessage .= "\nWe aim to respond within 24 hours during business days.\n\n";
    $customerMessage .= "Best regards,\nMelody Master Co Team";

    $customerHeaders = "From: melodymastersco@gmail.com\r\n";
    $customerHeaders .= "X-Mailer: PHP/" . phpversion();

    $customerMailSent = mail($email, $customerSubject, $customerMessage, $customerHeaders);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $mailSent && $customerMailSent,
        'message' => $mailSent && $customerMailSent ? 
            'Your request has been submitted successfully!' : 
            'There was an error submitting your request. Please try again.'
    ]);
    exit;
}

// If accessed directly without POST data
header('HTTP/1.1 403 Forbidden');
echo 'Access denied';
?>
