<?php
if (!isAuthenticated()) { 
  if(isset($_POST["Authenticate"])) {
?>
      <span class="label label-important">Username/password combination not found, please try again.</span>
<?php
  }
?>
      <form action="" method="post" class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="inputEmail">Email</label>
          <div class="controls">
            <input type="text" name="EmailAddress" id="Email" placeholder="Email" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">Password</label>
          <div class="controls">
            <input name="Password" type="password" id="Password" placeholder="Password" />
            <button type="submit" class="btn">Sign in</button>
          </div>
        </div>
        <input type="hidden" name="Submit" value="Authenticate" />
      </form>
<?php
} else {
?>      
      <h1>SASAC CMS</h1>
      <p>Use this CMS to manage website content, contact users and view important information<br>regarding site statistics and page faults.</p>
<?php
}
clearErrors();
?>