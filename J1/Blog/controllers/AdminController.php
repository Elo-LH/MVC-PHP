<?php

class AdminController
{
    public function __construct()
    {
    }
    public function deleteUser($id): void
    {
        //init manager
        $instance = new UserManager;
        $categories = $instance->findAll();
        $route = "categories";
        require 'templates/layout.phtml';
    }
    public function updateUser($id): void
    {
        //init manager
        $instance = new PostManager;
        //get all posts from selected category
        $posts = $instance->findAllFromCat($_GET['category']);
        $route = "category";
        require 'templates/layout.phtml';
    }
    public function createUser($id): void
    {
        //init manager
        $instance = new PostManager;
        //get post infos
        $post = $instance->findOne($_GET['post']);
        $route = "post";
        require 'templates/layout.phtml';
    }
}
