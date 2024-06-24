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
        $query = $this->db->prepare('SELECT * FROM categories');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];

        foreach ($result as $item) {
            $category = new Category($item["title_" . $_SESSION["lang"]], $item["description_" . $_SESSION["lang"]]);
            $category->setId($item["id"]);
            $categories[] = $category;
        }

        return $categories;
    }

    public function findOne(int $id): ?Category
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $category = new Category($result["title_" . $_SESSION["lang"]], $result["description_" . $_SESSION["lang"]]);
            $category->setId($result["id"]);

            return $category;
        }

        return null;
    }

    public function findByPost(int $postId): array
    {
        $query = $this->db->prepare('SELECT :lang FROM categories 
    JOIN posts_categories ON posts_categories.category_id=categories.id 
    WHERE posts_categories.post_id=:postId');
        $parameters = [
            "postId" => $postId,
            "lang" => "categories.title_" . $_SESSION["lang"]
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result);
        return $result;
    }
}
