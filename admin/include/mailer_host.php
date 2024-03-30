<?php
     // Create a new PHPMailer instance
     $mail = new PHPMailer(true);
 
     // SMTP Configuration
     $mail->isSMTP();
     $mail->Host = 'smtp.gmail.com';  // Your SMTP host (for Gmail, use smtp.gmail.com)
     $mail->SMTPAuth = true;
     $mail->Username = 'kumarsiddhu80@gmail.com'; // Your SMTP username (your Gmail email)
     $mail->Password = 'vzabicjvxpixmvuq'; // Your SMTP password (your Gmail password)
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
     $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
 

?>