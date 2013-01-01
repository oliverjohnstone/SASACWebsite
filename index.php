<?php
	$str = file_get_contents("properties.json");
	$settings = json_decode($str);
	$reqPage = $settings->pages->pageNotFound->path;
	$title = $settings->pages->pageNotFound->title;
	$name = $settings->pages->pageNotFound->name;
	if (isset($_GET["page"])) {
		$tmp = $_GET["page"];
		if (isset($settings->paths->$tmp)) {
			$path = $settings->PageRoot . $settings->pages->{$settings->paths->$tmp}->path;
			if (is_readable($path)) {
				$reqPage = $path;
				$title = $settings->pages->{$settings->paths->$tmp}->title;
				$name = $settings->pages->{$settings->paths->$tmp}->name;
			}
		}
	} else {
		$reqPage = $settings->PageRoot . $settings->pages->home->path;
		$title = $settings->pages->home->title;
	}
?>

<!doctype html>
<html>
	<head>
		<title>
<?php
echo $name . " | St Albans Sub Aqua Club";
?>
		</title>
		
<?php
echo "<meta name=\"keywords\" content=\"";
foreach ($settings->keywords as $value) {
	echo $value . ",";
}
echo "\">";

echo "<meta name=\"description\" content=\"";
echo $settings->description;
echo "\">";
?>
		<meta name="author" content="Oliver Johnstone">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
		<!--[if !IE 6]>-->
			<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="assets/css/application.css">
			<link rel="stylesheet" type="text/css" href="assets/css/cookieconsent.min.css"/>
			<script type="text/javascript" src="assets/js/plugins/cookieconsent.min.js"></script>
			<script type="text/javascript">
				// <![CDATA[
				cc.initialise({
					cookies: {
						social: {},
						analytics: {},
						necessary: {}
					},
					settings: {
						consenttype: "implicit",
						hideprivacysettingstab: true,
						onlyshowbanneronce: false,
						disableallsites: true
					}
				});
				// ]]>
			</script>
<?php
foreach ($settings->requiredJS as $file) {
	echo '<script type="text/javascript" src="' . $settings->JSRoot . $file . '"></script>' . PHP_EOL;
}
?>
		<!--<[endif]-->
		<!--[if IE]>
			<link rel="stylesheet" type="text/css" href="assets/css/ie.css">
		<![endif]-->
		<!--[if lte IE 8]>
			<link rel="stylesheet" type="text/css" href="assets/css/ie8.css">
		<![endif]-->
		<!--[if lte IE 7]>
			<link rel="stylesheet" type="text/css" href="assets/css/ie7.css">
		<![endif]-->
		<!--[if lte IE 6]>
			<link rel="stylesheet" type="text/css" href="assets/css/ie6.css">
		<![endif]-->
	</head>
	<body>
		<div class="ie-container">
