<?php
require_once "bootstrap.php";
require_once "assets/php/lib/mobileDetect.php";
$mobileDetect = new MobileDetect();
// Most tablets can handle the full page site but not mobiles
if ($mobileDetect->isMobile() && !$mobileDetect->isTablet()) {
	// Send the mobile version of the site
	require_once "mobile.php";
	// header("HTTP/1.1 301 Moved Permanently");
	// header("Location: http://m.sasac.co.uk");
	exit;
}
?>
<!doctype html>
<html>
	<head>
		<title><?php echo $name; ?> | St Albans Sub Aqua Club</title>
		<meta name="keywords" content="<?php echo implode(",", $settings->keywords); ?>" />
		<meta name="description" content="<?php echo $settings->description; ?>" />
		<meta name="author" content="Oliver Johnstone">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
		<!--[if !IE 6]>-->
			<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="assets/css/application.css">
			<script type="text/javascript" src="assets/js/jquery/jquery-1.9.0.min.js"></script>
			<script type="text/javascript" src="assets/js/plugins/bootstrap.min.js"></script>
			<script type="text/javascript" src="assets/js/jquery/jquery-ui-1.8.21.custom.min.js"></script>
			<script type="text/javascript" src="assets/js/main.js"></script>
			<script type="text/javascript" src="assets/js/plugins/jquery-form.js"></script>
		<!--<[endif]-->
		<!--[if lte IE 8]>
			<link rel="stylesheet" type="text/css" href="assets/css/ie8.css">
		<![endif]-->
		<!--[if lte IE 7]>
			<link rel="stylesheet" type="text/css" href="assets/css/ie7.css">
		<![endif]-->
		<!--[if lte IE 6]>
			<link rel="stylesheet" type="text/css" href="assets/css/ie6.css">
		<![endif]-->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-20496817-1']);
			_gaq.push(['_trackPageview']);

			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</head>
	<body>
		<div class="fb-link"><a href="http://www.facebook.com/StAlbansSubAquaClub" target="_blank"></a></div>
		<div class="social">
		<div id="fb-root"></div>
		<div id="fb-root"></div>
		<script type="text/javascript">(function(d, s, id) {
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
			<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<div class="menu">
				<ul>
<?php
foreach ($settings->pages as $array_key => $page) {
	if (!$page->verticalMenuItem) continue;
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
<?php
foreach ($settings->pages as $array_key => $page) {
	if ($page->verticalMenuItem) continue;
	$key = array_search($array_key, (array) $settings->paths);
	if (!$key) continue;
	$name = $page->name;
	$path = $key;
	$class = "menuitem";
	if ($settings->PageRoot . $page->path === $reqPage) {
		$class .= " selected";
	}
?>
					<li><a href="<?php echo $path; ?>"><?php echo $name; ?></a></li>
<?php
}
?>
					</ul>
				</div>
				<div class="edge"></div>
				<div class="header">
					<div class="page-title"><h1><?php echo $title; ?></h1></div>
					<div class="logo"></div>
				</div>
				<div class="content-body">
					<div class="page-content">
						<?php include $reqPage; ?>
					</div>
				</div>
				<!--[if IE]>
				<div class="ie-long-bottom"></div>
				<![endif]-->
			</div>
			<!--[if IE]>
			<div class="ie-short-bottom ie7-bottom"></div>
			<![endif]-->
			<div class="footer">&copy; Copyright <?php echo date("Y"); ?> St Albans Sub Aqua Club<br>
				We use cookies on this site - <a href="http://en.wikipedia.org/wiki/HTTP_cookie" target="_blank">What is a cookie?</a></div>
		</div>
	</div><!-- IE Container -->
	</body>
	<script type="text/javascript">
		if ($(window).width() >= 1070) {
			$('.fb-link').show()
		}
		$(window).resize(function(){
			if ($(window).width() < 1070) {
				$('.fb-link').hide()
			} else {
				$('.fb-link').show()
			}
		})
	</script>
</html>