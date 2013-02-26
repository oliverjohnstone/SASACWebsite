<?php
set_include_path(getcwd());
error_reporting(E_ALL);
require_once "logic.php";

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
    <link href="assets/css/application.css" rel="stylesheet">
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

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
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
              <li><a href="/admin/">Home</a></li>
<?php
if (isAuthenticated()) {
?>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Content
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="content-home">Home</a></li>
                  <li><a href="content-technical">Technical Diving</a></li>
                  <li><a href="content-training">Training</a></li>
                  <li><a href="content-instructors">Instructors</a></li>
                  <li><a href="content-calendar">Calendar</a></li>
                  <li><a href="content-restoration">Restoration Grant</a></li>
                  <li><a href="content-social">Social</a></li>
                  <li><a href="content-links">Links</a></li>
                </ul>
              </li>
              <li><a href="announcements">Announcements</a></li>
              <li><a href="#contact">Contact</a></li>
<?php
}
?>
              <li><a href="reset-password"><?php echo isAuthenticated() ? "Change Password" : "Reset Password" ?></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
<?php
      include getIncludeFile();
?>
    </div>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/nicEdit.js"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
  </body>
</html>
