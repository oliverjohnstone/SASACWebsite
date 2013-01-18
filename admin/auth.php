<?php
require_once "application.php";
class Authenticate {
	
	protected $application = null;

	public function authenticate(&$params) {
		$continue = true;
		if(isset($params["Email"])) {
			$this->application->addError("Please input your email address.");
			$continue = false;
		}
		if (isset($params["Password"])) {
			$this->application->addError("Please input your password.");
		}
		if (!$continue) return false;
		// Authenticate
	}

	public function isAuthenticated() {
		return isset($_SESSION["User"]);
	}

	public function __construct() {
		$this->application = Application::getApplication();
	}
}