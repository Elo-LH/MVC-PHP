<?php

class TeamController
{
    public function __construct()
    {
    }
    public function teams(): void
    {
        //init manager
        $instance = new TeamManager;
        $teams = $instance->findAll();
        $route = "teams";
        require 'templates/layout.phtml';
    }
    public function team($id): void
    {
        //init manager
        $instance = new TeamManager;
        $team = $instance->findOneById($id);
        $route = "team";
        require 'templates/layout.phtml';
    }
}
