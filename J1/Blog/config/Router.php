<?php

class Router
{
    public function __construct()
    {
    }

    public function handleRequest(array $get): void
    {
        if (!isset($get['route'])) {
            $controller = new PageController;
            $controller->home();
        } else if ($get['route'] === "connexion") {
            $controller = new AuthController;
            $controller->connexion();
        } else if ($get['route'] === "check-connexion") {
            $controller = new AuthController;
            $controller->checkConnexion();
        } else if ($get['route'] === "inscription") {
            $controller = new AuthController;
            $controller->inscription();
        } else if ($get['route'] === "check-inscription") {
            $controller = new AuthController;
            $controller->checkInscription();
        } else if ($get['route'] === "categories") {
            $controller = new PageController;
            $controller->categories();
        } else if ($get['route'] === "category") {
            $controller = new PageController;
            $controller->category($get['category']);
        } else if ($get['route'] === "post") {
            $controller = new PageController;
            $controller->post($get['post']);
        } else {
            $controller = new PageController;
            $controller->_404();
        }
    }
}
