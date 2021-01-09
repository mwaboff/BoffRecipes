<?php

$image = $RENDER_VARS["image_resource"];
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);

?>