<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testValidPost()
    {
        $post = new Post('Title', 'Content', 'title-content');
        $this->assertSame('Title', $post->getTitle());
        $this->assertSame('Content', $post->getContent());
        $this->assertSame('title-content', $post->getSlug());
        $this->assertFalse($post->isPrivate());
    }

    public function testEmptyTitle()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Title cannot be empty');
        new Post('', 'Content', 'title-content');
    }

    public function testEmptyContent()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Content cannot be empty');
        new Post('Title', '', 'title-content');
    }

    public function testEmptySlug()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Slug must be URL safe and cannot be empty');
        new Post('Title', 'Content', '');
    }

    public function testInvalidSlug()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Slug must be URL safe and cannot be empty');
        new Post('Title', 'Content', 'invalid slug!');
    }
}
