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
	$name = $settings->pages->home->name;
}