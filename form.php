<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer via Composer
require 'vendor/autoload.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Rutvik Patel</title>
    <link href="img/2.png" rel="icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Nunito:400,300' rel='stylesheet'>
    <!-- <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #f4f7f8;
            color: #384047;
            padding: 20px;
        }
        form {
            max-width: 700px;
            margin: 10px auto;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
        }
        h1 {
            margin: 0 0 30px 0;
            text-align: center;
        }
        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        label.light {
            font-weight: 300;
        }
        fieldset {
            border: none;
            margin-bottom: 20px;
        }
        .number {
            background-color: #1abc9c;
            color: white;
            border-radius: 100%;
            padding: 8px 12px;
            margin-right: 10px;
            display: inline-block;
        }
        button {
            padding: 10px 20px;
            background: #1abc9c;
            color: white;
            border: 0;
            border-radius: 5px;
            cursor: pointer;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            background-color: #dff0d8;
            color: green;
        }
        .error {
            background-color: #f2dede;
            color: red;
        }
    </style> -->
<link rel="stylesheet" href="css/Formstyle.css">
</head>
<body>

<?php if ($success || $error): ?>
<div id="popup" class="popup-overlay">
  <div class="popup-box">
    <h2><?= $success ? "Success" : "Error" ?></h2>
    <p><?= $success ?: $error ?></p>
    <button onclick="closePopup()">OK</button>
  </div>
</div>

<style>
.popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}
.popup-box {
  background: white;
  padding: 20px 30px;
  border-radius: 10px;
  box-shadow: 0 0 15px rgba(0,0,0,0.3);
  text-align: center;
}
.popup-box h2 {
  margin-top: 0;
  color: <?= $success ? '#2ecc71' : '#e74c3c' ?>;
}
.popup-box button {
  margin-top: 15px;
  padding: 8px 18px;
  background: <?= $success ? '#2ecc71' : '#e74c3c' ?>;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>

<script>
function closePopup() {
  document.getElementById("popup").style.display = "none";
}
</script>
<?php endif; ?>


<form action="" method="post">
    <h1>Work With Me</h1>

    <fieldset>
        <legend><span class="number">1</span>Your Basic Information</legend>
        <label for="name">Full Name</label>
        <input type="text" id="name" name="user_name" value="<?= htmlspecialchars($_POST['user_name'] ?? '') ?>" required>

        <label for="mail">Email Id</label>
        <input type="email" id="mail" name="user_email" value="<?= htmlspecialchars($_POST['user_email'] ?? '') ?>" required>

        <label>Age:</label>
        <input type="radio" id="under_13" value="Under 13" name="user_age" <?= (($_POST['user_age'] ?? '') === 'Under 13') ? 'checked' : '' ?>>
        <label for="under_13" class="light">Under 13</label><br>
        <input type="radio" id="over_13" value="13 or older" name="user_age" <?= (($_POST['user_age'] ?? '') === '13 or older') ? 'checked' : '' ?>>
        <label for="over_13" class="light">13 or older</label>
    </fieldset>

    <fieldset>
        <legend><span class="number">2</span>Your Profile</legend>
        <label for="bio">About You</label>
        <textarea id="bio" name="user_bio"><?= htmlspecialchars($_POST['user_bio'] ?? '') ?></textarea>
    </fieldset>

    <fieldset>
        <label for="job">What's Your Job Role?</label>
        <select id="job" name="user_job">
            <?php
            $roles = [
                "Web" => [
                    "frontend_developer" => "Front-End Developer",
                    "php_developor" => "PHP Developer",
                    "python_developer" => "Python Developer",
                    "rails_developer" => "Rails Developer",
                    "web_designer" => "Web Designer",
                    "WordPress_developer" => "WordPress Developer"
                ],
                "Mobile" => [
                    "Android_developer" => "Android Developer",
                    "iOS_developer" => "iOS Developer",
                    "mobile_designer" => "Mobile Designer"
                ],
                "Business" => [
                    "business_owner" => "Business Owner",
                    "freelancer" => "Freelancer"
                ],
                "Other" => [
                    "secretary" => "Secretary",
                    "maintenance" => "Maintenance"
                ]
            ];
            foreach ($roles as $group => $options) {
                echo "<optgroup label=\"$group\">";
                foreach ($options as $value => $label) {
                    $selected = ($_POST['user_job'] ?? '') === $value ? "selected" : "";
                    echo "<option value=\"$value\" $selected>$label</option>";
                }
                echo "</optgroup>";
            }
            ?>
        </select>

        <label>Interests</label><br>
        <?php
        $interestList = ["interest_development" => "Development", "interest_design" => "Design", "interest_business" => "Business"];
        foreach ($interestList as $val => $label) {
            $checked = (isset($_POST['user_interest']) && in_array($val, (array)$_POST['user_interest'])) ? "checked" : "";
            echo "<input type='checkbox' id='$val' name='user_interest[]' value='$val' $checked>
                  <label class='light' for='$val'>$label</label><br>";
        }
        ?>
    </fieldset>

    <button type="submit">Submit Your Details</button>
</form>

</body>
</html>
