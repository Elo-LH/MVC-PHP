<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class BlogController extends AbstractController
{
    public function home(): void
    {
        $postManager = new PostManager;
        $latestPosts = $postManager->findLatest();
        $this->render("home", $latestPosts);
    }

    public function category(string $categoryId): void
    {
        $categoryManager = new CategoryManager;
        if ($categoryManager->findOne($categoryId) !== "") {
            // si la catégorie existe
            $postManager = new PostManager;
            $posts = $postManager->findByCategory($categoryId);
            $this->render("category", $posts);
        } else {
            // sinon
            $this->redirect("index.php");
        }
    }

    public function post(string $postId): void
    {
        $postManager = new PostManager;
        $post = $postManager->findOne($postId);
        if ($post !== "") {
            // si le post exist
            $data = [$post];
            $this->render("post", $data);
        } else {
            // sinon
            $this->redirect("index.php");
        }
    }

    public function checkComment(): void
    {
        $this->redirect("index.php?route=post&post_id={$_POST["post_id"]}");
    }
}
