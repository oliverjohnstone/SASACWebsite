<h2>Password Reset</h2>

<?php 
 /**
  * This file needs to especially padded out so that it can be used without
  * having first logged in.
  */
if (isset($_GET["Success"]) && $_GET["Success"] == 1) {
?>
  <div class="success-message">
    <h1>Success</h1>
    <p>Please check your email for your new password.</p>
  </div>
<?php
} else if (isset($_GET["Success"]) && $_GET["Success"] == 2) {
?>
  <div class="success-message">
    <h1>Success</h1>
    <p>Thank you for changing your password, please use your new password the next time you login.</p>
  </div>
<?php
} else {
?>

<p>Use this form to reset or change your password.</p>

<?php
if (hasErrors()) {
?>
<span class="label label-important">Your form has some errors, please correct them and try again.</span>
<?php
}
?>

<form action="" method="post" class="form-horizontal">
<?php
if(isAuthenticated()) {
?>
  <div class="control-group">
    <label class="control-label" for="Password">Password</label>
    <div class="controls">
      <input type="password" name="Password" id="Password" placeholder="Password" class="<?php echo ($error = errorOn("Password")) ? "error" : "" ?>"/>
<?php
  if($error) {
?>
      <span class="error-message"><?php echo $error; ?></span>
<?php
    $error = false;
  }
?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="NewPassword">New Password</label>
    <div class="controls">
      <input name="NewPassword" type="password" id="NewPassword" placeholder="New Password" class="<?php echo ($error = errorOn("NewPassword")) ? "error" : "" ?>" />
<?php
  if($error) {
?>
      <span class="error-message"><?php echo $error; ?></span>
<?php
    $error = false;
  }
?>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="ConfirmPassword">Confirm Password</label>
    <div class="controls">
      <input name="ConfirmPassword" type="password" id="ConfirmPassword" placeholder="Confirm Password" class="<?php echo ($error = errorOn("ConfirmPassword")) ? "error" : "" ?>" />
<?php
  if($error) {
?>
      <span class="error-message"><?php echo $error; ?></span>
<?php
    $error = false;
  }
?>
      <button type="submit" class="btn">Change Password</button>
    </div>
  </div>
  <input type="hidden" name="Submit" value="ChangePassword" />
<?php
} else {
?>
  <div class="control-group">
    <label class="control-label" for="Email">Email</label>
    <div class="controls">
      <input type="text" name="EmailAddress" id="Email" placeholder="Email" class="<?php echo ($error = errorOn("EmailAddress")) ? "error" : "" ?>" />
<?php
  if($error) {
?>
      <span class="error-message"><?php echo $error; ?></span>
<?php
    $error = false;
  }
?>
      <button type="submit" class="btn">Reset Password</button>
    </div>
  </div>
  <input type="hidden" name="Submit" value="ResetPassword" />
<?php
}
?>
</form>
<?php
}
clearErrors();
?>