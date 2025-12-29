<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }
    
    // Prepare email content
    $email_content = "New Contact Form Submission\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Company: $company\n";
    $email_content .= "Subject: $subject\n";
    $email_content .= "Message:\n$message\n";
    
    // Email details
    $to = "negi240@gmail.com"; // Replace with your email
    $email_subject = "New Contact Form: $subject";
    $headers = "From: $email";
    
    // Send email
    $email_sent = mail($to, $email_subject, $email_content, $headers);
    
    // Prepare WhatsApp message
    $whatsapp_msg = "New Contact Form Submission%0A%0A";
    $whatsapp_msg .= "Name: $name%0A";
    $whatsapp_msg .= "Email: $email%0A";
    $whatsapp_msg .= "Phone: $phone%0A";
    $whatsapp_msg .= "Company: $company%0A";
    $whatsapp_msg .= "Subject: $subject%0A";
    $whatsapp_msg .= "Message:%0A$message";
    
    // Send WhatsApp message using API
    // $testmsg = urlencode($whatsapp_msg);
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, "https://cloud.bottly.in/api/send?number=917011767613&type=text&message=$testmsg&instance_id=675A645617F6D&access_token=6468c9d47bcfa");
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_exec($ch);
    // curl_close($ch);
    
    if ($email_sent) {
        echo json_encode(['status' => 'success', 'message' => 'Thank you! Your message has been sent successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'There was a problem sending your message. Please try again.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>