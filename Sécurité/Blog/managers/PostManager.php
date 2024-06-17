<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class PostManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findLatest(): ?array
    {
        $query = $this->db->prepare('SELECT * FROM posts ORDER BY created_at DESC LIMIT 4');
        $parameters = [];
        $query->execute($parameters);
        $posts = $query->fetchAll(PDO::FETCH_ASSOC);
        //create new match with fetched match
        if ($posts === '') {
            return null;
        } else {
            $loadedPosts = [];
            //enter fetched users from DB into instances array
            foreach ($posts as $post) {
                $id = $post['post_id'];
                $post = new Post($post['post_title'], $post['excerpt'], $post['content'], $post['author'], $post['created_at']);
                $post->setId($id);
                array_push($loadedPosts, $post);
            };
            return $loadedPosts;
        }
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

    public function findByCategory(int $categoryId): array
    {
        $query = $this->db->prepare('SELECT *, posts.title as post_title, posts.id as ost_id FROM posts_categories JOIN posts ON posts_categories.post_id = posts.id JOIN categories ON posts_categories.category_id = categories.id WHERE category_id = :id');
        $parameters = [
            'id' => $categoryId,
        ];
        $query->execute($parameters);
        $posts = $query->fetchAll(PDO::FETCH_ASSOC);
        $loadedPosts = [];
        //enter fetched users from DB into instances array
        foreach ($posts as $post) {
            $id = $post['post_id'];
            $post = new Post($post['post_title'], $post['excerpt'], $post['content'], $post['author'], $post['created_at']);
            $post->setId($id);
            array_push($loadedPosts, $post);
        };
        return $loadedPosts;
    }
}
