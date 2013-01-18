<?php
error_reporting(E_ALL);
require_once "auth.php";
require_once "application.php";
$auth = new Authenticate();
$application = Application::getApplication();
if (isset($_POST["Authenticate"])) {
  $auth->authenticate($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SASAC CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="St Albans Sub Aqua Club's CMS">
    <meta name="author" content="Oliver Johnstone">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">St Albans Sub Aqua Club</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
<?php
if (!$auth->isAuthenticated()) {
  if ($application->hasErrors()) {
  var_dump($_SESSION); exit;
    foreach ($application->getErrors() as $error) {
?>
      <span class="label label-important"><?php echo $error; ?></span>
<?php
    }
  }
?>
      <form action="" method="post" class="form-horizontal">
        <div class="control-group">
          <label class="control-label" for="inputEmail">Email</label>
          <div class="controls">
            <input type="text" id="Email" placeholder="Email">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputPassword">Password</label>
          <div class="controls">
            <input type="password" id="Password" placeholder="Password">
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <label class="checkbox">
              <input type="checkbox"> Remember me
            </label>
            <button type="submit" class="btn">Sign in</button>
          </div>
        </div>
        <input type="hidden" name="Authenticate" value="1" />
      </form>
<?php
} else {
?>      
      <h1>SASAC CMS</h1>
      <p>Use this CMS to manage website content, contact users and view important information<br>regarding site statistics and page faults.</p>
<?php
}
?>

    </div>
    <script src="../assets/js/jquery/jquery-1.9.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>
