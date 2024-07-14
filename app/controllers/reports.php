<?php

class Reports extends Controller {

    public function __construct() {
        $user = $this->model('User');
        // Ensure user is authenticated and is an admin
        if (!$user->isAuthenticated() || !$user->isAdmin()) {
            // If not, redirect to the home page
            header('Location: /home');
            exit();
        }
    }

    public function index() {

        $report = $this->model('Report');
        $logins_list = $report->get_logins_by_users();
        $reminders_list = $report->get_reminders_by_users();
        $logins_status = $report->get_logins_status();
        $topUser = !empty($reminders_list) ? $reminders_list[0] : null;
        $reminders_all = $report->get_all_reminders();
        
        // Pass both lists to the view
        $this->view('reports/index', [
            'logins' => $logins_list,
            'reminders' => $reminders_list,
            'logins_status' => $logins_status,
            'topUser' => $topUser,
            'reminders_all' => $reminders_all
        ]);
    }
}

?>