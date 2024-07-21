<?php

class Create extends Controller {

    public function index() {
        // Load the User model
        $user = $this->model('User');

        // Check if the user is authenticated
        if ($user->isAuthenticated()) {
            // Redirect to the home page if the user is already logged in
            header('Location: /home');
            exit();
        }

        // If the user is not logged in, show the registration page
        $this->view('create/index');
    }

    public function register() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $createModel = $this->model('Registration');
        $createModel->createUser($username, $password, $confirm_password);
    }
}