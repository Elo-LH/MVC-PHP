<?php

class AuthController
{
    public function __construct()
    {
    }

    public function connexion(): void
    {
        $route = "connexion";
        require 'templates/layout.phtml';
    }
    public function checkConnexion(): void
    {
        $route = "connexion";
        require 'templates/layout.phtml';
        //find user 
        //check password match
        //redirect to espace perso if right else home ?
    }
    public function inscription(): void
    {
        $route = "inscription";
        require 'templates/layout.phtml';
    }
    public function checkInscription(): void
    {
        //find user 
        //if no email used add to users
        //redirect to home
        $route = "connexion";
        require 'templates/layout.phtml';
    }
}
