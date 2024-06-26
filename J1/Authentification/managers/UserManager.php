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
            new User($user['email'], $user['password']);
            array_push($loadedUsers, $user);
        };
        return $loadedUsers;
    }

    public function findOne(string $email): ?User
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
            $user = new User($user['email'], $user['password']);
            return $user;
        }
    }

    public function create(User $user): void
    {
        $query = $this->db->prepare('INSERT INTO users(email, password) VALUES(:email, :password)');
        $parameters = [

            'email' => $user->getEmail(),
            'password' => $user->getPassword(),

        ];
        $query->execute($parameters);
        $isCreated = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function update(User $user): void
    {
        $query = $this->db->prepare("UPDATE users SET email= ':email', password=':password' ");
        $parameters = [


            'email' => $user['email'],
            'password' => $user['password'],

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
    public function getPassword(User $user): string
    {
        $query = $this->db->prepare("SELECT password FROM users WHERE email = :email");
        $parameters = [
            'email' => $user['email'],
        ];
        $query->execute($parameters);
        $hash = $query->fetch(PDO::FETCH_ASSOC);
        return $hash;
    }
}
