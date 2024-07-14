<?php

class Reminders extends Controller {
    public function __construct() {
        $user = $this->model('User');
        
        // Ensure user is authenticated
        if (!$user->isAuthenticated()) {
            // If not, redirect to the home page
            header('Location: /home');
            exit();
        }
    }

    public function index() {		
      $reminder = $this->model('Reminder');
      $user_id = $_SESSION['user_id'];
      $reminders_list = $reminder->get_all_reminders($user_id);
      $this->view('reminders/index',['reminders' => $reminders_list]);
    }

  public function create() {
      $this->view('reminders/create');
  }

    public function edit() {
        $reminder = $this->model('Reminder');
        $user_id = $_SESSION['user_id'];
        $reminders_list = $reminder->get_all_reminders($user_id);
        // Pass the reminders to the view
        $this->view('reminders/update', ['reminders' => $reminders_list]);
        
    }
    
  public function store() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $user_id = $_SESSION['user_id'];
          $subject = $_POST['subject'];

          // Debugging: Log the values
          error_log("User ID: " . $user_id);
          error_log("Subject: " . $subject);
          
          $reminder = $this->model('Reminder');
          $reminder->create_reminder($user_id, $subject);

          header('Location: /reminders');
      } else {
          $this->create();
      }
  }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $subject = $_POST['subject'];
            $completed = isset($_POST['completed']) ? 1 : 0;

            $reminder = $this->model('Reminder');
            $reminder->update_reminder($id, $subject, $completed);

            header('Location: /reminders');
            exit();
        } 
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            $reminder = $this->model('Reminder');
            $reminder->delete_reminder($id);

            header('Location: /reminders');
            exit();
        }
    }
}

?>