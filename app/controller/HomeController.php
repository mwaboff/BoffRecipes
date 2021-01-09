<?php

class HomeController extends ApplicationController {

    static function show() {
        global $RENDER_VARS;
        require("app/view/Home/Home.php");
    }

}

HomeController::manageRequest();

?>