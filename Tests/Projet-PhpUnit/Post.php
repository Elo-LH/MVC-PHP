<?php

class Post
{

    public function __construct(private string $title, private string $content, private string $slug, private bool $private)
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
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
}
