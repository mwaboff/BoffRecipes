<?php

class Router {
    static function route() {
        if (Router::isCSRFValid()) {
            $page = Router::getRequestVar("page", "home");
            Router::loadController($page);
        } else {
            require(CONFIG["550_page"]);
        }
    }

    private static function isCSRFValid() {
        $success = true;
        if ($_SERVER["REQUEST_METHOD"] != "GET") {
            if (!isset($_REQUEST["csrf_token"]) || !hash_equals($_REQUEST["csrf_token"], $_SESSION["csrf_token"])) {
                $success = false;
            }
        }
        return $success;
    }

    static function getRequestVar($key, $default='') {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }

    private static function loadController($page_name) {
        $controller_name = ucfirst($page_name) . "Controller.php";
        $controller_path = "app/controller/$controller_name";
        if(file_exists($controller_path)) {
            require($controller_path);
        } else {
            require(CONFIG["404_page"]);
        }
    }

}

Router::route();

?>