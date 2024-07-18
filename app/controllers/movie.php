<?php
require_once 'app/core/Controller.php';

class Movie extends Controller {
    private $movieModel;
    private $userModel;

    public function __construct() {
        $this->movieModel = $this->model('MovieModel');
        $this->userModel = $this->model('User');
    }

    public function index() {
        $this->view('home/index');
    }

    public function search() {
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
            $movie = $this->movieModel->getMovieDetailsByTitle($query);
            $data = [
                'movie' => $movie,
                'isAuthenticated' => $this->userModel->isAuthenticated(),
                'ratingSubmitted' => isset($_GET['ratingSubmitted']) && $_GET['ratingSubmitted'] == 'true'
            ];
            $this->view('movie/index', $data);
        } else {
            $this->view('home/index');
        }
    }

    public function rate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->userModel->isAuthenticated()) {
            $userId = $_SESSION['user_id'];
            $movieName = $_POST['movie_name'];
            $imdbId = $_POST['imdb_id'];
            $rating = $_POST['rating'];

            $this->movieModel->saveRating($userId, $movieName, $imdbId, $rating);

            $query = urlencode($_POST['query']);
            header("Location: /movie/search?query=$query&ratingSubmitted=true");
            exit();
        } else {
            header('Location: /login');
            exit();
        }
    }
}
?>