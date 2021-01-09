<?php

require_once("app/model/User/User.php");

class RegisterController extends ApplicationController {

    static function show() {
        global $RENDER_VARS;
        require("app/view/Register/Register.php");
    }

    static function create() {
        if (static::isCreateRequest()) {
            $username = Router::getRequestVar("username");
            $password = Router::getRequestVar("password");
            $email = Router::getRequestVar("email");
            $user_info = UserManager::registerNewUser($username, $password, $email);
            static::processNewUserResponse($user_info);
        } else {
        }
    }

    private static function isCreateRequest() {
        return isset($_POST["username"]) &&
            isset($_POST["email"]) && 
            isset($_POST["password"]);
    }

    private static function processNewUserResponse($user_info) {
        if (!empty($user_info)) {
            static::processCreationSuccess($user_info);
        }
    }

    private static function processCreationSuccess($user_info) {
        $_SESSION["id"] = $user_info["id"];
        $_SESSION["username"] = $user_info["username"];
        header("Location: ?page=user&uid=" . $user_info["id"]);
    }

}

RegisterController::manageRequest();

?>