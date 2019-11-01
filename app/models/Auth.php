<?php

    namespace Model;

    class Auth extends \BaseModel {        
        public function loadUser($email) {
            $this->db->query('SELECT * FROM user WHERE email = :email');
            $this->db->bind('email', $email);
            
            return $this->db->single();
        }
    }