<?php

class MatchController
{
    public function __construct()
    {
    }
    public function matchs(): void
    {
        //init manager
        $instance = new MatchManager;
        $matchs = $instance->findAll();
        $route = "matchs";
        require 'templates/layout.phtml';
    }
    public function match($id): void
    {
        //init manager
        $instance = new MatchManager;
        $match = $instance->findOneById($id);
        $route = "match";
        require 'templates/layout.phtml';
    }
}
