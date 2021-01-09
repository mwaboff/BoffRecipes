<?php

require_once("app/view/Application/required-login.php");

require_once("app/model/Recipe/Recipe.php");
require_once("app/model/Recipe/RecipeManager.php");

$RENDER_VARS["css"] = ["app/view/Recipe/css/recipe.css"];
$RENDER_VARS["js"] = ["app/view/Application/js/form-management.js"];

require("app/template/recipe-create.phtml");

?>