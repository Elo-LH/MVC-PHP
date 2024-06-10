<?php



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
            new Category($category['title'], $category['description']);
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

    public function create(Category $category): void
    {
        //create category in DB
        $query = $this->db->prepare('INSERT INTO categories(title, description) VALUES(:title, :description)');
        $parameters = [
            'title' => $category['title'],
            'description' => $category['description']
        ];
        $query->execute($parameters);
        $isCreated = $query->fetch(PDO::FETCH_ASSOC);

        //create each category id link to posts in posts_categories
        foreach ($category['posts'] as $post_id) {
            $query = $this->db->prepare('INSERT INTO posts_categories(post_id, category_id) VALUES(:post_id, :category_id)');
            $parameters = [
                'post_id' => $post_id,
                'category_id' => $category['id']
            ];
            $query->execute($parameters);
            $isLinToPostCreated = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function update(Category $category): void
    {

        //update categories
        $query = $this->db->prepare("UPDATE categories SET title = ':title' , description = ':description' WHERE id = :id");
        $parameters = [
            'id' => $category['id'],
            'title' => $category['title'],
            'description' => $category['description']

        ];
        $query->execute($parameters);
        $isModified = $query->fetch(PDO::FETCH_ASSOC);


        //update links to each post related
        //delete all links presexistent
        $query = $this->db->prepare("DELETE FROM posts_categories WHERE category_id = :category_id ");
        $parameters = [
            'category_id' => $category['id'],
        ];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);
        //add links from updated posts 
        foreach ($category['posts'] as $post_id) {
            $query = $this->db->prepare("INSERT INTO posts_categories(post_id, category_id) VALUES(:post_id, :category_id)");
            $parameters = [
                'post_id' => $post_id,
                'category_id' => $category['id']
            ];
            $query->execute($parameters);
            $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function delete(int $id): void
    {
        //delete category from categories
        $query = $this->db->prepare('DELETE FROM categories WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);

        //delete all links to posts in posts_categories
        $query = $this->db->prepare("DELETE FROM posts_categories WHERE category_id = :category_id ");
        $parameters = [
            'category_id' => $id,
        ];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);
    }
}
