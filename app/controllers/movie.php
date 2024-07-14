<?php
require_once 'app/core/Controller.php'; 

class MovieController extends Controller {
    private $movieModel;

    public function __construct() {
        // Load the Movie model using the parent method
        $this->movieModel = $this->model('Movie');
    }

    public function search() {
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
            $movie = $this->movieModel->getMovieDetailsByTitle($query);
            $data = ['movie' => $movie];
            $this->view('movie_details', $data);
        } else {
            $this->view('search_form');
        }
    }
}
?>