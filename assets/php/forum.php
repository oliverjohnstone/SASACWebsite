<?php
	// define("DEBUG", 1);
	define("APPLICATION_URL", "sasac.ojs.co");

	if (defined("DEBUG")) {
		ini_set('display_errors',1); 
		error_reporting(E_ALL);
	}

	require_once("factory.php");
	$auth = Factory::getAuth();

	$respone = new stdClass();
	$email = null;

	if (!$email = $auth->auth()) {
		if (!isset($_POST["email"]) || !isset($_POST["password"])) {
			$respone->errors = true;
			echo json_encode($respone);
			exit();
		}
		$email = $_POST["email"];
		$password = $_POST["password"];
		$remember = false;
		if (isset($_POST["remember"]) && $_POST["remember"] == 1) $remember = true; 
		if (!$email = $auth->auth($email, $password, $remember)) {
			$respone->errors = true;
			echo json_encode($respone);
			exit();
		}
	}
	header("Content-Type: application/json");

	$user = Factory::getUser($email);
	if (!$user->isValid()) {
		$respone->errors = true;
	} else {
		$contentGenerator = Factory::getContentGenerator($user);
		$respone->body = $contentGenerator->buildContent();
	}
	
	echo json_encode($respone);
?>