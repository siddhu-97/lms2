<?php
include 'connection/connection.php';
require 'include/mail_require.php';
  use PHPMailer\PHPMailer\PHPMailer;

  // function mytoken(){
    // Create a random token
  $token = bin2hex(random_bytes(10)); 
  // Generate a 32-byte random token
  //  echo  $token;

// }
// $reset_token= mytoken();
// echo $reset_token;


if(isset($_POST['reset_username']))
{
    $reset_username= $_POST['reset_username'];

    $sql7= "SELECT `id`, `name`, `designation`, `email`, `password`, `password2`, `contact`, `image`, `status`, `token`, `expires_at` FROM `user` WHERE email='$reset_username'";
    $query7= mysqli_query($connect,$sql7);
    if(mysqli_num_rows($query7)>0)
    {
       $value7= mysqli_fetch_assoc($query7);
       $person_name= $value7['name'];
       $person_username= $value7['email'];
      $sql8= "UPDATE `user` SET `token`='$token' WHERE email= '$person_username'";
      // print_r($sql8);
      // die;
      $value8= mysqli_query($connect,$sql8);

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
 
     // Sender and recipient details
     $mail->setFrom('kumarsiddhu80@gmail.com', 'siddhu'); // Sender email and name
     $mail->addAddress($person_username, $person_name); // Recipient email and name
 
     // Email content
    

     $mail->isHTML(true); // Set email format to HTML
     $mail->Subject = 'Forgot Password'; // Email subject
     $mail->Body = 'Here is the link to reset your password: <a href="http://localhost/lms/admin/reset_password.php?token=' . $token . '">Reset Password</a>'; // HTML message
 
     try {
         // Attempt to send the email

         $mail->send();
         echo "<script>alert ('please check, link has been sent to your email')</script>";
     } catch (Exception $e) {
         // Handle errors
         echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
     }
   
    }
    else{
      echo "<script>alert ('invalid input')</script>";
    }

   
 

}
 
   
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Login - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 13 2024 with Bootstrap v5.3.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <p class="text-center small">Enter your username to reset your password</p>
                  </div>
                  <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="reset_username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">send email</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Back to login <a href="login.php">click here</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
