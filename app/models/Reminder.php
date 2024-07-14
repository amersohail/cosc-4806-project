<?php

class Reminder {

    public function __construct() {
    }

    public function get_all_reminders ($user_id) {
      $db = db_connect();
      $statement = $db->prepare("SELECT * FROM notes WHERE user_id = :user_id AND deleted IS NULL OR                     deleted = '' OR deleted = 0;");
      $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      return is_array($rows) ? $rows : [$rows];
    }

    public function get_reminder_by_id($id) {
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM notes WHERE id = :id AND deleted = 0");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create_reminder($user_id, $subject) {
          $db = db_connect();
          $query = $db->prepare("INSERT INTO notes (user_id, subject) VALUES (?, ?)");
          return $query->execute([$user_id, $subject]);
    }
    
    public function update_reminder($id, $subject, $completed) {
        $db = db_connect();
        $statement = $db->prepare("UPDATE notes SET subject = :subject, completed = :completed WHERE id = :id");
        $statement->bindParam(':subject', $subject, PDO::PARAM_STR);
        $statement->bindParam(':completed', $completed, PDO::PARAM_INT);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
    
    //not deleting the row, just setting the delete column value to true.
    public function delete_reminder($id) {
        $db = db_connect();
        $statement = $db->prepare("UPDATE notes SET deleted = 1 WHERE id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}

?>