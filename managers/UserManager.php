<?php

class UserManager extends AbstractManager {

    public function __construct() {
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
}