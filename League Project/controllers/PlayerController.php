<?php

class PlayerController
{
    public function __construct()
    {
    }
    public function players(): void
    {
        //init manager
        $instance = new PlayerManager;
        $players = $instance->findAll();
        $route = "players";
        require 'templates/layout.phtml';
    }
    public function player($id): void
    {
        //init manager
        $instance = new PlayerManager;
        $player = $instance->findOneById($id);
        $route = "player";
        require 'templates/layout.phtml';
    }
}
