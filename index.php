<?php
require_once "bootstrap.php";
?>
<!doctype html>
<html>
	<head>
		<title><?php echo $name; ?> | St Albans Sub Aqua Club</title>
		<meta name="keywords" content="<?php echo implode(",", $settings->keywords); ?>" />
		<meta name="description" content="<?php echo $settings->description; ?>" />
		<meta name="author" content="Oliver Johnstone">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
		<!--[if !IE 6]>-->
			<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="assets/css/application.css">
			<link rel="stylesheet" type="text/css" href="assets/css/cookieconsent.min.css"/>
			<script type="text/javascript" src="assets/js/plugins/cookieconsent.min.js"></script>
			<script type="text/javascript" src="assets/js/jquery/jquery-1.9.0.min.js"></script>
			<script type="text/javascript" src="assets/js/jquery/jquery-ui-1.8.21.custom.min.js"></script>
			<script type="text/javascript" src="assets/js/main.js"></script>
			<script type="text/javascript" src="assets/js/plugins/jquery-form.js"></script>
			<script type="text/javascript" src="assets/js/plugins/bootstrap-carousel.js"></script>
			<script type="text/javascript" src="assets/js/plugins/bootstrap-modal.js"></script>
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
			<div class="social">
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
			<div class="social">
				<div class="fb-like" data-href="http://sasac.co.uk" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
				<a href="https://twitter.com/share" class="twitter-share-button" data-text="Check out St Albans Sub Aqua Club" data-via="StAlbansSAC" data-size="small">Tweet</a>
			</div>
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
?>
					<li id="<?php echo $name; ?>" class="<?php echo $class; ?>" path="<?php echo $path; ?>"><?php echo $name; ?></li>
<?php
}
foreach ($settings->exceptions as $key => $value) {
?>
					<li id="<?php echo $key; ?>" class="menuitem" path="<?php echo $value; ?>"><?php echo $key; ?></li>
<?php
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
					<div class="page-title"><h1><?php echo $title; ?></h1></div>
					<div class="logo"></div>
				</div>
				<div class="content-body">
					<div class="image-wrap"></div>
					<div class="page-content"><?php echo file_get_contents($reqPage); ?></div>
				</div>
			</div>
			<!--[if IE]>
			<div class="ie-bottom ie7-bottom"></div>
			<![endif]-->
		</div>
		<div class="footer">&copy; Copyright <?php echo date("Y"); ?> St Albans Sub Aqua Club</div>
		<div class="modal hide fade" id="contact-us">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>Contact Us</h3>
			</div>
			<div class="modal-body">

				<address>
					SASAC Clubhouse<br />
					Cottonmill Swimming Pool<br />
					Cottonmill Lane<br />
					St Albans<br />
					Hertfordshire<br />
					AL1 1HJ<br />
					01727 859 829
				</address>
				<a target="_blank" href="http://maps.google.co.uk/maps?q=St+Albans+Sub+Aqua+Club,+Cottonmill+Lane,+St.+Albans&amp;hl=en&amp;ll=51.745927,-0.335984&amp;spn=0.002883,0.007907&amp;sll=52.8382,-2.327815&amp;sspn=11.533929,32.387695&amp;oq=st+albans+sub+&amp;hq=St+Albans+Sub+Aqua+Club,&amp;hnear=Cottonmill+Ln,+St+Albans,+United+Kingdom&amp;t=h&amp;z=18">View Map</a>
				<p>If you want to contact us about training, membership, technical issues please use the above number or use the 
					<a href='/Try-Dive'>contact us</a> form to send an email.The club is run by volunteers but we will always attempt 
					to respond in a reasonable time.
				</p>
			</div>
		</div>
		<div class="modal hide fade" id="site-map">
			<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3>Site Map</h3>
			</div>
			<div class="modal-body">
				<ul class="site-map">
<?php
foreach ($settings->pages as $array_key => $page) {
	$key = array_search($array_key, (array) $settings->paths);
	if (!$key) continue;
	$name = $page->name;
	$path = $key;
?>
					<li><a href="<?php echo $path ?>"><?php echo $name; ?></a></li>
<?php
}
foreach ($settings->exceptions as $key => $value) {
?>
					<li><a href="<?php echo $value ?>"><?php echo $key; ?></a></li>
<?php
}
?>
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