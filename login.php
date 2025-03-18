<?php

require_once "includes/functions.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
  if (empty($_POST['email']) || empty($_POST['password'])) {
    response('error', 'Please fill in all fields');
    exit;
  }
  $email = $_POST["email"];
  $password = $_POST["password"];
  login($email, $password);
  exit;
}

include "layout/header.php";

?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href=""><b>Contact</b> MS</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="myForm" class="form-group needs-validation" novalidate>
        <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" id="validationCustom01" name="email" placeholder="Email" required>
          <span class="form-control-feedback"><i class="bi bi-envelope-at-fill"></i></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" id="validationCustom02" name="password" placeholder="Password" required>
          <span class="form-control-feedback"><i class="bi bi-shield-lock-fill"></i></span>
        </div>
        <div class="row">
          <div class="col-xs-8"></div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat" name="login">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <?php include "layout/footer.php"; ?>

  <script>
    'use strict';
    $(document).ready(function() {
      // Login form validation start

      // Fetch all forms with the "needs-validation" class
      $('.needs-validation').each(function() {
        const form = $(this);

        // Add event listener for the form's submission
        form.on('submit', function(event) {
          // Trigger validation only after the submit button is clicked
          const isValid = validateForm(form);

          // Prevent form submission if validation fails
          if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
          }

          // Add Bootstrap validation styling class
          form.addClass('was-validated');
        });
      });

      // Function to validate form inputs
      function validateForm(form) {
        let isValid = true;

        form.find('input, textarea, select').each(function() {
          const input = $(this);
          const formGroup = input.closest('.form-group');

          if (input[0].checkValidity()) {
            // Mark as valid
            formGroup.addClass('has-success').removeClass('has-error');
            formGroup.find('.help-block').remove(); // Remove error messages
          } else {
            // Mark as invalid
            formGroup.addClass('has-error').removeClass('has-success');
            if (formGroup.find('.help-block').length === 0) {
              // Append error message
              formGroup.append(`<span class="help-block">${input[0].validationMessage}</span>`);
            }
            isValid = false; // Mark form as invalid
          }
        });

        return isValid; // Return the overall validity of the form
      }
      // Login form validation end

      // Login form submission start
      $('#myForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Gather form data
        var formData = $(this).serialize(); // Serializes the form's elements
        $.ajax({
          url: window.location.href, // Replace with your server endpoint
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              // Login successful - Redirect to another page
              window.location.href = "/adminlte_practice01/"; // Replace with your target page
            } else if (response.status === 'error') {
              // Display error message
              $('#errorMessage').text(response.message).show();
            }
          },
          error: function(xhr, status, error) {
            // Handle error response
            alert('An error occurred: ' + error);
            console.error(xhr.responseText);
          }
        });
      });
    });
  </script>