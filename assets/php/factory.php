<?php
	require_once("lib/auth.php");
	class Factory {
		protected static $db_details = array(
			"host" => "database.lcn.com",
			"user" => "LCN274555_sasac",
			"password" => "phaf43re+ReN",
			"database" => "ojs_co_sasac"
		);

		public static function getAuth() {
			return new Auth(self::$db_details);
		}

		public static function getUser($email) {
			require_once("lib/user.php");
			return new User($email, self::getAuth());
		}

		public static function getContentGenerator($user) {
			require_once("lib/contentGenerator.php");
			return new ContentGenerator($user, self::getAuth());
		}
	}
?>