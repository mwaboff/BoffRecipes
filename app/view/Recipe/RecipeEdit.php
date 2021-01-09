<?php

require_once("app/view/Application/required-login.php");
require_once("app/model/Recipe/Recipe.php");
require_once("app/model/Recipe/RecipeManager.php");

$RENDER_VARS["css"] = ["app/view/Recipe/css/recipe.css", "app/view/Recipe/css/recipe-edit.css"];
$RENDER_VARS["js"] = ["app/view/Recipe/js/recipe-edit.js", "app/view/Application/js/form-management.js"];


$recipe = RecipeManager::getRecipeById($_GET["id"]);

if (RecipeManager::isValidRecipeEditor($recipe, $_SESSION["id"])) {
    $RENDER_VARS["old-recipe-name"] = $recipe->getName();
    $RENDER_VARS["old-recipe-description"] = $recipe->getDescription();
    $RENDER_VARS["old-recipe-ingredients"] = $recipe->getIngredients();
    $RENDER_VARS["old-recipe-instructions"] = $recipe->getInstructions();
    $RENDER_VARS["id"] = $recipe->getId();
    
    require("app/template/recipe-edit.phtml");

} else {
    print("You do not have permission to edit this recipe");
}

?>