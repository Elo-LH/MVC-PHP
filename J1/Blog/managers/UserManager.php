<?php


class UserManager extends AbstractManager
{

    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM users ');
        $parameters = [];
        $query->execute($parameters);
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        $loadedUsers = [];
        //enter fetched users from DB into instances array
        foreach ($users as $user) {
            new User($user['username'], $user['email'], $user['password'], $user['role'], $user['created_at']);
            array_push($loadedUsers, $user);
        };

        return $loadedUsers;
    }

    public function findOne(int $id): ?User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        //create new User with fetched user
        if ($user === '') {
            return null;
        } else {

            $user = new User($user['username'], $user['email'], $user['password'], $user['role'], $user['created_at']);

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
            'created_at' => $user->getCreatedAt(),
        ];
        $query->execute($parameters);
        $isCreated = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function update(User $user): void
    {
        $query = $this->db->prepare("UPDATE users SET username= ':username', email= ':email', password=':password', role = ':role', created_at = ':created_at' WHERE id = :id ");
        $parameters = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'password' => $user['password'],
            'role' => $user['role'],
            'created_at' => $user['createdAt'],
        ];
        $query->execute($parameters);
        $isModified = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): void
    {
        $query = $this->db->prepare('SET FOREIGN_KEY_CHECKS=0;');
        $parameters = [];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);

        $query = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);

        $query = $this->db->prepare('SET FOREIGN_KEY_CHECKS=1;');
        $parameters = [];
        $query->execute($parameters);
        $query->fetch(PDO::FETCH_ASSOC);
    }
}
