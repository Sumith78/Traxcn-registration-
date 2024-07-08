<?php
session_start();
$page_title = "Registration";
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

  h4,
  h5 {
    font-weight: bold;
  }

  .valid-feedback {
    color: green;
  }

  .invalid-feedback {
    color: red;
  }

  .password-requirements {
    margin-top: 10px;
    font-size: 14px;
  }

  .password-requirement {
    margin-bottom: 5px;
  }

  .password-requirement.valid {
    color: green;
  }

  .password-requirement.invalid {
    color: red;
  }

  .email-requirements {
    margin-top: 10px;
    font-size: 14px;
  }

  .email-requirement {
    margin-bottom: 5px;
  }

  .email-requirement.valid {
    color: green;
  }

  .email-requirement.invalid {
    color: red;
  }

  .phone-format-hint {
    display: none;
    color: #6c757d;
    font-size: 12px;
    margin-top: 5px;
  }
</style>

<div class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <?php
        if (isset($_SESSION['status'])) {
          ?>
          <div class="alert alert-success">
            <h5><?= $_SESSION['status']; ?></h5>
          </div>
          <?php
          unset($_SESSION['status']);
        }

        ?>
        <div class="card shadow">
          <div class="card-header">
            <h5>Registration Form</h5>
          </div>
          <div class="card-body">
            <form action="code.php" method="POST">
              <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
              </div>

              <div class="form-group mb-3">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone" class="form-control" pattern="[0-9]{10}" required>
                <small class="phone-format-hint">Format: 10 digits without spaces or dashes</small>
                <div class="invalid-feedback">Please enter 10 digits without spaces or dashes</div>
              </div>

              <div class="form-group mb-3">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required>
                <div id="emailRequirements" class="email-requirements" style="display: none;">
                  <div id="validEmailCheck" class="email-requirement">Valid email format</div>
                </div>
              </div>

              <div class="form-group mb-3">
                <label for="password">Password</label>
                <div class="input-group">
                  <input type="password" name="password" id="password" class="form-control" required>
                  <button type="button" class="btn btn-outline-secondary"
                    onclick="togglePassword('password')">Show</button>
                </div>
                <small id="passwordHelpBlock" class="form-text text-muted" style="display: none;">

                </small>
                <div id="passwordRequirements" class="password-requirements" style="display: none;">
                  <div id="lengthCheck" class="password-requirement">Minimum eight characters</div>
                  <div id="uppercaseCheck" class="password-requirement">At least one uppercase letter</div>
                  <div id="lowercaseCheck" class="password-requirement">At least one lowercase letter</div>
                  <div id="numberCheck" class="password-requirement">At least one number</div>
                  <div id="specialCharCheck" class="password-requirement">At least one special character</div>
                </div>
              </div>

              <div class="form-group mb-3">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                <div id="passwordMismatch" class="invalid-feedback" style="display: none;">Passwords do not match</div>
              </div>

              <div class="form-group">
                <button type="submit" id="registerBtn" name="register_btn" class="btn btn-primary"
                  disabled>Register</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function togglePassword(fieldId) {
    var field = document.getElementById(fieldId);
    if (field.type === "password") {
      field.type = "text";
    } else {
      field.type = "password";
    }
  }

  document.getElementById('phone').addEventListener('input', function () {
    var phoneNumber = this.value.trim();
    var formatHint = document.querySelector('.phone-format-hint');
    var invalidFeedback = document.querySelector('.invalid-feedback');

    if (phoneNumber.length > 0) {
      formatHint.style.display = 'block';
    } else {
      formatHint.style.display = 'none';
    }

    if (/^\d{10}$/.test(phoneNumber)) {
      formatHint.style.display = 'none';
      invalidFeedback.style.display = 'none';
    } else {
      invalidFeedback.style.display = 'block';
    }
  });

  document.getElementById('password').addEventListener('input', function () {
    var password = this.value.trim();
    var requirements = {
      length: password.length >= 8,
      uppercase: /[A-Z]/.test(password),
      lowercase: /[a-z]/.test(password),
      number: /\d/.test(password),
      specialChar: /[@$!%*?&]/.test(password)
    };

    updateRequirement('length', requirements.length);
    updateRequirement('uppercase', requirements.uppercase);
    updateRequirement('lowercase', requirements.lowercase);
    updateRequirement('number', requirements.number);
    updateRequirement('specialChar', requirements.specialChar);

    var isValid = Object.values(requirements).every(val => val);

    if (isValid) {
      document.getElementById('passwordHelpBlock').style.display = 'none';
      document.getElementById('passwordRequirements').style.display = 'none';
    } else {
      document.getElementById('passwordHelpBlock').style.display = 'block';
      document.getElementById('passwordRequirements').style.display = 'block';
    }

    checkPasswordMatch();
  });

  document.getElementById('confirm_password').addEventListener('input', function () {
    checkPasswordMatch();
  });

  function updateRequirement(req, isValid) {
    var requirementElement = document.getElementById(req + 'Check');
    if (isValid) {
      requirementElement.classList.add('valid');
      requirementElement.classList.remove('invalid');
    } else {
      requirementElement.classList.remove('valid');
      requirementElement.classList.add('invalid');
    }
  }

  function checkPasswordMatch() {
    var password = document.getElementById('password').value;
    var confirm_password = document.getElementById('confirm_password').value;
    var mismatchMessage = document.getElementById('passwordMismatch');

    if (confirm_password.length > 0) {
      if (password === confirm_password) {
        mismatchMessage.style.display = 'none';
        document.getElementById('registerBtn').disabled = false;
      } else {
        mismatchMessage.style.display = 'block';
        document.getElementById('registerBtn').disabled = true;
      }
    } else {
      mismatchMessage.style.display = 'none';
      document.getElementById('registerBtn').disabled = true;
    }
  }

  document.getElementById('email').addEventListener('input', function () {
    var email = this.value.trim();
    var validEmailCheck = document.getElementById('validEmailCheck');

    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
      validEmailCheck.classList.add('valid');
      validEmailCheck.classList.remove('invalid');
      validEmailCheck.textContent = 'Valid email format';
      validEmailCheck.style.display = 'block';
      document.getElementById('emailRequirements').style.display = 'none';
    } else {
      validEmailCheck.classList.remove('valid');
      validEmailCheck.classList.add('invalid');
      validEmailCheck.textContent = 'Invalid email format';
      validEmailCheck.style.display = 'block';
      document.getElementById('emailRequirements').style.display = 'block';
    }
  });

</script>

<?php include ('includes/footer.php'); ?>