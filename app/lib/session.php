<?php
session_start();

if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(openssl_random_pseudo_bytes(32));
}


?>