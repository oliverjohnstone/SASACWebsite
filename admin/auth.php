<?php
require_once "database.php";
session_start();
dbConnect();

function auth(&$params) {
	if (isset($_SESSION["User"])) return true;
	$email = isset($params["EmailAddress"]) ? $params["EmailAddress"] : "";
	$password = isset($params["Password"]) ? $params["Password"] : "";
	if ($admin = getAdmin($email, $password)) {
		$_SESSION["User"] = $admin;
		return true;
	} else {
		return false;
	}
}

function getAdmin($email, $password) {
	if (empty($email) || empty($password)) return false;
	$email = mysql_real_escape_string($email);
	$sql = "SELECT Password FROM Admins WHERE EmailAddress='$email'";
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result) <= 0) return false;
	if (is_array($result)) $result = array_shift($result);
	$result = mysql_fetch_array($result);
	$result = array_shift($result);
	$parts = explode(":", $result);
	$salt = $parts[0];
	$hash = $parts[1];
	if (generatePasswordHash($salt, $password) !== $salt . ":" . $hash) return false;
	return array(
		"Email" => $email,
		"Password" => $hash,
		"Salt" => $salt
	);
}

function getUserEmail() {
	if(isset($_SESSION["User"]["Email"])) {
		return $_SESSION["User"]["Email"];
	}
	return false;
}

function resetPassword($email, $password = false) {
	$email = mysql_real_escape_string($email);
	$sendEmail = false;
	if (!$password) {
		$sendEmail = true;
		$password = generateRandomSalt(10);
	}
	$newPassword = generatePasswordHash(generateRandomSalt(), $password);
	$sql = "UPDATE Admins SET Password='$newPassword' WHERE EmailAddress='$email'";
	mysql_query($sql) or die(mysql_error());
	if (mysql_affected_rows() <= 0) return false;
	if ($sendEmail) {
		mail($email, 
			"Password reset",
			"You asked for your password to be reset on the SASAC admin page, here is your new password: $password",
			"From: no-reply@sasac.co.uk"
		);
	}
	return true;
}

function getUserSalt() {
	if (isset($_SESSION["User"])) {
		return $_SESSION["User"]["Salt"];
	}
	return "";
}

function getUserPassword() {
	if (isset($_SESSION["User"])) {
		return $_SESSION["User"]["Password"];
	}
	return "";
}

function createAdmin($email, $password) {
	$email = mysql_real_escape_string($email);
	$password = generatePasswordHash(generateRandomSalt(), $password);
	$sql = "INSERT INTO Admins (EmailAddress, Password) VALUES ('$email', '$password')";
	mysql_query($sql) or die(mysql_error());
	if (mysql_affected_rows() >= 1) return true;
	return false;
}

function generatePasswordHash($salt, $password) {
	return $salt . ":" . hash("sha512", $salt . $password . $salt);
}

function generateRandomSalt($length = 40) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
	$len = 61;
	$length = $length > $len ? $len : $length;
	$salt = substr(str_shuffle($chars), 0, $length);
	return $salt;
}

function isAuthenticated() {
	return isset($_SESSION["User"]);
}