<div id="fb-root"></div>
		<div id="fb-root"></div>
		<script type="text/plain" class="cc-onconsent-social">(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=399722736762882";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<!--[if lte IE 6]>
			<script src="assets/ie6/warning.js"></script>
			<script>
				window.onload=function(){e("assets/ie6/")}
			</script>
		<![endif]-->
		<div class="app" id="app">
			<div class="fb-like" data-href="http://sasac.co.uk" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
			<a href="https://twitter.com/share" class="twitter-share-button" data-text="Check out St Albans Sub Aqua Club" data-via="StAlbansSAC" data-size="small">Tweet</a>
<script type="text/plain" class="cc-onconsent-social">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<div class="menu">
				<ul>
<?php
foreach ($settings->pages as $array_key => $page) {
	$key = array_search($array_key, (array) $settings->paths);
	if (!$key) continue;
	$name = $page->name;
	$path = $key;
	$class = "menuitem";
	if ($settings->PageRoot . $page->path === $reqPage) {
		$class .= " selected";
	}
	echo "<li id=\"" . $name . "\" class=\"" . $class . "\" path=\"" . $path . "\">" . $name . "</a></li>";
}
foreach ($settings->exceptions as $key => $value) {
	echo "<li id=\"" . $key . "\" class=\"menuitem\" path=\"" . $value . "\">" . $key . "</li>";
}
?>
				</ul>
			</div>
			<div class="content">
				<div class="horizontal-menu">
					<ul>
						<li><a href="#" onclick="$('#contact-us').modal(); return false;">Contact Us</a></li>
						<li><a href="#" onclick="$('#tools').modal(); return false;">Tools</a></li>
						<li><a href="#" onclick="$('#site-map').modal(); return false;">Site Map</a></li>
					</ul>
				</div>
				<div class="edge"></div>
				<div class="header">
					<div class="page-title"><h1>
<?php
echo $title;
?>
					</h1></div>
					<div class="logo"></div>
				</div>
				<div class="content-body">
					<div class="image-wrap"></div>
					<div class="page-content">
<?php
echo file_get_contents($page);
?>
					</div>
				</div>
			</div>
			<!--[if IE]>
			<div class="ie-bottom ie7-bottom"></div>
			<![endif]-->
		</div>
		<div class="footer">&copy; Copyright <script type="text/javascript">document.write((new Date()).getFullYear())</script> St Albans Sub Aqua Club</div>
		<div class="modal hide fade" id="contact-us">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>Contact Us</h3>
			</div>
			<div class="modal-body">
				<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=St+Albans+Sub+Aqua+Club,+Cottonmill+Lane,+St.+Albans&amp;aq=0&amp;oq=st+albans+sub+&amp;sll=51.746695,-0.336199&amp;sspn=0.007387,0.019741&amp;t=h&amp;g=Cottonmill+swimming+pool,+Saint+Albans&amp;ie=UTF8&amp;hq=St+Albans+Sub+Aqua+Club,&amp;hnear=Cottonmill+Ln,+St+Albans,+United+Kingdom&amp;ll=51.746167,-0.336061&amp;spn=0.014772,0.039482&amp;z=14&amp;iwloc=A&amp;cid=8029491325922838352&amp;output=embed"></iframe><br /><small><a href="https://www.google.co.uk/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=St+Albans+Sub+Aqua+Club,+Cottonmill+Lane,+St.+Albans&amp;aq=0&amp;oq=st+albans+sub+&amp;sll=51.746695,-0.336199&amp;sspn=0.007387,0.019741&amp;t=h&amp;g=Cottonmill+swimming+pool,+Saint+Albans&amp;ie=UTF8&amp;hq=St+Albans+Sub+Aqua+Club,&amp;hnear=Cottonmill+Ln,+St+Albans,+United+Kingdom&amp;ll=51.746167,-0.336061&amp;spn=0.014772,0.039482&amp;z=14&amp;iwloc=A&amp;cid=8029491325922838352" style="color:#0000FF;text-align:left">View Larger Map</a></small>
				<address>
					SASAC clubhouse<br />
					Cottonmill Swimming Pool<br />
					Cottonmill Lane<br />
					St Albans<br />
					Hertfordshire<br />
					AL1 1HJ<br />
					01727 859 829
				</address>
				<p>If you want to contact us about training, membership, technical issues please use the above number or use the <a href='#' onclick='$("#LearnToDiveP").click(); $("#contact-us").modal("hide"); return false;'>contact us</a> form to send an email.The club is run by volunteers but we will always attempt to respond in a reasonable time.</p>
			</div>
		</div>
		<div class="modal hide fade" id="site-map">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>Site Map</h3>
			</div>
			<div class="modal-body">
				<ul class="site-map">
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#HomeP').click(); return false;">Home</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#LearnToDiveP').click(); return false;">Learn To Dive</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#AlreadyADiverP').click(); return false;">Already A Diver</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#SnorkellingP').click(); return false;">Snorkelling</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#UnderwaterHockeyP').click(); return false;">Underwater Hockey</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#SocialP').click(); return false;">Social</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#TheInstructorsP').click(); return false;">The Instructors</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#CalendarP').click(); return false;">Calendar</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#PhotoCompetitionP').click(); return false;">Photo Competition</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#ForumP').click(); return false;">Forum</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#RestorationGrantP').click(); return false;">Restoration Grant</a></li>
					<li><a href="#" onclick="$('#site-map').modal('hide'); $('#DownloadsP').click(); return false;">Downloads</a></li>
				</ul>
			</div>
		</div>
		<div class="modal hide fade" id="tools">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>Tools</h3>
			</div>
			<div class="modal-body">
				<h3>Tools, coming soon.</h3>
				<p>Possible tools to come:</p>
				<ul>
					<li>On line dive logs - with user tagging</li>
					<li>Website CMS</li>
					<li>Dive group mailing lists</li>
					<li>Google calendar integration</li>
					<li>Dive planning tool</li>
				</ul>
				<p>If you have any suggestions, please email <a href='mailto:webmaster@sasac.co.uk'>webmaster@sasac.co.uk</a></p>
			</div>
		</div>
	</div><!-- IE Container -->
	</body>
</html>