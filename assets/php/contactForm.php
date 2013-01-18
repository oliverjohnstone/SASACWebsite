<?php
	$to = "oliver@ojs.co";
	$from = "hello@sasac.co.uk";
	$responce = array(
		"errors" => array()
	);

	if (!isset($_POST['forename'])) $responce["errors"][] = 'forename'; 
	if (!isset($_POST['phone'])) $responce["errors"][] = 'phone'; 

	$forename = ucfirst($_POST['forename']);
	$surname = ucfirst($_POST['surname']) ? ucfirst($_POST['surname']): "";
	$email = $_POST['email'] ? $_POST['email']: "";
	$phone = $_POST['phone'];

	if(count($responce["errors"]) > 0) {
		die(json_encode($responce));
	} else {
		$responce["errors"] = false;
	}

	$message = "Contact Request From: \n\nName: $forename $surname\nEmail: $email\nPhone: $phone";
	$responcemsg = "Hi $forename,\n\nThanks for contacting St Albans Sub Aqua Club. We will respond shortly.\n\nKind Regards,\nSt Albans Sub Aqua Club.";

	$headers = "From: no-reply@sasac.co.uk\n";
	mail($to, 'SASAC Contact Request', $message, $headers);
	if (strlen($email) > 0) {
		$headers = "From: $from\n";
		mail($email, "St Albans Sub Aqua Club", $responcemsg, $headers);
	}

	die(json_encode($responce));
?>
