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
        //init manager
        $instance = new CategoryManager;
        $categories = $instance->findAll();
        $route = "categories";
        require 'templates/layout.phtml';
    }
    public function category($id): void
    {
        //get all category selected posts
        //init manager
        $instance = new PostManager;
        $posts = $instance->findAllFromCat($_GET['category']);
        $route = "category";
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
