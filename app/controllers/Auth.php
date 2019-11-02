<?php

    namespace Controller;

    use \View as View;

    class Auth extends \Controller {

        public function __construct() {
            $this->authModel = $this->model('Auth');
            $this->routeModel = $this->redis('Route');
        }

        public function getLogin() {
            $data = [
                "email" => "",
                "password" => "",
                "stay_logged" => false,
                "errors" => [],
                "title" => "Login"
            ];

            View::render('login', $data);
        }

        public function postLogin() {
            $stay_logged = isset($_POST['stay_logged']);

            $data = [
                "email" => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                "password" => filter_var($_POST['password'], FILTER_SANITIZE_STRING),
                "stay_logged" => $stay_logged,
                "errors" => [],
                "title" => "Login"
            ];

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Enter a valid email.';
            }

            if ($data['password'] === '') {
                $data['errors']['password'] = 'Enter a valid password.';
            }

            // Check if valid data was sent
            if (sizeof($data['errors']) > 0) View::render('login', $data);

            $user = $this->authModel->loadUser($_POST['email']);

            // Check if user was found
            if (!isset($user->id)) {
                $data['errors']['main'] = 'Invalid email or password.';
                View::render('login', $data);
            }

            // Check password
            if (!password_verify($data['password'], $user->password)) {
                $data['errors']['main'] = 'Invalid email or password.';
                View::render('login', $data);
            }

            // Init session
            $_SESSION['id'] = $user->id;
            header('Location: ' . URLROOT . '/routes');
        }

        public function getRegister() {
            $data = [
                "email" => "",
                "confirm_email" => "",
                "password" => "",
                "confirm_password" => "",
                "errors" => [],
                "title" => "Register"
            ];

            View::render('register', $data);
        }

        public function postRegister() {
            $data = [
                "email" => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                "confirm_email" => filter_var($_POST['confirm_email'], FILTER_SANITIZE_EMAIL),
                "password" => filter_var($_POST['password'], FILTER_SANITIZE_STRING),
                "confirm_password" => filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING),
                "errors" => [],
                "title" => "Register"
            ];

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['errors']['email'] = 'Enter a valid email.';
            } else if ($data['email'] !== $data['confirm_email']) {
                $data['errors']['confirm_email'] = 'Email field must match.';
            }

            if (!(strlen($data['password']) >= 8 && strlen($data['password']) <= 100)) {
                $data['errors']['password'] = 'Password must be between 8-100 characters.';
            } else if ($data['password'] !== $data['confirm_password']) {
                $data['errors']['confirm_password'] = 'Password field must match.';
            }

            // Check if valid data was sent
            if (sizeof($data['errors']) > 0) View::render('register', $data);

            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            $response = $this->authModel->createUser($data['email'], $data['password']);

            if ($response !== true) {
                if ($response === 'email taken') {
                    $data['errors']['main'] = 'Email already taken';
                } else {
                    $data['errors']['main'] = 'Something went wrong.';
                }
                View::render('register', $data);
            }

            // Success
            header('Location: ' . URLROOT . '/login');
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

        public function account() {
            $data = [
                "title" => "Account Settings"
            ];

            View::render('account', $data);
        }

        public function deleteAccount() {
            $userID = $_SESSION['id'];

            $this->routeModel->deleteUser($userID);
            $this->authModel->deleteUser($userID);

            header('Location: ' . URLROOT . '/logout');
        }

    }