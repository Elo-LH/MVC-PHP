<?php

class Router
{
    public function __construct()
    {
    }

    public function home(): void
    {
        $route = "home";
        require 'templates/layout.phtml';
    }
    public function about(): void
    {
        $route = "about";
        require 'templates/layout.phtml';
    }
    public function _404(): void
    {
        $route = "404";
        require 'templates/layout.phtml';
    }
}
