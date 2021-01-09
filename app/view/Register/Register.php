<?php

$RENDER_VARS["css"] = ["app/view/Register/css/register.css", "app/view/Login/css/login.css"];
$RENDER_VARS["js"] = ["app/view/Application/js/form-management.js", "app/view/Register/js/register.js"];

// If the username is in the request, we know this was after a failed login attempt.
if(isset($_REQUEST["username"])) {
    $RENDER_VARS["old_username"] = Router::getRequestVar('username');
    $RENDER_VARS["old_password" ]= Router::getRequestVar('password');
    $RENDER_VARS["old_email"] = Router::getRequestVar('email');
    $RENDER_VARS["err_msg"] = "Failed Registration: Username is already taken.";

}

require("app/template/register.phtml");
?>