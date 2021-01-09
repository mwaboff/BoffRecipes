<?php

$RENDER_VARS = [];

class ApplicationController {
    static function create() {
        require_once(CONFIG["550_page"]);
    }
    static function show() {
        require_once(CONFIG["550_page"]);
    }
    static function post() {
        require_once(CONFIG["550_page"]);
    }
    static function update() {
        require_once(CONFIG["550_page"]);
    }
    static function destroy() {
        require_once(CONFIG["550_page"]);
    }

    function manageRequest() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                static::show();
                break;
            case "POST":
                static::parsePOSTRequest();
            default:
                static::show();
                break;
        };
    }

    private static function parsePOSTRequest() {
        switch ($_REQUEST['_method']) {
            case "PUT":
                static::update();
                break;
            case "CREATE":
                static::create();
                break;
            case "DELETE":
                static::destroy();
                break;
            default:
                static::post();
                break;
        }
    }

}

?>