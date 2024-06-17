<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class CommentManager extends AbstractManager
{

    public function findByPost(int $postId): array
    {
        $query = $this->db->prepare('SELECT * FROM comments JOIN posts ON comments.post_id = posts.id WHERE post_id = :id');
        $parameters = [
            'id' => $postId,
        ];
        $query->execute($parameters);
        $fetchedComments = $query->fetchAll(PDO::FETCH_ASSOC);
        $comments = [];
        //enter fetched comments from DB into instances array
        foreach ($fetchedComments as $comment) {
            $id = $comment['comment_id'];
            $comment = new Comment($comment['comment_title'], $comment['excerpt'], $comment['content'], $comment['author'], $comment['created_at']);
            $comment->setId($id);
            array_push($comments, $comment);
        };
        return $comments;
    }

    public function create(Comment $comment): void
    {
        //create post in posts
        $query = $this->db->prepare('INSERT INTO comments(content, user_id, post_id) VALUES(:content, :user_id, :post_id)');
        $parameters = [
            'content' => $comment->getContent(),
            'user_id' => $comment->getAuthor()->getId(),
            'post_id' => $comment->getPost()->getId(),

        ];
        $query->execute($parameters);
    }
}
