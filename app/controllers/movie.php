<?php
require_once 'app/core/Controller.php';

class Movie extends Controller {
    private $movieModel;

    public function __construct() {
        $this->movieModel = $this->model('MovieModel');
        $this->userModel = $this->model('User'); 
    }

    // This index method can redirect to home or show an error message
    public function index() {
        $this->view('home/index');
    }

    public function search() {
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
            $movie = $this->movieModel->getMovieDetailsByTitle($query);
            $data = [
                'movie' => $movie,
                'isAuthenticated' => $this->userModel->isAuthenticated()
            ];
            $this->view('movie/index', $data);
        } else {
            $this->view('home/index');
        }
    }
}
?>