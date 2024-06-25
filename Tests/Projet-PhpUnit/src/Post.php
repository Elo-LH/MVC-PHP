<?php

class Post
{

    public function __construct(private string $title, private string $content, private string $slug, private bool $private = false)
    {
        $this->ensureIsValidTitle($title);
        $this->ensureIsValidSlug($slug);
        $this->ensureIsValidContent($content);
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getPrivate(): string
    {
        return $this->private;
    }
    public function setPrivate(string $private): void
    {
        $this->private = $private;
    }

    private function ensureIsValidTitle(string $title): void
    {
        if (empty($title)) {
            throw new \InvalidArgumentException('Title cannot be empty');
        }
    }

    private function ensureIsValidSlug(string $slug): void
    {
        if (empty($slug) || !preg_match('/^[a-zA-Z0-9-]+$/', $slug)) {
            throw new \InvalidArgumentException('Slug must be URL safe and cannot be empty');
        }
    }

    private function ensureIsValidContent(string $content): void
    {
        if (empty($content)) {
            throw new \InvalidArgumentException('Content cannot be empty');
        }
    }
}
