<?php
session_start();

if (isset($_SESSION['authenticated'])) {
  $_SESSION['status'] = "You are already Logged in";
  header('Location: dashboard.php');
  exit(0);
}
$page_title = "Login";

include ('includes/header.php');
include ('includes/navbar.php');
?>

<style>
  body {
    background-image: url('background.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    color: white;
  }
  
  h4, h5 {
    font-weight: bold;
  }
</style>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <?php
        if (isset($_SESSION['status'])) {
          ?>
          <div class="alert alert-success" id="statusAlert">
            <h5><?= $_SESSION['status']; ?></h5>
          </div>
          <?php
          unset($_SESSION['status']);
        }
        ?>
        <div class="card shadow">
          <div class="card-header">
            <h5>Login Form</h5>
          </div>
          <div class="card-body">
            <form action="logincode.php" method="POST">
              <div class="form-group mb-3">
                <label for="">Email Address</label>
                <input type="text" name="email" class="form-control">
              </div>
              <div class="form-group mb-3">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control">
              </div>
              <div class="form-group">
                <button type="submit" name="login_now_btn" class="btn btn-primary">Login</button>
              </div>
            </form>

            <hr>
            <h5>
              Did not receive your Verification Email?
              <a href="resend-email-verification.php">Resend</a>
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include ('includes/footer.php') ?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var alert = document.getElementById('statusAlert');
    if (alert) {
      setTimeout(function() {
        alert.style.display = 'none';
      }, 2000); // Hide after 2 seconds
    }
  });
</script>
