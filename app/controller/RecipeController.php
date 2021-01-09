<?php

require_once("app/model/Recipe/Recipe.php");
require_once("app/model/Recipe/RecipeManager.php");
require_once("app/model/Media/Image.php");
require_once("app/model/Media/ImageManager.php");

class RecipeController extends ApplicationController {

    static function show() {
        global $RENDER_VARS;
        if (static::isValidRecipeIdRequest()) {
            if (isset($_GET["action"]) && $_GET["action"] == "edit") {
                require("app/view/Recipe/RecipeEdit.php");
            } elseif (isset($_GET["action"]) && $_GET["action"] == "delete") {
                static::destroy();
            } else {
                require("app/view/Recipe/Recipe.php");
            }
            
        } elseif (isset($_GET["action"]) && $_GET["action"] == "create") {
            require("app/view/Recipe/RecipeCreate.php");
        }  else {
            require(CONFIG["404_page"]);
        }
    }

    static function isValidRecipeIdRequest() {
        return isset($_REQUEST["id"]) && RecipeManager::isValidRecipeId($_REQUEST["id"]);
    }

    static function destroy() {
        $recipe = RecipeManager::getRecipeById($_REQUEST["id"]);
        if (RecipeManager::isValidRecipeEditor($recipe, $_SESSION["id"])) {
            RecipeManager::deleteRecipe($recipe);
            header("Location: ?page=home");
        } else {
            print("You are not a valid editor for this page.");
        }
        
    }

    static function create() {
        if (static::isCreateRequest()) {
            $name = $_POST["recipe-name"];
            $desc = $_POST["recipe-description"];
            $ingredients = $_POST["recipe-ingredients"];
            $instructions = $_POST["recipe-instructions"];
            $image_id = null;

            if (isset($_FILES["recipe-picture"]) && $_FILES["recipe-picture"]["error"] = 0) {
                $image_id = ImageManager::registerNewImage($_FILES["recipe-picture"]);
            }

            $recipe_info = RecipeManager::registerNewRecipe($name, $desc, $ingredients, $instructions, $image_id);
            static::processNewRecipeResponse($recipe_info);
        }
    }

    static function isCreateRequest() {
        return isset($_POST["recipe-name"]) && 
            isset($_POST["recipe-description"]) &&
            isset($_POST["recipe-ingredients"]) &&
            isset($_POST["recipe-instructions"]); 
    }



    static function processNewRecipeResponse($recipe_info) {
        if (!empty($recipe_info)) {
            header("Location: ?page=recipe&id=" . $recipe_info["id"]);
        }
    }
    
    static function update() {
        if (static::isValidRecipeIdRequest() && isset($_REQUEST["action"]) && $_REQUEST["action"] == "edit") {
            if (static::isCreateRequest()) {
                static::processUpdate();
                header("Location: ?page=recipe&id=" . $_REQUEST["id"]);
            }
        }
    }

    static function processUpdate() {
        print_r($_FILES);
        if (!static::isValidRecipeIdRequest()) {
            header("Location: ?page=home");
        }
        $recipe = RecipeManager::getRecipeById($_REQUEST["id"]);
        if (RecipeManager::isValidRecipeEditor($recipe, $_SESSION["id"])) {
            $recipe->setName($_POST["recipe-name"]);
            $recipe->setDescription($_POST["recipe-description"]);
            $recipe->setIngredients($_POST["recipe-ingredients"]);
            $recipe->setInstructions($_POST["recipe-instructions"]);
            if (isset($_FILES["recipe-picture"]) && $_FILES["recipe-picture"]["error"] = 0) {
                print_r($_FILES);
                $image_id = ImageManager::registerNewImage($_FILES["recipe-picture"]);
                $recipe->setImageId($image_id);
            }

            $recipe->commit();
        } else {
            print("You are not a valid editor for this page.");
        }
    }

}

RecipeController::manageRequest();

?>