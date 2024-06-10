<?php

class PageController
{
    public function __construct()
    {
    }
    public function home(): void
    {
        $route = "home";
        require 'templates/layout.phtml';
    }
    public function categories(): void
    {
        $route = "categories";
        require 'templates/layout.phtml';
    }
    public function category($id): void
    {
        //get all category selected posts
        $route = "categories";
        require 'templates/layout.phtml';
    }
    public function post($id): void
    {
        $route = "post";
        require 'templates/layout.phtml';
    }
    public function _404(): void
    {
        $route = "404";
        require 'templates/layout.phtml';
    }
}
