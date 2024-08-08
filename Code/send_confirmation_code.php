<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

        // Lowercase the email
        $email = strtolower($email);

        // Generate a random confirmation code
        $confirmation_code = rand(100000, 999999);

        // Database connection
        $connection = new mysqli("localhost", "root", "", "users");

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        } else {
            // Check if the email exists in the database
            $statement = $connection->prepare("SELECT user_id FROM registration WHERE email = ?");
            $statement->bind_param("s", $email);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows == 1) {
                // Email exists, save the confirmation code in the database
                $statement = $connection->prepare("UPDATE registration SET confirmation_code = ? WHERE email = ?");
                $statement->bind_param("ss", $confirmation_code, $email);

                if ($statement->execute()) {
                    // Send the confirmation code via email
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server (Gmail)
                        $mail->SMTPAuth = true;
                        $mail->Username = 'vallerianwilson@gmail.com';
                        $mail->Password = 'qlhk rnws lfdc evoi';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        //Recipients
                        $mail->setFrom('vallerianwilson@gmail.com', 'ComiTop');
                        $mail->addAddress($email);  // Add recipient

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Password Reset Confirmation Code';
                        $mail->Body    = "Your confirmation code is: $confirmation_code";

                        $mail->send();

                        // Set success message in session
                        session_start();
                        $_SESSION['success_message'] = "Confirmation code has been sent to your email.";

                        // Redirect to verify_code_form.php
                        header("Location: verify_code_form.php");
                        exit();
                    } catch (Exception $e) {
                        echo "Failed to send confirmation code. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    echo "Failed to save confirmation code. Please try again.";
                }
            } else {
                echo "Email not found.";
            }

            $statement->close();
            $connection->close();
        }
    } else {
        echo "Invalid request method.";
    }
?>
