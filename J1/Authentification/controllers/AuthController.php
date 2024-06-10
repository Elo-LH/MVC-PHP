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
        echo $_POST;
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User($email, $password);
        $instance = new UserManager;

        $route = "home";
        require 'templates/layout.phtml';
        //find user 
        //check password match
        $isPasswordCorrect = password_verify($passwordTest, $hashTest);

        if ($isPasswordCorrect) {
            echo "Mot de passe correct";
        } else {
            echo "Mot de passe erroné";
        }
        //redirect to espace perso if right else home ?
        //create session !


    }
    public function inscription(): void
    {
        $route = "inscription";
        require 'templates/layout.phtml';
    }
    public function checkInscription(): void
    {
        //get form data
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        //init manager
        $user = new User($email, $hash);
        $instance = new UserManager;
        //find user 
        $userFound = $instance->findOne($email);
        //if email allready used give error
        if ($userFound) {
            $route = "error";
            $error = "Email déjà utilisé, veuillez vous connecter ou choisir un autre email.";
            require 'templates/layout.phtml';
            //if email not found create new user
        } else {
            $instance->create($user);
            $_SESSION['email'] = $email;
            //redirect to home
            $route = "home";
            require 'templates/layout.phtml';
        }
    }
    public function error(): void
    {
        $route = "error";
        require 'templates/layout.phtml';
    }
}
