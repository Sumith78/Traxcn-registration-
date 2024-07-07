<?php
session_start();
include ('registration.php');

if (isset($_GET['token'])) {
  $token = $_GET['token'];


  $verify_query = "SELECT verify_token, verify_status FROM users WHERE verify_token = '$token' LIMIT 1";
  $verify_query_run = mysqli_query($conn, $verify_query);

  if (mysqli_num_rows($verify_query_run) > 0) {
    $row = mysqli_fetch_assoc($verify_query_run);

    if ($row['verify_status'] == "0") {
   
      $update_query = "UPDATE users SET verify_status = '1' WHERE verify_token = '$token' LIMIT 1";
      $update_query_run = mysqli_query($conn, $update_query);

      if ($update_query_run) {
        $_SESSION['status'] = "Your Account has been Verified Successfully";
        header("Location: login.php");
        exit();
      } else {
        $_SESSION['status'] = "Verification Failed";
        header("Location: login.php");
        exit(); 
      }
    } else {
      $_SESSION['status'] = "Email Already Verified. Please Login";
      header("Location: login.php");
      exit(); 
    }
  } else {
    $_SESSION['status'] = "This token does not Exist";
    header("Location: login.php");
    exit();
  }
} else {
  $_SESSION['status'] = "Not Allowed";
  header("Location: login.php");
  exit(); 
}
?>