<?php
	$toAddress = "oliver@ojs.co";
	$fromAddress = "hello@sasac.co.uk";

	function defaultValue($name, $default) {
		return isset($_POST[$name]) ? trim($_POST[$name]) : $default;
	}
	$_POST["Forename"] = defaultValue("Forename", "");
	$_POST["Surname"] = defaultValue("Surname", "");
	$_POST["PhoneNumber"] = defaultValue("PhoneNumber", "");
	$_POST["Email"] = defaultValue("Email", "");
	$_POST["Message"] = defaultValue("Message", "");

	$errors = false;

	if (isset($_POST["Submit"])) {
		$errors = array();

		if (strlen($_POST["Forename"]) <= 0) {
			$errors["Forename"] = "First name is required";
		}
		if (strlen($_POST["Email"]) <= 0) {
			$errors["Email"] = "Email address is required";
		}
		if (strlen($_POST["Message"]) <= 0) {
			$errors["Message"] = "Message is required";
		} else if (strlen($_POST["Message"]) < 7) {
			$errors["Message"] = "Surely you want to send us a message longer than that?!";
		}

		if (count($errors) <= 0) {
			mail($_POST["Email"], 
				"Thank you for contacting us.", 
				"Hi " . $_POST['Forename'] . PHP_EOL . PHP_EOL .
					"Thanks you for contacting St Albans Sub Aqua Club, we will be in contact shortly." . PHP_EOL . PHP_EOL .
					"Kind Regards" . PHP_EOL .
					"St Albans Sub Aqua Club", 
				"From: $fromAddress\r\n" .
				"Reply-To: $toAddress");

			mail($toAddress, 
				"Contact request from SASAC website", 
					"The following message was posted on the SASAC website\r\n" .
					"Name: " . $_POST['Forename'] . " " . $_POST['Surname'] . "\r\n" .
					"Email: " . $_POST['Email'] . "\r\n" .
					"Message: \r\n" . $_POST['Message'],
				"From: $fromAddress");
			$_POST["Forename"] = "";
			$_POST["Surname"] = "";
			$_POST["PhoneNumber"] = "";
			$_POST["Email"] = "";
			$_POST["Message"] = "";
		}
	}
?>

<p>There are a few ways you can get in contact with us, you can use the form below, you can email us at <a href="mailto:hello@sasac.co.uk">
	hello@sasac.co.uk</a>, you can phone us on 01727 859 829 or you can come visit us on a Wednesday evening. We have our own clubhouse with 
	an open air pool, compressor, lecture room, booster pump, kit hire and to top it off, a fully stocked bar. We are open every Wednesday from 20:00
	and most Fridays.</p>
<p>
<address>
	SASAC Clubhouse (<a href="https://maps.google.co.uk/maps?q=St+Albans+Sub+Aqua+Club,+Cottonmill+Lane,+St.+Albans&hl=en&ll=51.746741,-0.336006&spn=0.005766,0.015814&sll=41.582093,2.548782&sspn=0.013932,0.031629&oq=St+Albans+Sub+A&t=h&hq=St+Albans+Sub+Aqua+Club,+Cottonmill+Lane,+St.+Albans&z=17&iwloc=A" target="_blank">view map</a>)<br />
	Cottonmill Swimming Pool<br />
	Cottonmill Lane<br />
	St Albans<br />
	Hertfordshire<br />
	AL1 1HJ<br />
	01727 859 829
</address></p>

<div class="contact-us">
	<?php
	if ($errors && count($errors) > 0) {
?>
	<span class="label label-important">There seems to be an error with the form, please correct them and try again.</span>
<?php
	} else if (is_array($errors) && count($errors) <= 0) {
?>
	<span class="label label-success">You successfully submitted the contact us form, we will be in contact shortly.</span>
<?php
	}
?>
	<form method="post">
		<div class="control-group <?php echo isset($errors["Forename"]) ? "error" : ""; ?>">
			<label>First Name</label>
			<div class="controls">
				<input class="input-large" type="text" id="inputForename" placeholder="First Name" name="Forename" value="<?php echo $_POST["Forename"]; ?>">
				<span class="help-inline"><?php echo isset($errors["Forename"]) ? $errors["Forename"] : ""; ?></span>
			</div>
		</div>
		<div class="control-group">
			<label>Surname</label>
			<div class="controls">
				<input class="input-large" type="text" id="inputSurname" placeholder="Surname" name="Surname" value="<?php echo $_POST["Surname"]; ?>">
			</div>
		</div>
		<div class="control-group">
			<label>Phone Number</label>
			<div class="controls">
				<input class="input-large" type="text" id="inputNumber" placeholder="Phone Number" name="PhoneNumber" value="<?php echo $_POST["PhoneNumber"]; ?>">
			</div>
		</div>
		<div class="control-group <?php echo isset($errors["Email"]) ? "error" : ""; ?>">
			<label>Email Address</label>
			<div class="controls">
				<input class="input-large" type="text" id="inputEmail" placeholder="Email Address" name="Email" value="<?php echo $_POST["Email"]; ?>">
				<span class="help-inline"><?php echo isset($errors["Email"]) ? $errors["Email"] : ""; ?></span>
			</div>
		</div>
		<div class="control-group <?php echo isset($errors["Message"]) ? "error" : ""; ?>">
			<label>Your Message</label>
			<div class="controls">
				<textarea class="input-xlarge" id="inputMessage" placeholder="Enter your message in here" name="Message"><?php echo $_POST["Message"]; ?></textarea>
				<span class="help-inline"><?php echo isset($errors["Message"]) ? $errors["Message"] : ""; ?></span>
			</div>
			<button type="submit" class="btn btn-primary" name="Submit" value="Submit">Contact Me</button>
		</div>
	
	</form>
</div>