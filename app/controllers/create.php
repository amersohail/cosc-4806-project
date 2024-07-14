<?php

class Create extends Controller {

    public function index() {		
	    $this->view('create/index');
    }

  public function register(){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $createModel = $this->model('Registration');

     $createModel->createUser($username, $password, $confirm_password);
  }
}
