<?php
class Application {

	public function hasErrors(){
		return count($_SESSION["errors"]) > 0;
	}

	public function addError($error) {
		$_SESSION["errors"][] = $error;
	}

	public function getErrors() {
		$errors = $_SESSION["errors"];
		$_SESSION["errors"] = array();
		return $errors;
	}

	public function getConnectionString() {
		return "";
	}

	protected function __construct() {
		session_start();
		if (!isset($_SESSION["errors"])) {
			$_SESSION["errors"] = array();
		}
	}

	public static function getApplication() {
		static $application = null;
		if ($application === null) {
			$application = new Application();
		}
		return $application;
	}
}