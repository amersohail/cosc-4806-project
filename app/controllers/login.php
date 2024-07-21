<?php

class Login extends Controller {

    public function index() {		
			$redirect = $_GET['redirect'] ?? '/home'; // Default to home if no redirect is provided
			$data = ['redirect' => $redirect];
			$this->view('login/index', $data);
    }
    
		public function verify() {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$redirect = $_POST['redirect'] ?? '/home';  // Default to home if no redirect is provided

			$user = $this->model('User');
			$user->authenticate($username, $password, $redirect);
		}
}