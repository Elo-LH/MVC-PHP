<?php


class PostManager extends AbstractManager
{

    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM posts ');
        $parameters = [];
        $query->execute($parameters);
        $posts = $query->fetchAll(PDO::FETCH_ASSOC);
        $loadedPosts = [];
        //enter fetched users from DB into instances array
        foreach ($posts as $post) {
            new Post($post['title'], $post['excerpt'], $post['content'], $post['author'], $post['created_at']);
            array_push($loadedPosts, $post);
        };
        return $loadedPosts;
    }

    public function findOne(int $id): ?Post
    {
        $query = $this->db->prepare('SELECT * FROM posts WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $post = $query->fetch(PDO::FETCH_ASSOC);
        //create new post with fetched post
        if ($post === '') {
            return null;
        } else {
            $post = new Post($post['title'], $post['excerpt'], $post['content'], $post['author'], $post['created_at']);
            return $post;
        }
    }

    public function create(Post $post): void
    {
        //create post in posts
        $query = $this->db->prepare('INSERT INTO posts(title, excerpt, content, author, created_at) VALUES(:title, :excerpt, :content, :author, :created_at)');
        $parameters = [
            'title' => $post['title'],
            'excerpt' => $post['excerpt'],
            'content' => $post['content'],
            'author' => $post['author'],
            'created_at' => $post['createdAt'],
        ];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);

        //create each post id link to categories in posts_categories
        foreach ($post['categories'] as $category_id) {
            $query = $this->db->prepare('INSERT INTO posts_categories(post_id, category_id) VALUES(:post_id, :category_id)');
            $parameters = [
                'post_id' => $post['id'],
                'category_id' => $category_id
            ];
            $query->execute($parameters);
            $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function update(Post $post): void
    {
        //update post in posts
        $query = $this->db->prepare("UPDATE posts SET title = ':title' , excerpt = ':excerpt', content = ':content', author =  ':author', created_at = ':created_at' WHERE id = :id ");
        $parameters = [
            'id' => $post['id'],
            'title' => $post['title'],
            'excerpt' => $post['excerpt'],
            'content' => $post['content'],
            'author' => $post['author'],
            'created_at' => $post['createdAt'],
        ];
        $query->execute($parameters);
        $isModified = $query->fetch(PDO::FETCH_ASSOC);

        //update links to each category related
        //delete all preexistent links 
        $query = $this->db->prepare("DELETE FROM posts_categories WHERE post_id = :post_id ");
        $parameters = [
            'post_id' => $post['id'],
        ];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);
        //add links from updated posts 
        foreach ($post['categories'] as $category_id) {
            $query = $this->db->prepare("INSERT INTO posts_categories(post_id, category_id) VALUES(:post_id, :category_id)");
            $parameters = [
                'post_id' => $post['id'],
                'category_id' => $category_id
            ];
            $query->execute($parameters);
            $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function delete(int $id): void
    {
        //delete all links from post in posts_categories
        $query = $this->db->prepare("DELETE FROM posts_categories WHERE post_id = :post_id ");
        $parameters = [
            'post_id' => $id,
        ];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);

        //delete post from posts
        $query = $this->db->prepare('DELETE FROM posts WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);
    }
}


Créer:
