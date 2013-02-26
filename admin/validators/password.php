<?php
require_once "logic.php";
require_once "auth.php";

function validatePasswordReset() {
	$valid = true;
	if (!isset($_POST["EmailAddress"])) {
		addError("EmailAddress", "Please enter your email address");
		$valid = false;
	}
	return $valid;
}

function validateChangePassword() {
	$valid = true;
	if (!isset($_POST["Password"])) {
		addError("EmailAddress", "Please enter your current password");
		$valid = false;
	}
	if (!isset($_POST["NewPassword"])) {
		addError("NewPassword", "Please enter your new password");
		$valid = false;
	}
	if (!isset($_POST["ConfirmPassword"])) {
		addError("ConfirmPassword", "Please confirm your new password");
		$valid = false;
	}
	if (isset($_POST["ConfirmPassword"]) && isset($_POST["NewPassword"]) && $_POST["ConfirmPassword"] != $_POST["NewPassword"]) {
		addError("ConfirmPassword", "Your passwords did not match");
		$valid = false;
	}

	if (isAuthenticated()) {
		$hash = generatePasswordHash(getUserSalt(), $_POST["Password"]);
		if ($hash !== getUserSalt() . ":" . getUserPassword()) {
			addError("Password", "Your current password was entered incorrectly");
			$valid = false;
		}
	}
	return $valid;
}