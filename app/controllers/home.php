<?php

class Home extends Controller {

  public function __construct() {
      $user = $this->model('User');

      // Ensure user is authenticated
      if (!$user->isAuthenticated()) {
        
      }
  }

    public function index() {
      $user = $this->model('User');
      $this->view('home/index');
	    die;
    }
}
?>