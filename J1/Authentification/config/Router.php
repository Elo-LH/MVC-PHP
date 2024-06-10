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
            $controller->checkConnection();
        } else if ($get['route'] === "inscription") {
            $controller = new AuthController;
            $controller->inscription();
        } else if ($get['route'] === "check-inscription") {
            $controller = new AuthController;
            $controller->checkInscription();
        } else if ($get['route'] === "espace-perso") {
            $controller = new PageController;
            $controller->espacePerso();
        } else {
            $controller = new PageController;
            $controller->_404();
        }
    }
}
