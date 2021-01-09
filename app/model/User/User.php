<?php

require_once("UserManager.php");
require_once("app/model/Recipe/RecipeManager.php");


class User {

    function __construct($username, $hash_password, $email, $id=null, $create_date=null, $last_update=null) {
        $this->user = $username;
        $this->email = $email;
        $this->pass = $hash_password;
        $this->id = $id;
        $this->create_date = $create_date;
        $this->last_update = $last_update;
    }

    static function createNewUser($username,$raw_password, $email) {
        $result_user = null;
        if (User::isValidUsername($username) && User::isValidPassword($raw_password) && User::isValidEmail($email)) {
            $hash_password = password_hash($raw_password, PASSWORD_BCRYPT);
            $result_user = new User($username, $hash_password, $email);
        }
        return $result_user;
    }

    private static function isValidUsername($username) {
        $isValid = true;
        if (empty($username)) {
            $isValid = false;
        }elseif (UserManager::getUserByUsername($username) != null) {
            $isValid = false;
        }

        return $isValid;
    }

    private static function isValidPassword($password) {
        $isValid = true;
        if (empty($password) || strlen($password) >= 60) {
            $isValid = false;
        }

        return $isValid;
    }

    private static function isValidEmail($email) {
        return (strpos($email, "@") == false) ? false : true;
    }

    function commit() {
        $sql = DBManager::readSqlFile("app/db/sql/update-user.sql");
        $parameters = [
            "username" => $this->user,
            "hashed_pass" => $this->pass,
            "email" => $this->email,
        ];

        $result = DBManager::singleQuery($sql, $parameters);
        $this->id = $result["lastInsertId"];
    }

    function authenticate($raw_password) {
        if (password_verify($raw_password, $this->pass)) {
            return $this->getAuthenticatedInformation();
        } else {
            return [];
        }
    }

    private function getAuthenticatedInformation() {
        return [
            "id" => $this->id,
            "username" => $this->user
        ];
    }

    function __toString() {
        return "<b>Username:</b> " . $this->user . " <b>Email:</b> " . $this->email . " <b>User ID:</b> " . $this->id;
    }

    function getRenderInformation() {
        return [
            "username" => $this->user,
            "email" => $this->email,
            "join_date" => $this->create_date,
        ];
    }

    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->user;
    }

    function getEmail() {
        return $this->email;
    }

    function setUsername($new_name) {
        $this->user = $new_name;
    }

    function setEmail($new_email) {
        $this->email = $new_email;
    }

    function setPassword($new_password) {
        $this->pass = password_hash($new_password, PASSWORD_BCRYPT);
    }

    function getMyRecipes() {
        return RecipeManager::getAllRecipesForAuthor($this->id);
    }
}

?>