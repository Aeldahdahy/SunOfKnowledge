<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

function sendEmail($name, $email, $message)
{
    $to = "tahaelrajel8@gmail.com"; // Replace with your email
    $subject = "New Contact Form Submission";
    
    // Headers for HTML email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Email body in HTML format
    $mailBody = "
        <html>
        <body>
            <h2>New Contact Form Submission</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        </body>
        </html>
    ";

    return mail($to, $subject, $mailBody, $headers);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get raw POST data
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    // Sanitize inputs
    $name = isset($data['name']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $data['name']) : "";
    $email = isset($data['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $data['email']) : "";
    $message = isset($data['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $data['message']) : "";

    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo json_encode(["error" => "Incomplete data"]);
        exit;
    }

    // Send email
    $emailSent = sendEmail($name, $email, $message);

    // Return JSON response
    if ($emailSent) {
        echo json_encode(["success" => "Email sent successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to send email"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
}
?>