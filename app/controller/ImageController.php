<?php

require_once("app/model/Media/Image.php");
require_once("app/model/Media/ImageManager.php");

class ImageController extends ApplicationController {

    static function show() {
        global $RENDER_VARS;
        if(!isset($_GET["id"]) || !ImageManager::isValidImageId($_GET["id"])) {
            require(CONFIG["404_page"]);
        } else {
            require("app/view/Media/Image.php");
        }
    }

    static function clearSession() {
        session_destroy();
        header("Location: index.php?page=home");
    }

}

ImageController::manageRequest();

?>