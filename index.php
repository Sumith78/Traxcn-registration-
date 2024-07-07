<?php
$page_title = "Home Page";
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

  h2,
  h4 {
    font-weight: bold;
  }
</style>

<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <b>
          <h2>Welcome to our Website!</h2>
        </b>
        <h4>Explore Your Home Page</h4>
      </div>
    </div>
  </div>
</div>

<?php include ('includes/footer.php'); ?>