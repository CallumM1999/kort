<?php

    namespace Model;

    class Auth extends \BaseModel {        
        public function loadUser($email) {
            $this->db->query('SELECT * FROM user WHERE email = :email');
            $this->db->bind('email', $email);
            
            return $this->db->single();
        }

        public function createUser($email, $password) {
            $this->db->query('INSERT INTO user (email, password) VALUES (:email, :password)');
            $this->db->bind('email', $email);
            $this->db->bind('password', $password);

            return $this->db->execute();
        }
    }