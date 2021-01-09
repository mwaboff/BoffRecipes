<?php

require_once("app/db/DBManager.php");
require_once("app/model/Media/Image.php");

class ImageManager {

    static function isValidImageId($image_id) {
        return isPositiveInteger($image_id) && !empty(static::getImageById($image_id));
    }

    static function getImageById($id) {
        $result = null;
        $sql = "SELECT * FROM images WHERE id = :id";
        $query_result = DBManager::singleQuery($sql, ["id" => $id]);
        $result_array = $query_result["results"];
        if(!empty($result_array)) {
            $result = static::createSingleImageFromQuery($result_array[0]);
        }
        return  $result;
    }

    static function createSingleImageFromQuery($result) {
        $image_string = $result["image_data"];
        $id = $result["id"];
        return Image::createFromString($image_string, $id);
    }

    static function registerNewImage($uploaded_file_info) {
        $result = null;
        $new_image = Image::createFromUpload($uploaded_file_info);
        if ($new_image) {
            $new_image->commit();
            $result = $new_image->getId();
            print($new_image);
        }
        return $result;
    }

}