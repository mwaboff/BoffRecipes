<?php

require_once("app/model/User/User.php");

class LoginController extends ApplicationController {

    static function show() {
        require("app/view/Login/Login.php");
    }

    static function post() {
        global $RENDER_VARS;
        $RENDER_VARS = static::attemptLogin();
        if(isset($RENDER_VARS["id"])) {
            static::processLoginSuccess($RENDER_VARS);
        } else {
            static::processLoginFailure();
        }
    }
    
    static function attemptLogin() {
        $render_vars = [];
        if (isset($_POST['username']) && isset($_POST['password'])) {
            if ($user_acct = UserManager::getUserByUsername(Router::getRequestVar('username'))) {
                $render_vars = $user_acct->authenticate(Router::getRequestVar('password'));
            }
        }
        return $render_vars;
    }

    static function processLoginSuccess($RENDER_VARS) {
        $_SESSION["id"] = $RENDER_VARS["id"];
        $_SESSION["username"] = $RENDER_VARS["username"];
        header("Location: ?page=home");
    }

    static function processLoginFailure() {
        $RENDER_VARS["err_msg"] = "failure";
    }

}

LoginController::manageRequest();

?>