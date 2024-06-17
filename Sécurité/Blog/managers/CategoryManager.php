<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class CategoryManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM categories ');
        $parameters = [];
        $query->execute($parameters);
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        $loadedCategories = [];
        //enter fetched users from DB into instances array
        foreach ($categories as $category) {
            $catClass =  new Category($category['title'], $category['description']);
            $catClass->setId($category['id']);
            array_push($loadedCategories, $category);
        };
        return $loadedCategories;
    }

    public function findOne(int $id): ?Category
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $category = $query->fetch(PDO::FETCH_ASSOC);
        //create new category with fetched category
        if ($category === '') {
            return null;
        } else {
            $category = new Category($category['title'], $category['description']);
            return $category;
        }
    }

    public function findByPost(int $post_id): ?array
    {
        $query = $this->db->prepare('SELECT * FROM posts_categories JOIN posts ON posts_categories.post_id = posts.id JOIN categories on posts_categories.category_id = categories.id WHERE posts.id = :id');
        $parameters = [
            'id' => $post_id,
        ];
        $query->execute($parameters);
        $fetchedCategories = $query->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        //enter fetched users from DB into instances array
        foreach ($fetchedCategories as $category) {
            $id = $category['id'];
            $category =  new Category($category['title'], $category['description']);
            $category->setId($id);
            array_push($categories, $category);
        };
        return $categories;
    }
}
