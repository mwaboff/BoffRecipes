<?php

require_once("app/model/Recipe/Recipe.php");
require_once("app/model/Recipe/RecipeManager.php");

$RENDER_VARS["css"] = ["app/view/Recipe/css/recipe.css"];

$recipe = RecipeManager::getRecipeById($_GET["id"]);

$RENDER_VARS = array_merge($RENDER_VARS, $recipe->getRenderInformation());
$RENDER_VARS["id"] = $recipe->getId();

if (isset($_SESSION["id"])) {
    $RENDER_VARS["editor_status"] = RecipeManager::isValidRecipeEditor($recipe, $_SESSION["id"]);
} else {
    $RENDER_VARS["editor_status"] = false;
}

require("app/template/recipe.phtml");
?>