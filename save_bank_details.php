<?php
session_start();
include ('registration.php'); // This file contains the connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ensure the connection is successful
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Get form data
  $account_name = $_POST['account_name'] ?? '';
  $account_number = $_POST['account_number'] ?? '';
  $confirm_account_number = $_POST['confirm_account_number'] ?? '';
  $bank_name = $_POST['bank_name'] ?? '';
  $ifsc_code = $_POST['ifsc_code'] ?? '';

  // Validation
  $errors = [];

  if (empty($account_name)) {
    $errors[] = "Account Name is required.";
  }
  if (empty($account_number)) {
    $errors[] = "Account Number is required.";
  } elseif (strlen($account_number) < 10) {
    $errors[] = "Account Number must be at least 10 digits long.";
  }
  if (empty($confirm_account_number)) {
    $errors[] = "Confirm Account Number is required.";
  } elseif ($account_number !== $confirm_account_number) {
    $errors[] = "Account Number and Confirm Account Number do not match.";
  }
  if (empty($bank_name)) {
    $errors[] = "Bank Name is required.";
  }
  if (empty($ifsc_code)) {
    $errors[] = "IFSC Code is required.";
  }

  if (!empty($errors)) {
    $_SESSION['status'] = implode("<br>", $errors);
    header("Location: bank_details_form.php"); // Redirect to the form page with errors
    exit();
  }

  // Check if account number already exists
  $check_account_query = "SELECT account_number FROM bank_details WHERE account_number = ? LIMIT 1";
  $stmt = $conn->prepare($check_account_query);
  $stmt->bind_param("s", $account_number);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $_SESSION['status'] = "Account number already exists.";
    header("Location: bank_details_form.php"); // Redirect to the form page with error
    exit();
  } else {
    // Securely save the data to the database
    $sql = "INSERT INTO bank_details (account_name, account_number, bank_name, ifsc_code) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $account_name, $account_number, $bank_name, $ifsc_code);

    if ($stmt->execute()) {
      $_SESSION['status'] = "Bank details saved successfully!";
      echo "<script>
                alert('Bank details saved successfully!');
                setTimeout(function() {
                    window.location.href = 'dashboard.php';
                }, 2000);
            </script>";
      exit();
    } else {
      $_SESSION['status'] = "Error: " . $stmt->error;
      header("Location: bank_details_form.php"); // Redirect to the form page with error
      exit();
    }

    $stmt->close();
    $conn->close();
  }
}
?>