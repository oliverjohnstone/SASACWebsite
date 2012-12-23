<?php
    class Auth {
        protected static $MYSQL_HOST;
        protected static $MYSQL_USER;
        protected static $MYSQL_PWRD;
        protected static $MYSQL_DBAS;
        protected static $mysqli = null;

        protected $HASH_TIMES = 1000;
        protected $PASSWORDS_NO_MATCH_ERROR = "The passwords you entered did not match, please try again.";
        protected $INVALID_EMAIL_ERROR = "The email you entered was not valid, please try again.";
        protected $FAILED_TO_SAVE_USER = "Failed to persist user to database.";
        protected $USER_ALREADY_EXISTS = "The email used already exists.";

        public function __construct($db_details) {
            self::$MYSQL_HOST = $db_details["host"];
            self::$MYSQL_USER = $db_details["user"];
            self::$MYSQL_PWRD = $db_details["password"];
            self::$MYSQL_DBAS = $db_details["database"];
            session_start();
        }

        public static function connectToDatabase() {
            if (self::$mysqli === null) {
                self::$mysqli = new mysqli(self::$MYSQL_HOST, self::$MYSQL_USER, self::$MYSQL_PWRD, self::$MYSQL_DBAS);
                if (self::$mysqli) return self::$mysqli;
                return false;
            }
            return self::$mysqli;
        }

        public function generateForgottenPasswordHash($email) {
            $hash = md5(microtime());
            $query = "UPDATE forum_users SET email_reset = '$hash' WHERE email = '$email'";
            $result = $this->mysqli->query($query);
            if (!$result) return false;
            return $hash;
        }

        public function getSessionVariable($variableName) {
            if (isset($_SESSION[$variableName])) return $_SESSION[$variableName];
            return false;
        }

        public function setSessionVariable($name, $value) {
            $_SESSION[$name] = $value;
        }

        public function auth($email = null, $password = null, $remember = false) {
            if ($this->getSessionVariable("user")) return $this->getSessionVariable("user");
            if ($email === null) return false;
            if (isset($_COOKIE["sasac_forum_auth"])) {
                $guid = $_COOKIE["sasac_forum_auth"];
                $query = "SELECT email FROM forum_users WHERE session_id = '$guid'";
                $mysqli = $this->connectToDatabase();
                $result = $mysqli->query($query);
                if ($result) {
                    $resultSet = $result->fetch_array();
                    if (is_array($resultSet)) {
                        $email = array_shift($resultSet);
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
                $remember = true;
            } else {
                if (!$this->_userExists($email, $password)) return false;
            }
            $this->setSessionVariable("user", $email);
            if ($remember) {
                $guid = $this->_getGUID();
                $query = "UPDATE forum_users SET session_id = '$guid'";
                $mysqli = $this->connectToDatabase();
                $mysqli->query($query);
                $oneMonth = time()+60*60*24*30;
                setcookie("sasac_forum_auth", $guid, $oneMonth, '/');
            }
            return $email;
        }

        protected function _userExists($email, $password = null) {
            $mysqli = $this->connectToDatabase();
            if (!$mysqli) return false;
            $email = $mysqli->real_escape_string($email);
            $query = "SELECT s.salt FROM forum_salts AS s LEFT JOIN forum_users AS u ON s.id = u.salt WHERE u.email = '$email' AND deleted IS NULL LIMIT 1";
            $result = $mysqli->query($query);
            if (!$result) return false;
            $resultSet = $result->fetch_array();
            if (!is_array($resultSet)) return false;
            $salt = array_shift($resultSet);
            $result->close();
            if (!$salt) return false;
            $expectedPassword = $this->_generateHash($password, $salt);
            $query = "SELECT password FROM forum_users WHERE email = '$email'";
            if ($password !== null) $query .= " AND password = '$expectedPassword'";
            $query .= " LIMIT 1";
            $result = $mysqli->query($query);
            if (!$result) return false;
            $resultSet = $result->fetch_array();
            $result->close();
            if (!is_array($resultSet)) return false;
            $actualPassword = array_shift($resultSet);
            if (!$actualPassword) return false;
            if ($actualPassword !== $expectedPassword) return false;
            return true;
        }

        protected function _generateHash($password, $salt) {
            $hash = hash("sha512", $password.$salt);
            for($i = 0; $i < $this->HASH_TIMES; $i++) {
                $hash = hash("sha512", $hash.$password.$salt);
            }
            return $hash;
        }

        public function newUser($email, $password, $confirmPassword) {
            if ($password !== $confirmPassword) return $this->PASSWORDS_NO_MATCH_ERROR;
            if (!$this->validEmail($email)) return $this->INVALID_EMAIL_ERROR;
            if ($this->_userExists($email)) return $this->USER_ALREADY_EXISTS;
            $mysqli = $this->connectToDatabase();
            $email = strtolower($email);
            $email = $mysqli->real_escape_string($email);
            $salt = $this->_generateSalt(100);
            $passwordHash = $this->_generateHash($password, $salt);
            $salt = $mysqli->real_escape_string($salt);
            $query = "INSERT INTO forum_salts (salt) VALUES('$salt')";
            $result = $mysqli->query($query);
            if ($mysqli->affected_rows < 1) return $this->FAILED_TO_SAVE_USER;
            $saltId = $mysqli->insert_id;
            $query = "INSERT INTO forum_users (email, salt, password) VALUES('$email', '$saltId', '$passwordHash')";
            $result = $mysqli->query($query);
            if (!$result) return $this->FAILED_TO_SAVE_USER;
            return true;
        }

        protected function _getGUID(){
            mt_srand((double)microtime()*10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
            return $uuid;
        }

        public function logout() {
            if (isset($_COOKIE["sasac_forum_auth"])) {
                setcookie("sasac_forum_auth");
            }
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
            return true;
        }

        protected function _generateSalt($length) {
            $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#][}{*-!£$^()_=+`%.'~:;><,";
            $alphaLength = strlen($alphabet);
            $salt = "";
            if ($length < $alphaLength) {
                $salt = substr(str_shuffle($alphabet), 0, $length);
            } else {
                $times = $length % $alphaLength === 0 ? $length / $alphaLength : ($length / $alphaLength) + 1;
                for ($i = 0; $i < $times; $i++) {
                    $salt .= str_shuffle($alphabet);
                }
                $salt = substr($salt, 0, $length);
            }
            return $salt;
        }

        protected function validEmail($email){
            $isValid = true;
            $atIndex = strrpos($email, "@");
            if (is_bool($atIndex) && !$atIndex){
              $isValid = false;
            }
            else{
                $domain = substr($email, $atIndex+1);
                $local = substr($email, 0, $atIndex);
                $localLen = strlen($local);
                $domainLen = strlen($domain);
                if ($localLen < 1 || $localLen > 64){
                    // local part length exceeded
                    $isValid = false;
                }
                else if ($domainLen < 1 || $domainLen > 255){
                    // domain part length exceeded
                    $isValid = false;
                }
                else if ($local[0] == '.' || $local[$localLen-1] == '.'){
                    // local part starts or ends with '.'
                    $isValid = false;
                }
                else if (preg_match('/\\.\\./', $local)){
                    // local part has two consecutive dots
                    $isValid = false;
                }
                else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
                    // character not valid in domain part
                    $isValid = false;
                }
                else if (preg_match('/\\.\\./', $domain)){
                    // domain part has two consecutive dots
                    $isValid = false;
                }
                else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                         str_replace("\\\\","",$local))) {
                    // character not valid in local part unless 
                    // local part is quoted
                    if (!preg_match('/^"(\\\\"|[^"])+"$/',
                        str_replace("\\\\","",$local)))
                    {
                        $isValid = false;
                    }
                }
                if ($isValid && !(checkdnsrr($domain,"MX") || 
                    checkdnsrr($domain,"A"))){
                    // domain not found in DNS
                    $isValid = false;
                }
            }
            return $isValid;
        }
    }

?>