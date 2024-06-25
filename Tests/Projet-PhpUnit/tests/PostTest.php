<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testCanNotbeEmptyTitle(): void
    {
        $string = 'user@example.com';

        $email = Post::fromString($string);

        $this->assertSame($string, $email->asString());
    }

    public function testCannotBeCreatedFromInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }
}
