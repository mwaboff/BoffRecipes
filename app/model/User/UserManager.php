<?php

require_once("app/db/DBManager.php");
require_once("User.php");

class UserManager {

    static function isValidUserId($user_id) {
        return isPositiveInteger($user_id) && !empty(static::getUserById($user_id));
    }

    static function getUserByUsername($username) {
        return UserManager::getUserByQuery("username", $username);
    }

    static function getUserById($id) {
        return UserManager::getUserByQuery("id", $id);
    }

    private static function getUserByQuery($column, $value) {
        $sql = "SELECT * FROM users WHERE $column = :value";
        $query_result = DBManager::singleQuery($sql, ["value" => $value]);
        $result_users = UserManager::createUsersFromQueryResultSet($query_result["results"]);
        return array_pop($result_users);;
    }

    static function createUsersFromQueryResultSet($result_set) {
        $users = [];
        foreach ($result_set as $result) {
            $new_user = UserManager::createUserFromQueryResult($result);
            array_push($users, $new_user);
        }
        return $users;
    }

    private static function createUserFromQueryResult($result) {
        $username = $result["username"];
        $hash_password = $result["hashed_pass"];
        $email = $result["email"];
        $id = $result["id"];
        $create_date = $result["create_date"];
        $last_updated = $result["last_updated"];

        return new User($username, $hash_password, $email, $id, $create_date, $last_updated);
    }

    static function registerNewUser($username, $password, $email) {
        $result = [];
        $new_user = User::createNewUser($username, $password, $email);
        if($new_user) {
            $new_user->commit();

            $result = [
                "id" => $new_user->getId(),
                "username" => $new_user->getUsername()
            ];
        }
        return $result;
    }

    static function isValidUserEditor($user, $current_user_id) {
        return $user->getId() == $current_user_id;
    }
}