<?php

require_once "includes/functions.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
  if (empty($_POST['email']) || empty($_POST['password'])) {
      response('error','Please fill in all fields');
      exit;
  }
  $email = $_POST["email"];
  $password = $_POST["password"];
  login($email, $password);
  exit;
}

include "layout/header.php" ;

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