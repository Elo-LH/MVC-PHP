<?php

abstract class AbstractManager
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=localhost;port=3306;dbname=eloisele_hellard_blog_poo",
            "root",
            ""
        );
    }
}
