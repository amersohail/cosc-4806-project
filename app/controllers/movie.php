<?php
require_once 'app/core/Controller.php';

class Movie extends Controller {
    private $movieModel;
    private $userModel; // Explicitly define the userModel property
    private $googleGemini; // Explicitly define the googleGemini property

    public function __construct() {
        $this->movieModel = $this->model('MovieModel');
        $this->userModel = $this->model('User');
        $this->googleGemini = $this->model('GoogleGemini'); // Assuming you have a GoogleGemini model
    }

    public function index() {
        $this->view('home/index');
    }

    public function search() {
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
            $movie = $this->movieModel->getMovieDetailsByTitle($query);
            $trailer = $this->movieModel->getYoutubeTrailer($query);

            // Get average rating and user rating
            $averageRating = $this->movieModel->getMovieRatings($movie['imdbID']);
            $userRating = $this->userModel->isAuthenticated() ? $this->movieModel->getUserRating($_SESSION['user_id'], $movie['imdbID']) : null;

            $data = [
                'movie' => $movie,
                'isAuthenticated' => $this->userModel->isAuthenticated(),
                'ratingSubmitted' => isset($_GET['ratingSubmitted']) && $_GET['ratingSubmitted'] == 'true',
                'trailer' => $trailer,
                'averageRating' => $averageRating ? $averageRating['averageRating'] : null,
                'userRating' => $userRating ? $userRating['rating'] : null,
                'query' => $query // Add query to data
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

    public function getReview() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->userModel->isAuthenticated()) {
            $imdbId = $_POST['imdb_id'];
            $query = $_POST['query'];

            // Get the movie details
            $movie = $this->movieModel->getMovieDetailsByTitle($query);
            $trailer = $this->movieModel->getYoutubeTrailer($query); // Ensure trailer is fetched

            if ($movie) {
                // Get average rating
                $averageRating = $this->movieModel->getMovieRatings($imdbId);
                $averageRatingValue = $averageRating ? $averageRating['averageRating'] : null;

                // Generate the review using Google Gemini with conditional prompt
                $prompt = $averageRatingValue ? 
                    "Please give a review for " . $movie['Title'] . " that has an average rating of " . round($averageRatingValue, 1) . " out of 5." :
                    "Please give a review for " . $movie['Title'];

                $googleReview = $this->googleGemini->ask($prompt);

                // Prepare data for the view
                $userRating = $this->movieModel->getUserRating($_SESSION['user_id'], $imdbId);

                $data = [
                    'movie' => $movie,
                    'isAuthenticated' => $this->userModel->isAuthenticated(),
                    'ratingSubmitted' => false,
                    'averageRating' => $averageRatingValue,
                    'userRating' => $userRating ? $userRating['rating'] : null,
                    'googleReview' => $googleReview,
                    'trailer' => $trailer, // Add trailer to data
                    'query' => $query // Add query to data
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