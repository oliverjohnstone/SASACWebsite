<?php
require_once "auth.php";
require_once "validators/password.php";

if(isset($_POST["Submit"])) {
	switch($_POST["Submit"]) {
		case "Authenticate":
			auth($_POST);
		break;
	
		case "ChangePassword":
			if (validateChangePassword()) {
				if (resetPassword(getUserEmail(), $_POST["NewPassword"])) {
					redirect("?Success=2");
				} else {
					addError("Password", "Your current password was entered incorrectly");
				}
			}
		break;

		case "ResetPassword":
			if (validateResetPassword()) {
				if (resetPassword($_POST["EmailAddress"])) {
					redirect("?Success=1");
				} else {
					addError("EmailAddress", "Please enter a valid email address");
				}
			}
		break;

		default:
		break;
	}
}

function redirect($location) {
	header("Location: $location");
	exit;
}

function getIncludeFile() {
	$paths = array(
		"reset-password" => "assets/pages/resetPassword.php",
		"content-home" => "assets/pages/home.php",
		"content-calendar" => "assets/pages/calendar.php",
		"content-instructors" => "assets/pages/instructors.php",
		"content-links" => "assets/pages/links.php",
		"content-restoration" => "assets/pages/restoration.php",
		"content-social" => "assets/pages/social.php",
		"content-technical" => "assets/pages/technical.php",
		"content-training" => "assets/pages/training.php"
	);

	$path = isset($_GET["page"]) ? $_GET["page"] : ""; 

	if ((isset($paths[$path]) && isAuthenticated()) || $path == "reset-password") {
		return $paths[$path];
	}

	return "assets/pages/login.php";
}

function hasErrors() {
	return isset($_SESSION["Errors"]) && count($_SESSION["Errors"]) > 0; 
}

function errorOn($field) {
	if (hasErrors() && isset($_SESSION["Errors"][$field])) {
		return $_SESSION["Errors"][$field];
	} else {
		return false;
	}
}

function addError($field, $message) {
	if (!isset($_SESSION["Errors"])) {
		clearErrors();
	}
	$_SESSION["Errors"][$field] = $message;
}

function clearErrors() {
	$_SESSION["Errors"] = array();
}

function getErrors() {
	if (isset($_SESSION["Errors"])) {
		return $_SESSION["Errors"];
	} else {
		return array();
	}
}