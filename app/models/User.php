<?php

class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {
    }

    public function isAuthenticated() {
        return isset($_SESSION['auth']) && $_SESSION['auth'] == 1;
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] == "admin";
    }

    public function isReadOnly() {
        return isset($_SESSION['role']) && $_SESSION['role'] == "readonly";
    }

    public function getUsername(){
        return $_SESSION['username'];
    }

    public function getUserByUsername($username){
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function logAttempt($username, $status){
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO log (username, attempt, attempt_time) VALUES (:username, :attempt, NOW())");
        $statement->bindValue(':username', $username);
        $statement->bindValue(':attempt', $status);
        $statement->execute();
    }

    public function authenticate($username, $password, $redirect) {
        $username = strtolower($username);
        $db = db_connect();
        $lockoutTime = 60;
        $maxAttempts = 3;

        $statement = $db->prepare("SELECT attempt, attempt_time FROM log WHERE username = :name ORDER BY attempt_time DESC LIMIT :maxAttempts");
        $statement->bindValue(':name', $username);
        $statement->bindValue(':maxAttempts', $maxAttempts, PDO::PARAM_INT);
        $statement->execute();
        $attempts = $statement->fetchAll(PDO::FETCH_ASSOC);

        $recentFailedAttempts = array_filter($attempts, function ($attempt) use ($lockoutTime) {
            return $attempt['attempt'] == 'bad' && (time() - strtotime($attempt['attempt_time']) < $lockoutTime);
        });

        if (count($recentFailedAttempts) >= $maxAttempts) {
            $_SESSION['error'] = "Your account is locked. Please try again later.";
            header('Location: /login');
            exit();
        }

        $statement = $db->prepare("SELECT * FROM users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['auth'] = 1;
            $_SESSION['username'] = ucwords($username);
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            $_SESSION['role'] = $user['role']; // Store if user is admin in session
            $this->logAttempt($username, 'good');
            header('Location: ' . $redirect);
            exit();
        } else {
            $this->logAttempt($username, 'bad');
            $_SESSION['error'] = "Invalid username or password.";
            header('Location: /login');
            exit();
        }
    }
}
?>