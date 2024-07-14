<?php

class Logout extends Controller {

    public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Clear all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header('Location: /home');
        exit();
    }
}
?>