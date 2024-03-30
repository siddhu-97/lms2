if(isset($_POST['currentpassword']))
        {
            // echo "hollo dear";
             $hidden_id= 6;
            // $log_in_email= $_POST['email'];
            // $log_in_password= $_POST['password'];
            $currentpassword= $_POST['currentpassword'];
            $newpassword= $_POST['newpassword'];
            $renewpassword= $_POST['renewpassword'];
            // echo  $currentpassword;
            //  echo  $newpassword;
            //  echo  $hidden_id;
            //  die();
          

            $sql5= "SELECT `id`, `name`, `designation`, `email`, `password`, `password2`, `contact`, `image`, `status`, `date` FROM `user` WHERE id='$hidden_id'";
            $query5= mysqli_query($connect,$sql5);
            $value5 = mysqli_fetch_assoc($query5);
            // print_r($value5);
            // echo $value5['password2'];
            // echo $value5['password'];
            // die();
           
            if($value5['password2']=="")
            {
                if($currentpassword == $value5['password'])
                {
                    if($newpassword==$renewpassword)
                    {
                       $sql6= "UPDATE `user` SET `password2`='$newpassword' WHERE id='$hidden_id'";
                        $query6= mysqli_query($connect,$sql6);
                        if($query6)
                        {
                            echo "new password has been updated";
                            $sql7= "UPDATE `user` SET `password` = '' WHERE id= '$hidden_id'";
                            $query7= mysqli_query($connect,$sql7);
                            if($query7)
                            {
                                header('location:login.php');
                                // if($log_in_email == $value5['email'] AND $log_in_password == $value5['password'])
                                // { 
                                //     header('location:index.php');   
                                //     exit();  
                                // }
                                // else
                                // {
                                //     header('location:login.php');   
                                //     exit();
                                // }
                            }  
                            else{
                                echo "password not updated";                    
                            }
                        } 
                        else{
                            echo "both new passwords are not matching";
                        }   
                    }
                    else{
                        echo "old password doesn't matched";

                    }
                }
                else{
                    echo "password2 is not blank";
                }
           }

        }
        // Create a new PHPMailer instance
$mail = new PHPMailer();

// Set mailer to use SMTP
$mail->isSMTP();

// Specify SMTP host
$mail->Host = 'smtp.example.com';

// Specify SMTP port
$mail->Port = 587;

// Enable SMTP authentication
$mail->SMTPAuth = true;

// SMTP username
$mail->Username = 'kumarsiddhu80@gmail.com';

// SMTP password
$mail->Password = 'vzab icjv xpix mvuq';

// Set sender email address
$mail->setFrom('kumarsiddhu80@gmail.com', 'Mr.siddhu');

// Set recipient email address
$mail->addAddress('karishmavermablt@gmail.com', 'karishma');

// Set email subject
$mail->Subject = 'Test Email';

// Set email body
$mail->Body = 'This is a test email sent using PHPMailer.';

// Send the email
if ($mail->send()) {
    echo 'Email sent successfully';
} else {
    echo 'Error: ' . $mail->ErrorInfo;
}

?>

// Sender and recipient details
     $mail->setFrom('kumarsiddhu80@gmail.com', 'siddhu'); // Sender email and name
     $mail->addAddress('kumarsiddhu80@gmail.com', 'mr.siddhu'); // Recipient email and name
 
     // Email content
     $mail->isHTML(true); // Set email format to HTML
     $mail->Subject = 'Forgot Password'; // Email subject
     $mail->Body = 'Here is the link to reset your password: <a href="http://localhost/lms/admin/reset_password.php?token=' . $reset_token . '">Reset Password</a>'; // HTML message
     $mail->AltBody = 'Here is the link to reset your password: reset_password.php?token=' . $reset_token; // Plain text message
 
     try {
         // Attempt to send the email
         $mail->send();
         echo 'Email has been sent';
     } catch (Exception $e) {
         // Handle errors
         echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
     }

     <?php
include 'connection/connection.php';
require 'include/mail_require.php';
require 'mailer_host.php';
use PHPMailer\PHPMailer\PHPMailer;

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $designation = $_POST['designation'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $contact = $_POST['contact'];
        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];
        
        $rand_pass = bin2hex(random_bytes(10));

        //user register (using prepared statement to prevent SQL injection)
        $sql2 = "SELECT email FROM `user` WHERE email=?";
        $stmt = $connect->prepare($sql2);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result2 = $stmt->get_result();
        
        if ($result2->num_rows > 0) {
            echo "User already registered";
        } else {
            $folder = "./upload/" . $filename;
            if (move_uploaded_file($tempname, $folder)) {
                $sql = "INSERT INTO `user`(`name`, `designation`, `email`, `password`, `contact`, `image`) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("ssssss", $name, $designation, $email, $password, $contact, $filename);
                if ($stmt->execute()) {
                    echo "Your data has been successfully submitted to the database";
                    
                    // Initialize PHPMailer
                    $mail = new PHPMailer(true);

                    // SMTP Configuration (modify with your SMTP settings)
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your_email@gmail.com';
                    $mail->Password = 'your_password';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    
                    // Sender and recipient details
                    $mail->setFrom('your_email@gmail.com', 'Your Name');
                    $mail->addAddress($email, $name);

                    // Email content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Temporary Password';
                    $mail->Body = "Hi $name,<br><br>Thank you for registering with us. Your temporary password is: <strong>$rand_pass</strong>.<br><br> Please use this password to log in and change it immediately after login.";

                    try {
                        // Attempt to send the email
                        $mail->send();
                        echo "<script>alert ('Please check your email for the temporary password.')</script>";
                    } catch (Exception $e) {
                        // Handle errors
                        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    echo "Failed to submit to the database";
                }
            } else {
                echo "Failed to upload file";
            }
        }
    }
}


//   start login
        if(isset($_POST['login_email']))
        {
            $login_email=$_POST['login_email'];
            $login_password=$_POST['login_password'];
            //    echo $login_email;
            //    echo $login_password;
            // die;
            $sql3= "SELECT `id`, `name`, `designation`, `email`, `password`, `password2`, `contact`, `image`, `status`, `token`, `expires_at` FROM `user` WHERE email='$login_email'";
            $query3= mysqli_query($connect,$sql3);

            if(mysqli_num_rows($query3)>0)
            {
                // Check if query executed successfully and if there is exactly one row returned
                
                // Fetch the row as an associative array
                $value2 = mysqli_fetch_assoc($query3);
                    
                
                    // Verify password using password_verify function
                    if($login_email == $value2['email'] AND $login_password == $value2['password'])
                    { 
                        if($value2['password2']==""){
                            header('location:confirm_password.php');
                        }
                        else
                        {              
                        // Store user information in session variables

                            // $_SESSION['hidden_id'] = $value2['id'];
                            $_SESSION['email_address'] = $value2['email'];
                            $_SESSION['my_password'] = $value2['password'];
                            $_SESSION['my_image'] = $value2['image'];
                            $_SESSION['user_name'] = $value2['name'];
                            $_SESSION['my_designation'] = $value2['designation'];
                            $_SESSION['user_contact'] = $value2['contact'];
                            
                            header('location:index.php');
                        }
                    }  
                    else {
                        // Redirect to login page if password is incorrect
                        header('location:login.php');
                        exit();
                    }
                }
                else{
                    echo "no data found";
                }



        }
       ?>