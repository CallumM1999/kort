<?php

    namespace Model;

    class Base extends \BaseModel {
        public function getUsers() {
            $this->db->query('select * from user');

            $results = $this->db->resultSet();
    
            return $results;
        }   
    }