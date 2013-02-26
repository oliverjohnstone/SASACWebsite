<?php
require_once "database.php";
function getAnnouncementItems($section, $limit = 10) {
	dbConnect();
	$sql = "SELECT * FROM Announcements WHERE Section = \"$section\" ORDER BY DateCreated LIMIT $limit";
	$result = mysql_query($sql) or die(mysql_error());
	$items = array();
	while($row = mysql_fetch_array($result)) {
		$items[$row["Id"]] = array("Title" => $row["Title"], "Content" => $row["Content"]);
	}
	return $items;
}