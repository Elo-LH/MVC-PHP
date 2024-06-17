<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

session_start();

require "config/autoload.php";

//initialize session CSRFToken 
if (!isset($_SESSION["csrf_token"])) {
    $tokenManager = new CSRFTokenManager();
    $token = $tokenManager->generateCSRFToken();
    $_SESSION["csrf_token"] = $token;
}


$router = new Router();

$router->handleRequest($_GET);
