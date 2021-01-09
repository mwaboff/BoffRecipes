<?php

if (!isset($_SESSION["id"])) {
    header("Location: ?page=login");
}

?>