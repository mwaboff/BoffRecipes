<?php

require_once("app/model/Recipe/RecipeManager.php");

class HomeView {
    static function getLatestRecipes() {
        $latest_recipes = RecipeManager::getAllRecipesByAge();
        $recipe_render_info = [];
        foreach ($latest_recipes as $recipe) {
            array_push($recipe_render_info, $recipe->getShortRenderInformation());
        }

        return $recipe_render_info;
    }

}

$RENDER_VARS["latest_recipes"] = HomeView::getLatestRecipes();
$RENDER_VARS["css"] = ["app/view/Application/css/recipe-tiles.css"];

require("app/template/home.phtml");

?>