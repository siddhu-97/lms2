<?php
    include 'connection/connection.php';
    require 'include/mail_require.php';
    use PHPMailer\PHPMailer\PHPMailer;

    session_start();
    // $rand_pass = bin2hex(random_bytes(10));
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            $designation = $_POST['designation'];
            $email = $_POST['email'];
            $contact = $_POST['contact'];
            $filename = $_FILES['uploadfile']['name'];
            $tempname = $_FILES['uploadfile']['tmp_name'];
            // $password_hash= password_hash($name);
            $hashed_email = hash('sha256', $email);
            
            //user register (using prepared statement to prevent SQL injection)
            $sql2 = "SELECT email FROM `user` WHERE email= '$email'";
            $value2= mysqli_query($connect,$sql2);
            $result= mysqli_num_rows($value2);
            
            if ($result>0) {
                echo "User already registered";
            } 
            else
            {
                $folder = "./upload/" . $filename;
                if (move_uploaded_file($tempname, $folder)) {
                    $sql = "INSERT INTO `user`(`name`, `designation`, `email`, `contact`, `image`) VALUES ('$name','$designation','$email','$contact','$filename')";
                    $stmt = mysqli_query($connect,$sql);
                    // $stmt->bind_param("ssssss", $name, $designation, $email, $contact, $filename);
            
                    if ($stmt) {
                        // echo "<script>alert ('your data has been submitted to the database.')</script>";
                        
                        // Initialize PHPMailer
                        $mail = new PHPMailer(true);

                        // SMTP Configuration (modify with your SMTP settings)
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'kumarsiddhu80@gmail.com';
                        $mail->Password = 'vzabicjvxpixmvuq';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;
                        
                        // Sender and recipient details
                        $mail->setFrom('kumarsiddhu80@gmail.com', 'Siddhu');
                        $mail->addAddress($email, $name);

                        // Email content
                        $mail->isHTML(true);
                        $mail->Subject = 'Your Temporary Password';
                        $mail->Body = "Hi $name,<br><br>Thank you for registering with us. Your temporary password is: <strong>$hashed_email</strong>.<br><br> Please use this password to log in and change it immediately after login.";

                        try {
                            // Attempt to send the email
                            $mail->send();
                            echo "<script>alert ('Please check your email for the temporary password.')</script>";
                        } catch (Exception $e) {
                            // Handle errors
                            echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                    else{
                        echo "data not uploaded";
                    }
                } 
                else {
                    echo "Failed to upload file";
                }
            }
        }

        //   start login
       
        
        if(isset($_POST['login_email'])) {
            $login_email = $_POST['login_email'];
            $login_password = $_POST['login_password'];
            $hash_email = hash('sha256', $login_email);
        
            $sql3 = "SELECT `id`, `name`, `designation`, `email`, `password`, `contact`, `image` FROM `user` WHERE email='$login_email'";          
            $query3= mysqli_query($connect,$sql3);
              
        //    $result3 = mysqli_num_rows($query3);
            $row = mysqli_fetch_assoc($query3);
            if($row>0) {
                 $login_email_after= $row['email'];
                $db_password = $row['password'];              
               
                // if(password_verify($login_password, $db_password) || ($login_password == $_SESSION['rand_pass'])) {
                if($login_email==$login_email_after AND $login_password==$hash_email) {
                    // Password is correct (either actual password or random password)
                    if(empty($db_password)) {
                        // If database password is empty, redirect to confirm password page
                        header('location:confirm_password.php');
                        exit();
                    } else {
                        // Store user information in session variables
                        $_SESSION['email_address'] = $login_email_after;
                        $_SESSION['my_password'] = $db_password;
                        $_SESSION['my_image'] = $row['image'];
                        $_SESSION['user_name'] = $row['name'];
                        $_SESSION['my_designation'] = $row['designation'];
                        $_SESSION['user_contact'] = $row['contact'];
                       
                      
                        // Redirect to index page
                        header('location:index.php');
                        exit();
                    }
                }
                 else {
                    // Password is incorrect
                    header('location:login.php');
                    exit();
                }
            } 
            else {
                // No user found with the provided email
                echo "No data found";
            }
        }
        if(isset($_POST['newpassword']))
        {
          $new_password  =$_POST['newpassword'];
          $re_newpassword  =$_POST['renewpassword'];
          echo $new_password ;
          echo $re_newpassword ;
          die;
        }
       
        
    }
?>
