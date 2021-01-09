<?php

function insertCSSFilesFromArray($css_array) {
    foreach ($css_array as $css_file) {
        $line = "<link rel=\"stylesheet\" href=\"$css_file\">";
        print($line);
    }
}

function insertJSFilesFromArray($js_array) {
    foreach ($js_array as $css_file) {
        $line = "<script type=\"module\" src=\"$css_file\"></script>";
        print($line);
    }
}

function isPositiveInteger($int_string) {
    return ((int)$int_string && $int_string > 0) ? true : false;
}

?>