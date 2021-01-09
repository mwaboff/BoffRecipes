<?php

require_once("app/model/User/User.php");

class UserController extends ApplicationController {

    static function show() {
        global $RENDER_VARS;
        $user_id = Router::getRequestVar("uid", -1);
        if (UserManager::isValidUserId($user_id)) {
            if (Router::getRequestVar("action") && Router::getRequestVar("action") == "edit") {
                require("app/view/User/UserEdit.php");
            } else {
                require("app/view/User/User.php");
            }
        } else {
            require(CONFIG["404_page"]);
        }
    }

    static function update() {
        if (static::isValidUserEditRequest()) {
            static::processUpdate();
            header("Location: ?page=user&uid=" . $_REQUEST["uid"]);
        } else {
            header("Location: ?page=home");
        }
    }

    static function isValidUserEditRequest() {
        $is_valid = false;
        $uid = (isset($_REQUEST["uid"]) ? $_REQUEST["uid"] : null);
        $user = null;

        if ($uid && isPositiveInteger($uid)) {
            $user = UserManager::getUserById($uid);
            if (!empty($user)) {
                if (UserManager::isValidUserEditor($user, $_SESSION["id"])) {
                    $is_valid = true;
                }
            }
        }

        if (!isset($_REQUEST["action"]) || $_REQUEST["action"] != "edit") {
            $is_valid = false;
        }
        
        return $is_valid;
    }

    static function processUpdate() {
        $user = UserManager::getUserById($_REQUEST["uid"]);
        $user->setEmail($_POST["email"]);
        if (!empty($_POST["password"])) {
            $user->setPassword($_POST["password"]);
        }
        $user->commit();
    }

}

UserController::manageRequest();

?>