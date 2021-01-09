<?php

class RecipeView {
    static function getRecipeDescriptions($recipe_list) {
        $recipe_render_info = [];
        foreach ($recipe_list as $recipe) {
            array_push($recipe_render_info, $recipe->getShortRenderInformation());
        }

        return $recipe_render_info;
    }

}

$user = UserManager::getUserById(Router::getRequestVar("uid"));
$RENDER_VARS = array_merge($RENDER_VARS, $user->getRenderInformation());

if (isset($_SESSION["id"])) {
    $RENDER_VARS["editor_status"] = UserManager::isValidUserEditor($user, $_SESSION["id"]);
    $RENDER_VARS["uid"] = $user->getId();
} else {
    $RENDER_VARS["editor_status"] = false;
}



$recipe_list = $user->getMyRecipes();
$RENDER_VARS["my_recipes"] = RecipeView::getRecipeDescriptions($recipe_list);

$RENDER_VARS["css"] = ["app/view/User/css/user.css", "app/view/Application/css/recipe-tiles.css"];
require("app/template/user.phtml");

?>