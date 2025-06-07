<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // path from Vercel

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$success = "";
$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name      = htmlspecialchars($_POST['user_name'] ?? '');
    $email     = htmlspecialchars($_POST['user_email'] ?? '');
    $age       = htmlspecialchars($_POST['user_age'] ?? '');
    $bio       = htmlspecialchars($_POST['user_bio'] ?? '');
    $job       = htmlspecialchars($_POST['user_job'] ?? '');
    $interests = $_POST['user_interest'] ?? [];
    $interests_str = is_array($interests) ? implode(', ', $interests) : $interests;

    // Send email
    $mail = new PHPMailer(true);
    try {
        // SMTP config
      $mail->isSMTP();
        $mail->Host = 'smtp.theresinstudio.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'store@theresinstudio.com'; // Your email
        $mail->Password = 'Az347f131';          // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom("store@theresinstudio.com", "Portfolio - Mailer");
        $mail->addAddress('rutvik10.sd@gmail.com'); // your receiving email

        $mail->isHTML(true);
        $mail->Subject = "New Contact Request from $name";
        $mail->Body    = "
            <h3>Contact Form Submission</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Age:</strong> $age</p>
            <p><strong>Job:</strong> $job</p>
            <p><strong>Interests:</strong> $interests_str</p>
            <p><strong>About:</strong><br>$bio</p>
        ";

        $mail->send();
        $success = "Thank you, $name. Your message has been sent!";
    } catch (Exception $e) {
        $error = "Error: " . $mail->ErrorInfo;
    }
}
