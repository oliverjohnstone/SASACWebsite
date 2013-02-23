<?php
// var_dump("expression"); exit;
error_reporting(E_ALL);
require_once "./htmlTemplate.php";
echo compile($header, $tableGunf, $blurb, $footer, array("ViewInBrowser" => "#", "News" => array(
		"First News Item" => "first news item text "
	)));