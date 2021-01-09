<?php

require_once("app/db/DBManager.php");
require_once("Recipe.php");

class RecipeManager {

    static function isValidRecipeId($recipe_id) {
        return isPositiveInteger($recipe_id) && 
            !empty(static::getRecipeById($recipe_id));
    }

    static function getRecipeById($id) {
        $result = null;
        $sql = "SELECT * FROM recipes WHERE id = :id";
        $query_result = DBManager::singleQuery($sql, ["id" => $id]);
        $result_array = $query_result["results"];
        if(!empty($result_array)) {
            $result = static::createSingleRecipeFromQuery($result_array[0]);
        }
        return  $result;
    }

    static function createSingleRecipeFromQuery($result) {
        $id = $result["id"];
        $image_id = $result["image_id"];
        $recipe_name = $result["recipe_name"];
        $author_id = $result["author_id"];
        $description = $result["description"];
        $ingredients = $result["ingredients"];
        $instructions = $result["instructions"];

        return new Recipe($recipe_name, $author_id, $description, 
            $ingredients, $instructions, $image_id, $id);
    }

    static function registerNewRecipe($name, $description, $ingredients, $instructions, $image_id) {
        $result = [];
        $author_id = $_SESSION["id"];
        $new_recipe = Recipe::createNewRecipe($name, $author_id, $description, $ingredients, $instructions, $image_id);
        if($new_recipe) {
            $new_recipe->commit();
            $result = [
                "id" => $new_recipe->getId(),
            ];
        }
        return $result;
    }

    static function getAllRecipesByAge() {
        $sql = "SELECT * FROM recipes ORDER BY create_date desc";
        $query_result = DBManager::singleQuery($sql);
        return static::createMultipleRecipesFromQuery($query_result["results"]); 
    }

    static function getAllRecipesForAuthor($author_id) {
        $sql = "SELECT * FROM recipes WHERE author_id = :author_id";
        $query_result = DBManager::singleQuery($sql, ["author_id"=>$author_id]);
        return static::createMultipleRecipesFromQuery($query_result["results"]);
    }

    static function createMultipleRecipesFromQuery($result_set) {
        $recipes = [];
        foreach ($result_set as $result) {
            $new_recipe = static::createSingleRecipeFromQuery($result);
            array_push($recipes, $new_recipe);
        }
        return $recipes;
    }

    static function isValidRecipeEditor($recipe, $current_user_id) {
        return $recipe->getAuthorId() == $current_user_id;
    }

    static function deleteRecipe($recipe) {
        $recipe_id = $recipe->getId();
        $sql = "DELETE FROM recipes WHERE id = :id";
        $query_result = DBManager::singleQuery($sql, ["id" => $recipe_id]);
        return true;
    }
    

}