<?php

function compile($header, $tableHeader, $blurb, $footer, $params) {
	$content = $header;
	$content .= date("l dS F Y");
	$content .= $tableHeader;

	$sections = array("News", "Diving", "Training", "Social");
	foreach ($sections as $section) {
		if (isset($params[$section]) && count($params[$section]) > 0) {
			$content .= "<tr><td><h3>$section</h3></td></tr>";
			foreach ($params[$section] as $title => $itemContent) {
				$content .= "<tr><td>";
				$content .= "<p style='font-weight:bold; padding-left: 20px;'>$title</p>";
				$content .= "<p style='padding-left:20px;'>$itemContent</p>";
				$content .= "</td></tr>";
			}
		}
	}

	$content .= $blurb;
	$link = $params["ViewInBrowser"];
	$content .= "<p>Cant read this email? Click <a href='$link' target='_blank'>here</a>.</p>";
	$content .= $footer;
	return $content;
}

$header =<<<HTML
<table style="background-image: url('http://sasac.ojs.co/assets/img/background-tile.png'); padding-bottom: 47px; margin: -10px;">
	<tr>
		<td>
			<table style="width: 100%; position:relative; top: 20px;" cellspacing="0">
				<tr>
					<td style="width: 10%;"></td>
					<td style="width: 80%;">
						<table style="width: 100%;" cellspacing="0">
							<tr>
								<td style="width: 80%; border-top-left-radius: 10px; background-color: white; padding-left: 10px; padding-top:5px;">
HTML;

$tableGunf =<<<HTML
								</td>
								<td style="width: 100%;border-top-right-radius: 10px; background-color: white;">&nbsp;</td>
							</tr>
							<tr style="background-color: white">
								<td style="width: 80%; text-align: center;">
									<h2 style="font-size: 30px;">St Albans Sub Aqua Club's Announcements<h2>
								</td>
								<td style="width: 10%">
									<div style="margin-left: auto; margin-right: auto; position:relative; width: 164px; height: 162px; top: -15px;">
										<img src="http://sasac.ojs.co/assets/media/general/sasac_logo.png">
									</div>
								</td>
							</tr>
						</table>

						<table style="width: 100%; top: 0px; position:relative; background-color: white; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; padding-left: 10px; padding-right: 10px;">
HTML;

$blurb =<<<HTML
							<tr style="background-color: white;">
								<td style="padding-top: 10px;">
									<h3>General Information</h3>

									<p>If you want to include anything in announcements, please send an email to <a href="mailto:sasacannounce@gmail.com">sasacannounce@gmail.com</a> with the exact wording you want and we will guarantee that it will be included in the next Announcements. If it accidentally overlooked, a special announcement will be sent out specifically for the omitted item. Note that this guarantee does not apply to messages sent by email any other address, paper notes, verbal conversations, carrier pigeons or any other method.</p>

									<p style="font-weight: bold">See our Club Website at <a href="http://www.sasac.co.uk/" target="_blank">www.sasac.co.uk</a></p>

									<p>Please visit the club website and pass any comments or ideas back to our Webmaster at <a href="mailto:webmaster@sasac.co.uk">webmaster@sasac.co.uk</a> There's a link from the website to the club FORUM. Anyone can read, but only members can post. All members should have been given passwords. If not, contact <a href="mailto:webmaster@sasac.co.uk">webmaster@sasac.co.uk</a></p>

									<h3>About This Email</h3>

									<p>This email is sent out weekly to those who have requested it and are on our announcements email list. If you don't want it or want it sent to a different email address then reply to this email with details. If you know anyone, club member or not, who may be interested in this email then forward it to them. If this has been forwarded to you and you want to receive it weekly then request it from <a href="mailto:sasacannounce@gmail.com">sasacannounce@gmail.com</a>.</p>
								</td>
							</tr>
							<tr style="height: 10px;">
								<td style="padding-top: 20px;">-- The Announcements Team --</td>
							</tr>
							<tr>
								<td style="text-align: center;">
HTML;

$footer =<<<HTML
								</td>
							</tr>
						</table>
					</td>
					<td style="width: 10%; vertical-align: top;">
						<a style="position: relative; float: right;" href="http://www.facebook.com/StAlbansSubAquaClub" target="_blank"><img src="http://sasac.ojs.co/assets/img/facebook-right.png"></a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
HTML;
