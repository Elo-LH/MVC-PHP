<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testValidUser()
    {
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!');
        $this->assertEquals('Hugues', $user->getFirstName());
        $this->assertEquals('Froger', $user->getLastName());
        $this->assertEquals('hugues.froger@example.com', $user->getEmail());
        $this->assertEquals('LaReponseEst42!', $user->getPassword());
        $this->assertContains('ANONYMOUS', $user->getRoles());
    }

    public function testEmptyFirstName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('First name cannot be empty');
        new User('', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!');
    }

    public function testEmptyLastName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Last name cannot be empty');
        new User('Hugues', '', 'hugues.froger@example.com', 'LaReponseEst42!');
    }

    public function testInvalidEmail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email address');
        new User('Hugues', 'Froger', 'invalid-email', 'LaReponseEst42!');
    }

    public function testInvalidPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Password must be at least 8 characters long and contain at least one number, one uppercase letter, and one special character');
        new User('Hugues', 'Froger', 'hugues.froger@example.com', 'chaussette');
    }

    public function testAddRole()
    {
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!');
        $roles = $user->addRole('USER');
        $this->assertContains('USER', $roles);
        $this->assertNotContains('ANONYMOUS', $roles);
    }

    public function testRemoveRole()
    {
        $user = new User('Hugues', 'Froger', 'hugues.froger@example.com', 'LaReponseEst42!', ['USER']);
        $roles = $user->removeRole('USER');
        $this->assertContains('ANONYMOUS', $roles);
        $this->assertNotContains('USER', $roles);
    }
}
