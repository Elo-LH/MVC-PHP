<?php

declare(strict_types=1);

class User
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private array $roles;

    public function __construct(string $firstName, string $lastName, string $email, string $password, array $roles = ['ANONYMOUS'])
    {
        $this->ensureIsValidFirstName($firstName);
        $this->ensureIsValidLastName($lastName);
        $this->ensureIsValidEmail($email);
        $this->ensureIsValidPassword($password);
  
        $this->roles = array_unique($roles);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->ensureIsValidFirstName($firstName);
        
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->ensureIsValidLastName($lastName);
        
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->ensureIsValidEmail($email);
        
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->ensureIsValidPassword($password);
        
        $this->password = $password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = array_unique($roles);
    }

    public function addRole(string $newRole): array
    {
        $this->ensureIsAvailableRole($newRole);
        
        if ($newRole != 'ANONYMOUS') {
            $this->roles = array_diff($this->roles, ['ANONYMOUS']);
        }
        $this->roles[] = $newRole;
        $this->roles = array_unique($this->roles);
        return $this->roles;
    }

    public function removeRole(string $role): array
    {
        $this->ensureIsFindableRole($role);
        $this->roles = array_diff($this->roles, [$role]);
        
        if (empty($this->roles)) {
            $this->roles[] = 'ANONYMOUS';
        }
        
        return $this->roles;
    }
    
    private function ensureIsValidFirstName(string $firstName): void  
    {
        if (empty($firstName)) {
            throw new \InvalidArgumentException('First name cannot be empty');
        }
    }
    
    private function ensureIsValidLastName(string $lastName): void  
    {
        if (empty($lastName)) {
            throw new \InvalidArgumentException('Last name cannot be empty');
        }
    }
    
    private function ensureIsValidEmail(string $email): void  
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address');
        }
    }
    
    private function ensureIsValidPassword(string $password): void  
    {
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/', $password)) {
            throw new \InvalidArgumentException('Password must be at least 8 characters long and contain at least one number, one uppercase letter, and one special character');
        }
    }
    
    private function ensureIsAvailableRole(string $newRoles): void  
    {
        if (!in_array($newRoles, ['ANONYMOUS', 'USER', 'ADMIN'])) {
            throw new \InvalidArgumentException('Invalid role');
        }
    }
    
    private function ensureIsFindableRole(string $role): void  
    {
        if (!in_array($role, $this->roles)) {
            throw new \InvalidArgumentException('Role not found');
        }
    }
}
