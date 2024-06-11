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
        //init manager
        $instance = new PostManager;
        //get all posts from selected category
        $posts = $instance->findAllFromCat($_GET['category']);
        $route = "category";
        require 'templates/layout.phtml';
    }
    public function post($id): void
    {
        //init manager
        $instance = new PostManager;
        //get post infos
        $post = $instance->findOne($_GET['post']);
        $route = "post";
        require 'templates/layout.phtml';
    }
    public function users(): void
    {
        //init manager
        $instance = new UserManager;
        //if userToModify
        $users = $instance->findAll();
        $route = "users";
        require 'templates/layout.phtml';
    }
    public function _404(): void
    {
        $route = "404";
        require 'templates/layout.phtml';
    }
}
