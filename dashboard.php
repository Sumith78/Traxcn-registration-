<?php

include ('authentication.php');
$page_title = "Dashboard";
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

  .card {
    margin-bottom: 20px;
    background-color: rgba(white, 255, 255);
  }

  .card-header,
  .card-body {
    padding: 20px;
  }

.card-header {
  background-color: rgba(173, 216, 230, 0.8); /* Light Blue with opacity */
  border-bottom: 1px solid #555;
}

  .card-body h5 {
    margin-bottom: 5px;
  }

  .card-body .account-info,
  .transaction-info {
    margin-bottom: 20px;
  }

  .transaction-info table {
    width: 100%;
    border-collapse: collapse;
  }

  .transaction-info th,
  .transaction-info td {
    padding: 10px;
    border: 1px solid #555;
    text-align: left;
  }

  .transaction-info th {
    background-color: rgba(173, 216, 230, 0.8);
  }
</style>

<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ">
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
        <div class="card">
          <div class="card-header">
            <h4>User Dashboard</h4>
          </div>
          <div class="card-body">
            <div class="account-info">
              <h4>Account Overview</h4>
              <hr>
              <h5>Username: <?= $_SESSION['auth_user']['username']; ?></h5>
              <h5>Email ID: <?= $_SESSION['auth_user']['email']; ?></h5>
              <h5>Phone No: <?= $_SESSION['auth_user']['phone']; ?></h5>
              
            </div>

            <div class="transaction-info">
              <h4>Recent Transactions</h4>
              <hr>
              <table>
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Type</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Example transaction data (Replace with actual data retrieval)
                  $transactions = [
                    ['date' => '2024-08-09', 'description' => 'Payment received', 'amount' => '100.00', 'type' => 'Credit'],
                    ['date' => '2024-08-08', 'description' => 'Purchase at Store', 'amount' => '-25.50', 'type' => 'Debit'],
                    ['date' => '2024-08-07', 'description' => 'Transfer to Savings', 'amount' => '-50.00', 'type' => 'Debit'],
                  ];

                  foreach ($transactions as $transaction) {
                    echo "<tr>
                            <td>{$transaction['date']}</td>
                            <td>{$transaction['description']}</td>
                            <td>{$transaction['amount']}</td>
                            <td>{$transaction['type']}</td>
                          </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <div class="account-settings">
              <h4>Account Settings</h4>
              <hr>
              <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
              <a href="change_password.php" class="btn btn-primary">Change Password</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include ('includes/footer.php'); ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var alert = document.getElementById('statusAlert');
    if (alert) {
      setTimeout(function () {
        alert.style.display = 'none';
      }, 2000); // Hide after 2 seconds
    }
  });
</script>