<?php

require_once("app/model/Media/ImageManager.php");

$image = ImageManager::getImageById($_GET["id"]);

if (ROUTER::getRequestVar("scale", false)) {
    $scale_percent = ROUTER::getRequestVar("scale", 100);
    $RENDER_VARS["image_resource"] = $image->getScaledResource($scale_percent);
} else if (ROUTER::getRequestVar("width", false) && ROUTER::getRequestVar("height", false)) {
    $new_width = ROUTER::getRequestVar("width", 100);
    $new_height = ROUTER::getRequestVar("height", 100);
    $RENDER_VARS["image_resource"] = $image->getResizedResource($new_width, $new_height);
} else {
    $RENDER_VARS["image_resource"] = $image->getResource();
}

require("ImageRender.php");


?>