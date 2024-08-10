<?php
$page_title = "Home Page";
include('authentication.php');
include('includes/header.php');
include('includes/navbar.php');
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

  .bank-form {
    background-color: rgba(0, 0, 0, 0.7);
    padding: 20px;
    border-radius: 10px;
  }

  .form-control {
    margin-bottom: 10px;
  }

  .password-container {
    position: relative;
  }

  .password-container input {
    padding-right: 40px; /* Space for the icon */
  }

  .password-container .password-icon {
    position: absolute;
    right: 10px; /* Adjusted spacing from right */
    top: 55%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 15px; /* Adjust size if needed */
    color: white; /* Adjust icon color if needed */
  }

  .validation-feedback {
    margin-top: 5px;
    font-size: 14px;
  }

  .valid {
    color: green;
  }

  .invalid {
    color: red;
  }
</style>

<div class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <h2>Welcome to our Banking Portal!</h2>
        <h4>Manage Your Finances with Ease</h4>
        <p>Our platform provides a seamless way to manage your bank accounts, track transactions, and much more. With our advanced tools, you can stay on top of your finances effortlessly.</p>
      </div>
    </div>

    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="bank-form">
          <h4 class="text-center">Enter Your Bank Details</h4>
          <form id="bank-details-form" action="save_bank_details.php" method="POST">
            <div class="form-group">
              <label for="account_name">Account Name</label>
              <input type="text" class="form-control" id="account_name" name="account_name" required>
              <div id="account-name-feedback" class="validation-feedback"></div>
            </div>
            <div class="form-group">
              <label for="account_number">Account Number</label>
              <input type="text" class="form-control" id="account_number" name="account_number" required>
              <div id="account-number-feedback" class="validation-feedback"></div>
            </div>
            <div class="form-group password-container">
              <label for="confirm_account_number">Confirm Account Number</label>
              <input type="password" class="form-control" id="confirm_account_number" name="confirm_account_number" required>
              <i class="password-icon" id="toggle-confirm-account-number">👁️</i>
              <div id="confirm-account-number-feedback" class="validation-feedback"></div>
            </div>
            <div class="form-group">
              <label for="bank_name">Bank Name</label>
              <input type="text" class="form-control" id="bank_name" name="bank_name" required>
              <div id="bank-name-suggestions" class="suggestions"></div>
            </div>
            <div class="form-group">
              <label for="ifsc_code">IFSC Code</label>
              <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" required>
              <small id="ifsc-code-validation" class="validation-feedback"></small>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
          </form>
          <div id="message" class="alert alert-success" style="display: none;"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const accountNameInput = document.getElementById('account_name');
    const accountNumberInput = document.getElementById('account_number');
    const confirmAccountNumberInput = document.getElementById('confirm_account_number');
    const bankNameInput = document.getElementById('bank_name');
    const ifscCodeInput = document.getElementById('ifsc_code');
    const accountNameFeedback = document.getElementById('account-name-feedback');
    const accountNumberFeedback = document.getElementById('account-number-feedback');
    const confirmAccountNumberFeedback = document.getElementById('confirm-account-number-feedback');
    const message = document.getElementById('message');
    const toggleConfirmAccountNumber = document.getElementById('toggle-confirm-account-number');

    // Validate Account Name
    accountNameInput.addEventListener('input', function () {
      const accountName = accountNameInput.value;
      const regex = /^[A-Za-z\s]+$/;

      if (regex.test(accountName)) {
        accountNameFeedback.textContent = '';
        accountNameFeedback.className = 'validation-feedback valid';
      } else {
        accountNameFeedback.textContent = 'Account name should contain only alphabets.';
        accountNameFeedback.className = 'validation-feedback invalid';
      }
    });

    // Validate Account Number
    accountNumberInput.addEventListener('input', function () {
      const accountNumber = accountNumberInput.value;
      const regex = /^\d+$/;

      if (regex.test(accountNumber) && accountNumber.length >= 10) {
        accountNumberFeedback.textContent = '';
        accountNumberFeedback.className = 'validation-feedback valid';
      } else {
        accountNumberFeedback.textContent = 'Account number must be at least 10 digits long and contain only digits.';
        accountNumberFeedback.className = 'validation-feedback invalid';
      }
    });

    // Validate Confirm Account Number
    confirmAccountNumberInput.addEventListener('input', function () {
      const accountNumber = accountNumberInput.value;
      const confirmAccountNumber = confirmAccountNumberInput.value;

      if (accountNumber === confirmAccountNumber) {
        confirmAccountNumberFeedback.textContent = '';
        confirmAccountNumberFeedback.className = 'validation-feedback valid';
      } else {
        confirmAccountNumberFeedback.textContent = 'Account numbers do not match.';
        confirmAccountNumberFeedback.className = 'validation-feedback invalid';
      }
    });

    // Toggle Confirm Account Number Visibility
    toggleConfirmAccountNumber.addEventListener('click', function () {
      if (confirmAccountNumberInput.type === 'password') {
        confirmAccountNumberInput.type = 'text';
        toggleConfirmAccountNumber.textContent = '🙈'; // Hide icon
      } else {
        confirmAccountNumberInput.type = 'password';
        toggleConfirmAccountNumber.textContent = '👁️'; // Show icon
      }
    });

    // Handle form submission
    document.getElementById('bank-details-form').addEventListener('submit', function (e) {
      e.preventDefault();

      const accountNumber = document.getElementById('account_number').value;
      const confirmAccountNumber = document.getElementById('confirm_account_number').value;
      const validAccountNumber = document.querySelector('#account-number-feedback.valid') !== null;
      const validConfirmAccountNumber = document.querySelector('#confirm-account-number-feedback.valid') !== null;
      const validAccountName = document.querySelector('#account-name-feedback.valid') !== null;

      if (validAccountNumber && validConfirmAccountNumber && validAccountName) {
        fetch('save_bank_details.php', {
          method: 'POST',
          body: new FormData(this)
        })
          .then(response => response.text())
          .then(result => {
            message.textContent = 'Bank details saved successfully!';
            message.style.display = 'block';
            setTimeout(() => {
              window.location.href = 'dashboard.php';
            }, 2000);
          });
      } else {
        alert('Please fill in all fields correctly.');
      }
    });
  });
</script>

<?php include('includes/footer.php'); ?>
