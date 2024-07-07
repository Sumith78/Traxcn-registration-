<?php
session_start();
include('registration.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
function resend_email_verify($name,$email,$verify_token)
{
  $mail = new PHPMailer(true);


  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->Host = 'smtp.gmail.com';
  $mail->Username = 'sumithrajput53361@gmail.com';
  $mail->Password = 'chfqkfdkgjtqkwmo';
  $mail->SMTPSecure = "tls";
  $mail->Port = 587;


  $mail->setFrom('sumithrajput53361@gmail.com', $name);
  $mail->addAddress($email);


  $mail->isHTML(true);
  $mail->Subject = 'Resend- Email Verification from Traxcn';
  $email_template = "
            <h2>You Have Registered with Traxcn</h2>
            <h5>Verify your email Address to login with the below link</h5>
            <br/><br/>
            <a href='http://localhost:8080/Registration_Form/verify-email.php?token=$verify_token'>Click Here</a>
        ";
  $mail->Body = $email_template;
  $mail->send();
  // echo 'Message has been sent';
}
if(isset($_POST['resend_email_verify_btn']))
{
    if(!empty(trim($_POST['email'])))
    {
      $email=mysqli_real_escape_string($conn,$_POST['email']);
      $checkemail_query="SELECT * FROM users WHERE email='$email' LIMIT 1";
      $checkemail_query_run=mysqli_query($conn,$checkemail_query);


      if(mysqli_num_rows($checkemail_query_run)>0)
      {
        $row=mysqli_fetch_array($checkemail_query_run);
        if($row['verify_status']=="0")
        {
          $name=$row['name'];
          $email=$row['email'];
          $verify_token=$row['verify_token'];

            resend_email_verify($name,$email,$verify_token);
            $_SESSION['status']="Verfication Email Link has been sent to your address.!";
        header("Location:login.php");
        }
        else
        {
           $_SESSION['status']="Email Already Verified.Please login";
        header("Location:resend-email-verification.php");
        }
      }
      else
      {
        $_SESSION['status']="Email is not registered.Please Register now.!";
        header("Location:register.php");
      }
    }
    else
    {
      $_SESSION['status']="Please enter your email address";
      header("Location:resend_email_verification.php");
    }
}

else
{

}
?>
