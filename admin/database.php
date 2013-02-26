<?php

function dbConnect() {
	mysql_connect("database.lcn.com", "LCN274555_sasac", "blackjack") or
		die(mysql_error());
	mysql_select_db("ojs_co_sasac") or
		die(mysql_error());
}