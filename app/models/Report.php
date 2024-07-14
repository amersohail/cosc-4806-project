<?php

class Report {
    
    public function __construct() {
    }

    public function get_logins_by_users () {
      $db = db_connect();
      $statement = $db->prepare("SELECT username, COUNT(*) AS login_count
                                FROM log
                                WHERE attempt = 'good'
                                GROUP BY username
                                order by login_count desc");
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      return is_array($rows) ? $rows : [$rows];
    }

    public function get_logins_status () {
    $db = db_connect();
    $statement = $db->prepare("SELECT attempt, COUNT(*) AS count
                              FROM log
                              GROUP BY attempt");
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    return is_array($rows) ? $rows : [$rows];
  }
  
    public function get_reminders_by_users () {
      $db = db_connect();
      $statement = $db->prepare("SELECT users.username, COUNT(notes.id) AS note_count
                                FROM notes
                                JOIN users ON notes.user_id = users.id
                                GROUP BY users.username
                                order by note_count desc");
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
      return is_array($rows) ? $rows : [$rows];
    }

    public function get_all_reminders () {
    $db = db_connect();
    $statement = $db->prepare("SELECT users.username, notes.subject,notes.created_at,notes.completed
                              FROM notes
                              JOIN users ON notes.user_id = users.id");
    $statement->execute();
    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    return is_array($rows) ? $rows : [$rows];
  }
}

?>