<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
$str = file_get_contents("properties.json");
$settings = json_decode($str);
$reqPage = $settings->PageRoot . $settings->pages->pageNotFound->path;
$title = $settings->pages->pageNotFound->title;
$name = $settings->pages->pageNotFound->name;
if (isset($_GET["page"])) {
	$tmp = $_GET["page"];
	$tmp = ucfirst($tmp);
	if (isset($settings->paths->$tmp)) {
		$path = $settings->PageRoot . $settings->pages->{$settings->paths->$tmp}->path;
		if (is_readable($path)) {
			$reqPage = $path;
			$title = $settings->pages->{$settings->paths->$tmp}->title;
			$name = $settings->pages->{$settings->paths->$tmp}->name;
		} else {
			header("HTTP/1.0 404 Not Found");
		}
	} else {
		header("HTTP/1.0 404 Not Found");
	}
} else {
	$reqPage = $settings->PageRoot . $settings->pages->home->path;
	$title = $settings->pages->home->title;
	$name = $settings->pages->home->name;
}