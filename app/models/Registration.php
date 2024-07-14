<?php

class Registration{
  public function __construct(){
     $this->db = db_connect();
  }

  public function createUser($username, $password, $confirm_password){
     $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
     $stmt->bindValue(':username', $username);
     $stmt->execute();
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     if ($result){
       echo "Username already exists. Please choose another one. <a href='/create'>Go back to Registration</a>";
       return;
     }

    if ($password !== $confirm_password){
      echo "Passwords do not match. <a href='/create'>Go back to Registration</a>";
      return;
    }

    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/", $password)){
      echo "Password must be at least 8 characters long and include at least one letter and one number. <a href='/create'>Go back to Registration</a>";
      return;
    }

     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

     $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashed_password);

    if ($stmt->execute()){
      echo "Registration successful. You can now login. <a href='/login'>Go to Login</a>";
    }
    else{
      echo "Error: " . $stmt->errorInfo()[2];
    }

  }
}
?>