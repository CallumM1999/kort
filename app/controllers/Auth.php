<?php

    namespace Controller;

    use \View as View;

    class Auth extends \Controller {

        public function __construct() {
            $this->authModel = $this->model('Auth');
        }

        public function getLogin() {
            $data = [
                "email" => "",
                "password" => "",
                "stay_logged" => false,
                "errors" => []
            ];

            View::render('login', $data);
        }

        public function postLogin() {
            $stay_logged = isset($_POST['stay_logged']);

            $data = [
                "email" => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                "password" => filter_var($_POST['password'], FILTER_SANITIZE_STRING),
                "stay_logged" => $stay_logged,
                "errors" => []
            ];

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors'][] = 'Enter a valid email.';
            }

            if ($data['password'] === '') {
                $data['errors'][] = 'Enter a valid password.';
            }

            // Check if valid data was sent
            if (sizeof($data['errors']) > 0) View::render('login', $data);

            $user = $this->authModel->loadUser($_POST['email']);

            // Check if user was found
            if (!isset($user->id)) {
                $data['errors'][] = 'Invalid email or password combination.';
                View::render('login', $data);
            }

            // Check password
            if ($data['password'] !== $user->password) {
                $data['errors'][] = 'Invalid email or password combination.';
                View::render('login', $data);
            }

            // Init session
            $_SESSION['id'] = '1';
            header('Location: ' . URLROOT . '/dashboard');
        }

        public function getRegister() {
            View::render('register');
        }

        public function postRegister() {
            
        }

        public function login() {
            

            

        }

        public function register() {


            // echo 'register page';
        }

        public function logout() {
            // delete session cookie
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time()-3600, '/' );
            }
            // delete all session variables
            $_SESSION = [];
            // kill session
            session_destroy();
            header('Location: /kort/');
        }

    }