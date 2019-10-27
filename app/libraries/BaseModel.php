<?php

    abstract class BaseModel {
        
        public function __construct() {
            $this->db = new Database();
        }
    }
