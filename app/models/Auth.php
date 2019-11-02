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

            $response = $this->db->execute();

            if (is_bool($response)) return $response;

            if (strpos($response, 'Duplicate entry') !== false) {
                return 'email taken';
            }

            return false;
        }

        public function deleteUser($userID) {
            $this->db->query('DELETE FROM user WHERE id = :id');
            $this->db->bind('id', $userID);
            $this->db->execute();
        }
    }