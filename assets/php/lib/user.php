<?php
    class User {
        protected $attributes = array();
        protected $email = "";
        protected $password = "";
        protected $salt = "";
        protected $id = 0;
        protected $loaded = false;
        protected $needsPersisting = false;

        protected $auth = null;

        public function __construct($email, $auth) {
            $this->email = $email;
            $this->auth = $auth;
            $mysqli = $this->auth->connectToDatabase();
            $query = <<< SQL
SELECT u.id, u.email, u.password, s.salt 
FROM forum_users AS u LEFT JOIN forum_salts AS s 
ON u.salt = s.id 
WHERE u.email = '$email'
SQL;
            $result = $mysqli->query($query);
            if (!$result) return;
            $resultSet = $result->fetch_array();
            $result->close();
            if (!is_array($resultSet)) return;
            $this->id = $resultSet[0];
            $this->email = $resultSet[1];
            $this->password = $resultSet[2];
            $this->salt = $resultSet[3];
            $query = <<< SQL
SELECT name, attribute 
FROM forum_user_answers
WHERE user = {$this->id}
SQL;
            $result = $mysqli->query($query);
            if (!$result) return;
            while($row = $result->fetch_row()) {
                $this->attributes[$row[0]] = $row[1];
            }
            $result->close();
            $this->loaded = true;
        }

        public function isValid() {
            return $this->loaded;
        }

        public function getAttributes() {
            return $this->attributes;
        }

        public function getAttribute($name) {
            if (isset($this->attributes[$name])) {
                return $this->attributes[$name];
            } else {
                return null;
            }
        }

        public function setAttribute($name, $value) {
            $this->attributes[$name] = $value;
            $this->needsPersisting();
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password, $confirmPassword) {
            if ($password = $this->auth->resetPassword($password, $confirmPassword)) {
                $this->password = $password;
                return true;
            }
            return false;
        }

        public function getSalt() {
            return $this->salt;
        }

        public function getEmail() {
            return $this->email;
        }

        public function sendForgottenPasswordEmail() {
            $hash = $this->auth->generateForgottenPasswordHash($this->email);
            $message = <<< EMAIL
Hi,

You have just requested to reset your password, if you are not expecting this email
then you don't need to do anything, otherwise please click this link: 
http://sasac.ojs.co/forgottenPassword?hash={$hash}

Thanks,
The SASAC web team. 
EMAIL;
        }

        public function sendUserEmail($subject, $message) {
            $message = wordwrap($message, 70);
            return mail(
                $this->email,
                $subject,
                $message,
                "FROM: noreply@sasac.co.uk"
            );
        }

        public function __call($name, $args) {
            $substr = substr($name, 0, 3);
            if (!method_exists($this, $name)) {
                if ($substr === "get") {
                    $name = substr($name, 3);
                    return $this->getAttribute($name);
                } else if ($substr === "set") {
                    $name = substr($name, 3);
                    return $this->setAttribute($name, $args[0]);
                }
            }
        }
    }
?>