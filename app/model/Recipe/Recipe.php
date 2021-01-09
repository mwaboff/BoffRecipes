<?php

require_once("app/model/User/UserManager.php");

class Recipe {

    function __construct($recipe_name, $author_id, $description, $ingredients, $instructions, $image_id=null, $id=null, $create_date=null, $last_update=null) {
        $this->recipe_name = $recipe_name;
        $this->author_id = $author_id;
        $this->description = $description;
        $this->ingredients = $ingredients;
        $this->instructions = $instructions;
        $this->id = $id;
        $this->create_date = $create_date;
        $this->last_update = $last_update;
        $this->image_id = $image_id;
    }

    static function createNewRecipe($name, $author_id, $description, $ingredients, $instructions, $image_id=null) {
        $isValidParams = !empty($name) && !empty($description) && !empty($ingredients) && !empty($instructions);
        return ($isValidParams ? 
            new Recipe($name, $author_id, $description, $ingredients, $instructions, $image_id) : null);
    }

    function commit() {
        if(empty($this->id)) {
            $this->commitNew();
        } else {
            $this->commitUpdate();
        }
    }

    function commitNew() {
        $sql = DBManager::readSqlFile("app/db/sql/insert-recipe.sql");
        $parameters = [
            "recipe_name" => $this->recipe_name,
            "author_id" => $this->author_id,
            "description" => $this->description,
            "ingredients" => $this->ingredients,
            "instructions" => $this->instructions,
            "image_id" => $this->image_id
        ];

        $result = DBManager::singleQuery($sql, $parameters);
        $this->id = $result["lastInsertId"];
        return true;
    }
        
    function commitUpdate() {
        $sql = DBManager::readSqlFile("app/db/sql/update-recipe.sql");
        $parameters = [
            "id" => $this->id,
            "recipe_name" => $this->recipe_name,
            "author_id" => $this->author_id,
            "description" => $this->description,
            "ingredients" => $this->ingredients,
            "instructions" => $this->instructions,
            "image_id" => $this->image_id
        ];

        $result = DBManager::singleQuery($sql, $parameters);
        $this->id = $result["lastInsertId"];
        return true;
    }

    function getShortRenderInformation() {
        return [
            "id" => $this->id,
            "recipe_name" => $this->recipe_name,
            "author_id" => $this->author_id,
            "description" => $this->description,
            "image_id" => $this->image_id
        ];
    }

    function getRenderInformation() {
        $author = UserManager::getUserById($this->author_id);
        return [
            "id" => $this->id,
            "recipe_name" => $this->recipe_name,
            "author_name" => $author->getUsername(),
            "author_id" => $this->author_id,
            "description" => $this->description,
            "ingredients" => DBManager::replaceNewlinesWithBreaks($this->ingredients),
            "instructions" => DBManager::replaceNewlinesWithBreaks($this->instructions),
            "image_id" => $this->image_id
        ];
    }

    function getId() {
        return $this->id;
    }

    function getAuthorId() {
        return $this->author_id;
    }

    function getName() {
        return $this->recipe_name;
    }

    function getDescription() {
        return $this->description;
    }

    function getIngredients() {
        return $this->ingredients;
    }

    function getInstructions() {
        return $this->instructions;
    }

    function setName($new_name) {
        print("Setting name");
        $this->recipe_name = $new_name;
    }

    function setDescription($new_desc) {
        $this->description = $new_desc;
    }

    function setIngredients($new_ingredients) {
        $this->ingredients = $new_ingredients;
    }

    function setInstructions($new_instructions) {
        $this->instructions = $new_instructions;
    }

    function setImageID($new_id) {
        $this->image_id = $new_id;
    }

}

?>