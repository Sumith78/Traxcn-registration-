<?php
session_start();
include ('registration.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token)
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
    $mail->Subject = 'Email Verification from Traxcn';
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


if (isset($_POST['register_btn']))
 {
  $name =$_POST['name'];
  $phone = $_POST['phone'];
  $email =$_POST['email'];
  $password =  $_POST['password'];
  $verify_token = md5(rand());



  // Email Exists or not
  $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
  $check_email_query_run = mysqli_query($conn, $check_email_query);

  if (mysqli_num_rows($check_email_query_run) > 0) {
      $_SESSION['status'] = "Email Id already exists";
      header("Location: register.php");
  } else {
      
      $query = "INSERT INTO users(name, phone, email, password, verify_token) VALUES('$name', '$phone', '$email', '$password', '$verify_token')";
      $query_run = mysqli_query($conn, $query);

      if ($query_run) {
          sendemail_verify($name, $email, $verify_token);
          $_SESSION['status'] = "Registration Successful.! Please verify your Email address";
          header("Location: register.php");
      } else {
          $_SESSION['status'] = "Registration Failed";
          header("Location: register.php");
      }
  }
  
}
?>