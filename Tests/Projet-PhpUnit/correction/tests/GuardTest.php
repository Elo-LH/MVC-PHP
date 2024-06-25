<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class GuardTest extends TestCase
{
    public function testGiveAccessPrivatePostAnonymousUser()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('User cannot be ANONYMOUS for private posts');
        $guard = new Guard();
        $post = new Post('Title', 'Content', 'title-content', true);
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!');
        $guard->giveAccess($post, $user);
    }

    public function testGiveAccessPrivatePostUser()
    {
        $guard = new Guard();
        $post = new Post('Title', 'Content', 'title-content', true);
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!', ['USER']);
        $updatedUser = $guard->giveAccess($post, $user);
        $this->assertContains('ADMIN', $updatedUser->getRoles());
    }

    public function testGiveAccessPublicPostAnonymousUser()
    {
        $guard = new Guard();
        $post = new Post('Title', 'Content', 'title-content');
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!');
        $updatedUser = $guard->giveAccess($post, $user);
        $this->assertContains('USER', $updatedUser->getRoles());
    }

    public function testRemoveAccessPrivatePostUser()
    {
        $guard = new Guard();
        $post = new Post('Title', 'Content', 'title-content', true);
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!', ['USER']);
        $updatedUser = $guard->removeAccess($post, $user);
        $this->assertContains('ANONYMOUS', $updatedUser->getRoles());
        $this->assertNotContains('USER', $updatedUser->getRoles());
    }

    public function testRemoveAccessPrivatePostAdmin()
    {
        $guard = new Guard();
        $post = new Post('Title', 'Content', 'title-content', true);
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!', ['ADMIN']);
        $updatedUser = $guard->removeAccess($post, $user);
        $this->assertContains('USER', $updatedUser->getRoles());
        $this->assertNotContains('ADMIN', $updatedUser->getRoles());
    }

    public function testRemoveAccessPublicPostUser()
    {
        $guard = new Guard();
        $post = new Post('Title', 'Content', 'title-content');
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!', ['USER']);
        $updatedUser = $guard->removeAccess($post, $user);
        $this->assertContains('ANONYMOUS', $updatedUser->getRoles());
        $this->assertNotContains('USER', $updatedUser->getRoles());
    }
}
