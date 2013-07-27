#!/usr/bin/php -q
<?php

	require_once("Mail/MimeMailParser.php");
	include 'Mail.php';
	include 'Mail/mime.php' ;

	$emailToCheckField = array(
		"all@sasac.co.uk" => array("scuba", "snorkel", "social", "swimming", "announcements"),
		"scuba@sasac.co.uk" => array("scuba"),
		"snorkel@sasac.co.uk" => array("snorkel"),
		"social@sasac.co.uk" => array("social"),
		"swimming@sasac.co.uk" => array("swimming"),
		"announcements@sasac.co.uk" => array("announcements"),
		"honorary@sasac.co.uk" => array("honorary")
	);

	$stdin = fopen("php://stdin", "r");
	if (!$stdin) exit;

	$emailParser = new MimeMailParser();
	$emailParser->setStream($stdin);

	$to = $from = $plainBody = $htmlBody = $subject = $attachments = $replyTo = false;

	$to = $emailParser->getHeader('to');
	$from = $emailParser->getHeader('from');
	$subject = $emailParser->getHeader('subject');
	$plainBody = $emailParser->getMessageBody('text');
	$htmlBody = $emailParser->getMessageBody('html');
	$replyTo = $emailParser->getHeader("reply-to");
	$attachments = $emailParser->getAttachments();

	if (count($attachments)) {
		$locations = array();
		$saveLocation = "/home/sasac/email_attachments/";
		foreach ($attachments as $attachment) {
			$filename = $attachment->filename;
			if ($fp = fopen($saveLocation . $filename, 'w')) {
				while($bytes = $attachment->read()) {
					fwrite($fp, $bytes);
				}
				fclose($fp);
				$locations[$saveLocation . $filename] = $attachment->getContentType();
			}
		}
		$attachments = $locations;
	} else {
		$attachments = false;
	}

	if (!preg_match("/.*@sasac.co.uk/", $from)) {
		echo "Permission Denied!";
		exit;
	}

	preg_match("/<(.*@sasac.co.uk)>/", $to, $to);

	if (!isset($emailToCheckField[$to[1]]) && $to[1] !== "test@sasac.co.uk") {
		echo("Invalid to address");
		exit;
	}


	if (isset($to[1]) && $from && $plainBody) {
		if ($to[1] === "test@sasac.co.uk") {
			email($from, $from, $subject ?: "St Albans Sub Aqua Club", $plainBody, $htmlBody, $attachments, $replyTo);
			return;
		}
		$connection = mysql_connect("localhost", "sasac_membership", "cheesing@misruling") or die(mysql_error());
		mysql_select_db("sasac_membership") or die(mysql_error());
		$sql = "SELECT email, unsubscribe FROM Members WHERE ";

		$first = true;
		foreach ($emailToCheckField[$to[1]] as $checkField) {
			if (!$first) $sql .= "OR ";
			$first = false;
			$sql .= $checkField . " = true ";
		}
		
		$result = mysql_query($sql) or die(mysql_error());
		$emails = array();


		while($row = mysql_fetch_array($result)) {
			$unsubscribeMsg = "You are receiving this email because you are subscribed to the " . $to[1] . " mailing list. " .
				"To unsubscribe please click this link. http://sasac.co.uk/Unsubscribe.php?l=" . md5($to[1]) . "&u=" . $row["unsubscribe"];

			$emails[] = $row["email"];
			email($row["email"], $from, $subject ?: "St Albans Sub Aqua Club", $plainBody . "\n\n" . $unsubscribeMsg, $htmlBody, $attachments, $replyTo);
		}

		foreach ($attachments as $attachment => $contentType) {
			unlink($attachment);
		}

		mail($from, "Message Delivered Successfully", "Your message was delivered successfully to " . count($emails) . " recipients.");
		exit(0);
	}

	echo "Failed to deliver message";

	function email($to, $from, $subject, $txtBody, $htmlBody, $attachments, $replyTo) {
		$mime = new Mail_mime(array('eol' => "\n"));
		$hdrs = array(
			"From" => $from,
			"Subject" => $subject
		);

		if ($replyTo) {
			$hdrs["Reply-To"] = $replyTo;
		}

		$mime->setTXTBody($txtBody);
		$mime->setHTMLBody($htmlBody);
		
		if($attachments) {
			foreach ($attachments as $filename => $contentType) {
				$mime->addAttachment($filename, $contentType);
			}
		}

		$body = $mime->get();
		$hdrs = $mime->headers($hdrs);

		$mail =& Mail::factory('mail');
		$mail->send($to, $hdrs, $body);
	}