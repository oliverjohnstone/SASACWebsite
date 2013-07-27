<?php
	$emailToCheckField = array(
		"all@sasac.co.uk" => array("scuba", "snorkel", "social", "swimming", "announcements", "honorary"),
		"scuba@sasac.co.uk" => array("scuba"),
		"snorkel@sasac.co.uk" => array("snorkel"),
		"social@sasac.co.uk" => array("social"),
		"swimming@sasac.co.uk" => array("swimming"),
		"announcements@sasac.co.uk" => array("announcements"),
		"honorary@sasac.co.uk" => array("honorary")
	);

	if (!isset($_GET["u"] || !isset($_GET["l"]))) {
		die("Sorry, we were unable to subsribe you at this moment in time. Please contact SASAC to resolve the issue.");
	}
	$unsubscribeHash = $_GET["u"];
	$list = $_GET["l"];
	
	// Hash all the above emails to prevent possible spoofing
	$email = false;
	foreach ($unsubscribableLists as $email => $columns) {
		if (md5($email) === $unsubscribeHash) {
			if ($columns) {
				$email = $email;
			} 
			break;
		}
	}

	if(!$email) {
		die("Sorry, we were unable to subsribe you at this moment in time. Please contact SASAC to resolve the issue.");		
	}

	$connection = mysql_connect("localhost", "sasac_membership", "cheesing@misruling") or die(mysql_error());
	mysql_select_db("sasac_membership") or die(mysql_error());

	$sql = "UPDATE Members SET ";

	foreach ($emailToCheckField[$email] as $column) {
		$sql .= "$column = false, ";
	}

	// Remove the final space and comma.
	$sql = substr($sql, 0, strlen($sql) - 2);

	$sql = " WHERE unsubscribe = " mysql_real_escape_string($unsubscribeHash);

	mysql_query($sql) or die(mysql_error());

	die("Thank you, you have successfully been removed from the " . $email . " mailing list.");
