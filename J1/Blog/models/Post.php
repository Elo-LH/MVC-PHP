<?php

class Post
{
    private int $id = 0;
    private array $categories = [];

    public function __construct(private string $post_title,  private string $excerpt, private string $content, private int $author, private string $createdAt)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->post_title;
    }
    public function setTitle(string $post_title): void
    {
        $this->post_title = $post_title;
    }

    public function getExcerpt(): string
    {
        return $this->excerpt;
    }
    public function setExcerpt(string $excerpt): void
    {
        $this->excerpt = $excerpt;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    public function getAuthor(): string
    {
        return $this->author;
    }
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category): void
    {
        array_push($categories, $category);
    }
    public function removeCategory(Category $category): void
    {
        $indexToRemove = array_search($category, $this->categories);
        unset($categories[$indexToRemove]);
    }
}
