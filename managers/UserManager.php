<?php

class UserManager extends AbstractManager {

    public function __construct() 
    {
        // J'appelle le constructeur de l'AbstractManager pour qu'il initialise la connexion à la DB
        parent::__construct();
    }
    
    public function createUser(User $user) : User 
    {
        $query = $this->db->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
        $parameters = [
            
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "role" => $user->getRole()
        ];

        $query->execute($parameters);

        $user->setId($this->db->lastInsertId());

        return $user;
    }
    
    public function findUserByEmail(string $email): ?User 
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $parameters = [
            "email" => $email
            ];
            
        $query->execute($parameters);

        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data===false) {
            $users = new User($data['email'], $data['password'], $data['role']);
            $users->setId($data['id']);
            return $users;
        
        }
        else 
        {
        return null;
        }
    }
    
    public function findAllUsers() : array
    {
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        $userlist = [];
        foreach ($users as $user) 
        {
            $item = new User($user["email"], $user["password"], $user["role"]);
            $item->setId($user["id"]);
            $userlist[] = $item;
        }

        return $userlist;
    }
}