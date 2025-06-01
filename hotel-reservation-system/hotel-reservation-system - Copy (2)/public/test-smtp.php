<?php
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;

   require '../vendor/autoload.php';

   $mail = new PHPMailer(true);

   try {
       // Server settings
       $mail->isSMTP();
       $mail->Host = 'live.smtp.mailtrap.io';
       $mail->SMTPAuth = true;
       $mail->Username = 'apismtp@mailtrap.io';
       $mail->Password = '3f60a4f4bd1842053272d98965d8bcdf';
       $mail->SMTPSecure = 'tls';
       $mail->Port = 2525;

       // Recipients
       $mail->setFrom('no-reply@hotel.com', 'Hotel Reservation System');
       $mail->addAddress('test@example.com');

       // Content
       $mail->isHTML(true);
       $mail->Subject = 'Test Email';
       $mail->Body = 'This is a test email sent via Mailtrap SMTP.';

       $mail->send();
       echo 'Test email sent successfully!';
   } catch (Exception $e) {
       echo "Failed to send test email. Error: {$mail->ErrorInfo}";
   }
   ?>