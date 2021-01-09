<?php

$RENDER_VARS["js"] = ["app/view/Application/js/form-management.js"];

$user = UserManager::getUserById($_GET["uid"]);

if (UserManager::isValidUserEditor($user, $_SESSION["id"])) {
    $RENDER_VARS["name"] = $user->getUsername();
    $RENDER_VARS["old-email"] = $user->getEmail();
    $RENDER_VARS["uid"] = $user->getId();
    require("app/template/user-edit.phtml");
} else {
    print("You do not have permission to edit this user");
}

?>