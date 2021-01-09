<?php

require_once("app/db/DBManager.php");
require_once("app/model/Media/ImageManager.php");

class Image {

    function __construct($image_resource, $id=null) {
        // $this->ALLOWED_PICTURE_TYPES = ["image/png", "image/jpg", "image/jpeg"];
        // $this->ALLOWED_MAX_PICTURE_WIDTH = 10000; // px
        // $this->ALLOWED_MAX_PICTURE_HEIGHT = 10000; // px
        // $this->ALLOWED_MAX_PICTURE_SIZE = 2000000; // MB

        $this->id = $id;
        $this->resource = $image_resource;
        $this->width = imagesx($this->resource);
        $this->height = imagesy($this->resource);
    }

    static function createFromString($data_string, $id=null) {
        $resource = imagecreatefromstring($data_string);
        return new Image($resource, $id);
    }

    static function createFromUpload($file_info) {
        $result = null;

        if (isset($file_info["tmp_name"])) {
            $tmp_name = $file_info["tmp_name"];
            $image_stream_string = file_get_contents($tmp_name);
            $result = static::createFromString($image_stream_string);
        }

        return $result;
    }

    function getResource() {
        return $this->resource;
    }

    function getResizedResource($new_width, $new_height) {
        return imagescale($this->resource, $new_width, $new_height);
    }

    function getScaledResource($percentage) {
        $new_width = $this->width * (intval($percentage)/100);
        return imagescale($this->resource, $new_width);
    }

    function commit() {
        $sql = DBManager::readSqlFile("app/db/sql/insert-image.sql");
        
        $parameters = [
            "image_data" => $this->getImageBinaryString(),
        ];

        $result = DBManager::singleQuery($sql, $parameters);
        $this->id = $result["lastInsertId"];

        return true;
    }

    function getImageBinaryString() {
        ob_start();
        imagepng($this->resource);
        $string_data = ob_get_contents();
        ob_end_clean();
        return $string_data;
    }

    function getId() {
        return $this->id;
    }

    function __toString() {
        return "Image Class: id=$this->id; width=$this->width; height=$this->height";
    }









    // private function getComponent($component) {
    //     return isset($this->file[$component]) ? $this->file[$component] : null;
    // }

    // private function isLikelyValid() {
    //     return $this->isValidType() && $this->error == 0;
    // }

    // private function isValidType() {
    //     print ("type=" . $this->type . "<br>");
    //     print_r($this->ALLOWED_PICTURE_TYPES);
    //     return in_array($this->type, $this->ALLOWED_PICTURE_TYPES);
    // }

    // function isValid() {
    //     $validity_result = $this->testValidity();
    //     return $validity_result->isSuccess();
    // }

    // function testValidity() {
    //     $result = new ApplicationResult();

    //     if (!$this->isValidType()) {
    //         $result->setFailure();
    //         $result->setErrorType("Unsupported File Type");
    //         $result->setErrorMessage("Supported image types include jpg, jpeg, and png");
    //     } else if (!$this->isValidWidth() || !$this->isValidHeight()) {
    //         $result->setFailure();
    //         $result->setErrorType("Invalid Dimensions");
    //         $result->setErrorMessage("Maximum width x height is " . 
    //             $this->ALLOWED_MAX_PICTURE_WIDTH . "x" . $this->ALLOWED_MAX_PICTURE_HEIGHT);
    //     } else if (!$this->isValidSize()) {
    //         $result->setFailure();
    //         $result->setErroWidth/HeightrType("Invalid Size");
    //         $result->setErrorMessage("Maximum file size is" . ($this->ALLOWED_MAX_PICTURE_SIZE / 1000000) . "MB");
    //     } else if ($this->error != 0) {
    //         $result->setFailure();
    //         $result->setErrorType("Unspecified Error");
    //         $result->setErrorMessage("Error code $this->error. Please try with another image");
    //     }

    //     return $result;
    // }


    // private function isValidWidth() {
    //     return $this->width > 0 && $this->width <= $this->ALLOWED_MAX_PICTURE_WIDTH;
    // }

    // private function isValidHeight() {
    //     return $this->height > 0 && $this->height <= $this->ALLOWED_MAX_PICTURE_HEIGHT;
    // }

    // private function isValidSize() {
    //     return $this->size > 0 && $this->size <= $this->ALLOWED_MAX_PICTURE_SIZE;
    // }

    
    // function getPicture() {
    //     $image_content = addslashes(file_get_contents($this->tmp_name));
    //     return $this->isValid() ? $image_content : null;
    // }

}



?>