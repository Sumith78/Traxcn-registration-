<?php
session_start();
$page_title = "Registration";
include ('includes/header.php');
include ('includes/navbar.php');
?>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="alert">
          <?php
            if(isset($_SESSION['status']))
            {
              echo "<h4>".$_SESSION['status']."</h4>";
              unset($_SESSION['status']);
            }
          ?>
        </div>
        <div class="card shadow">
          <div class="card-header">
            <h5>Registration Form</h5>
          </div>
          <div class="card-body">
            <form action="code.php" method="POST">
              <div class="form-group mb-3">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>

              <div class="form-group mb-3">
                <label for="">Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
              </div>

              <div class="form-group mb-3">
                <label for="">Email Address</label>
                <input type="email" name="email" class="form-control" required>
              </div>

              <div class="form-group mb-3">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>

              <div class="form-group mb-3">
                <label for="">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
              </div>

              <div class="form-group">
                <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include ('includes/footer.php'); ?>