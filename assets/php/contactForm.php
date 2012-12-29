<?php
	$to = "oliver@ojs.co";
	$responce = array(
		"errors" => array()
	);

	if (!isset($_POST['forename'])) $responce["errors"][] = 'forename'; 
	if (!isset($_POST['phone'])) $responce["errors"][] = 'phone'; 

	$forename = $_POST['forename'];
	$surname = $_POST['surname'] ? $_POST['surname']: "";
	$email = $_POST['email'] ? $_POST['email']: "";
	$phone = $_POST['phone'];

	if(count($responce["errors"]) > 0) {
		die(json_encode($responce));
	} else {
		$responce["errors"] = false;
	}

	$message = "Contact Request From: \n\nName: $forename $surname\nEmail: $email\nPhone: $phone";
	$responcemsg = "Hi $forename $surname,\n\nThanks for contacting St Albans Sub Aqua Club. We will respond shortly.\n\nCheers,\nSt Albans Sub Aqua Club.";

	mail($to, 'SASAC Contact Request', $message);
	if (strlen($email) > 0) {
		mail($email, "St Albans Sub Aqua Club", $responcemsg);
	}

	die(json_encode($responce));
?>
