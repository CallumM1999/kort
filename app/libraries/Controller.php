<?php

    abstract class Controller {
        
        // Load model
        protected function model($model) {
            require_once APPROOT . '/models/' . $model . '.php';

            // Instantiate Model
            $class = 'Model\\' . $model;
            return new $class();
        }

        protected function redis($model) {
            require_once APPROOT . '/models/' . $model . '.php';

            // Instantiate Model
            $class = 'Model\\' . $model;
            return new $class();
        }
    }