<?php
require_once 'app/core/Controller.php';

class Movie extends Controller {
    private $movieModel;
    private $userModel;
    private $googleGemini;

    // Constructor to initialize models
    public function __construct() {
        $this->movieModel = $this->model('MovieModel');
        $this->userModel = $this->model('User');
        $this->googleGemini = $this->model('GoogleGemini');
    }

    // Default index method
    public function index() {
        $this->view('home/index');
    }

    // Method to search for a movie and display its details
    public function search() {
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
            $movie = $this->movieModel->getMovieDetailsByTitle($query);
            $averageRating = null;
            $userRating = null;
            $googleReview = null;

            if ($movie) {
                $imdbId = $movie['imdbID'];
                $averageRating = $this->movieModel->getMovieRatings($imdbId);
                if ($this->userModel->isAuthenticated()) {
                    $userId = $_SESSION['user_id'];
                    $userRating = $this->movieModel->getUserRating($userId, $imdbId);
                }
            }

            // Prepare data for the view
            $data = [
                'movie' => $movie,
                'isAuthenticated' => $this->userModel->isAuthenticated(),
                'ratingSubmitted' => isset($_GET['ratingSubmitted']) && $_GET['ratingSubmitted'] == 'true',
                'averageRating' => $averageRating['averageRating'],
                'userRating' => $userRating ? $userRating['rating'] : null,
                'googleReview' => $googleReview
            ];
            $this->view('movie/index', $data);
        } else {
            $this->view('home/index');
        }
    }

    // Method to handle rating submission
    public function rate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->userModel->isAuthenticated()) {
            $userId = $_SESSION['user_id'];
            $movieName = $_POST['movie_name'];
            $imdbId = $_POST['imdb_id'];
            $rating = $_POST['rating'];

            $this->movieModel->saveRating($userId, $movieName, $imdbId, $rating);

            // Redirect back to the movie search page with the submitted rating
            $query = urlencode($_POST['query']);
            header("Location: /movie/search?query=$query&ratingSubmitted=true");
            exit();
        } else {
            header('Location: /login');
            exit();
        }
    }

    public function getReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->userModel->isAuthenticated()) {
            $imdbId = $_POST['imdb_id'];
            $query = $_POST['query'];

            // Get the movie details
            $movie = $this->movieModel->getMovieDetailsByTitle($query);
            if ($movie) {
                // Generate the review using Google Gemini
                $prompt = "Write a review for the movie " . $movie['Title'];
                $googleReview = $this->googleGemini->ask($prompt);

                // Prepare data for the view
                $averageRating = $this->movieModel->getMovieRatings($imdbId);
                $userRating = $this->movieModel->getUserRating($_SESSION['user_id'], $imdbId);

                $data = [
                    'movie' => $movie,
                    'isAuthenticated' => $this->userModel->isAuthenticated(),
                    'ratingSubmitted' => false,
                    'averageRating' => $averageRating['averageRating'],
                    'userRating' => $userRating ? $userRating['rating'] : null,
                    'googleReview' => $googleReview
                ];

                // Render the view with the updated data
                $this->view('movie/index', $data);
                return;
            }
        }

        // Redirect to home if the request method is not POST or user is not authenticated
        header('Location: /home');
        exit();
    }
}
?>