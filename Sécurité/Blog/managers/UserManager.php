<?php

/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class UserManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findById(int $userId): ?User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $parameters = [
            'id' => $userId,
        ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        //create new User with fetched user
        if ($user == '') {
            return null;
        } else {
            $id = $user['id'];
            $user = new User($user['username'], $user['email'], $user['password'], $user['role'], DateTime::createFromFormat('Y-m-d H:i:s', $user['created_at']));
            $user->setId($id);
            return $user;
        }
    }

    public function findByEmail(string $email): ?User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $parameters = [
            'email' => $email,
        ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        //create new User with fetched user
        if ($user == '') {
            return null;
        } else {
            $id = $user['id'];
            $user = new User($user['username'], $user['email'], $user['password'], $user['role'], DateTime::createFromFormat('Y-m-d H:i:s', $user['created_at']));
            $user->setId($id);
            return $user;
        }
    }

    public function create(User $user): void
    {
        $query = $this->db->prepare('INSERT INTO users(username, email, password, role, created_at) VALUES(:username, :email, :password, :role, :created_at)');
        $parameters = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
            'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
        $query->execute($parameters);
    }
}
