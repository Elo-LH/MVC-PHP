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
        } else if ($get['route'] === "home") {
            $controller = new PageController;
            $controller->home();
        } else if ($get['route'] === "players") {
            $controller = new PlayerController;
            $controller->players();
        } else if ($get['route'] === "player") {
            $controller = new PlayerController;
            $controller->player($get['player']);
        } else if ($get['route'] === "teams") {
            $controller = new TeamController;
            $controller->teams();
        } else if ($get['route'] === "team") {
            $controller = new TeamController;
            $controller->team($get['team']);
        } else if ($get['route'] === "matchs") {
            $controller = new MatchController;
            $controller->matchs();
        } else if ($get['route'] === "match") {
            $controller = new MatchController;
            $controller->match($get['match']);
        } else {
            $controller = new PageController;
            $controller->_404();
        }
    }
}
