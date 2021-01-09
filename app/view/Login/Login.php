<?php

$RENDER_VARS["css"] = ["app/view/Login/css/login.css"];
$RENDER_VARS["js"] = ["app/view/Application/js/form-management.js", "app/view/Login/js/login.js"];


// If the username is in the request, we know this was after a failed login attempt.
if(isset($_REQUEST["username"])) {
    $RENDER_VARS["old_username"] = Router::getRequestVar('username');
    $RENDER_VARS["old_password"]= Router::getRequestVar('password');
    $RENDER_VARS["err_msg"] = "Failed Login: Either your username or password is incorrect!";

}

require("app/template/login.phtml");
?>