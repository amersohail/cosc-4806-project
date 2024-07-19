<?php
class MovieModel {
    private $apiUrl = 'http://www.omdbapi.com/';
    private $youtubeApiUrl = 'https://www.googleapis.com/youtube/v3/search';
    private $youtubeApiKey;

    public function __construct() {
        $this->youtubeApiKey = getenv('YOUTUBE_API_KEY');
    }

    public function getMovieDetailsByTitle($title) {
        $apiKey = getenv('OMDB_API_KEY');
        $url = $this->apiUrl . '?apikey=' . $apiKey . '&t=' . urlencode($title);

        $response = file_get_contents($url);
        if ($response === FALSE) {
            return null;
        }

        $data = json_decode($response, true);
        if ($data['Response'] == 'False') {
            return null;
        }

        return $data;
    }

    public function getMovieRatings($imdbId) {
        $db = db_connect();
        $statement = $db->prepare("SELECT AVG(rating) as averageRating FROM movie_ratings WHERE imdb_id = :imdb_id");
        $statement->bindValue(':imdb_id', $imdbId, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserRating($userId, $imdbId) {
        $db = db_connect();
        $statement = $db->prepare("SELECT rating FROM movie_ratings WHERE user_id = :user_id AND imdb_id = :imdb_id");
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':imdb_id', $imdbId, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function saveRating($userId, $movieName, $imdbId, $rating) {
        $db = db_connect();

        // Check if the user has already rated this movie
        $statement = $db->prepare("SELECT * FROM movie_ratings WHERE user_id = :user_id AND imdb_id = :imdb_id");
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':imdb_id', $imdbId, PDO::PARAM_STR);
        $statement->execute();
        $existingRating = $statement->fetch(PDO::FETCH_ASSOC);

        if ($existingRating) {
            // Update the existing rating
            $statement = $db->prepare("UPDATE movie_ratings SET rating = :rating WHERE user_id = :user_id AND imdb_id = :imdb_id");
            $statement->bindValue(':rating', $rating, PDO::PARAM_STR);
            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $statement->bindValue(':imdb_id', $imdbId, PDO::PARAM_STR);
        } else {
            // Insert a new rating
            $statement = $db->prepare("INSERT INTO movie_ratings (user_id, movie_name, imdb_id, rating) VALUES (:user_id, :movie_name, :imdb_id, :rating)");
            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $statement->bindValue(':movie_name', $movieName);
            $statement->bindValue(':imdb_id', $imdbId);
            $statement->bindValue(':rating', $rating, PDO::PARAM_STR);
        }

        $statement->execute();
    }

    public function getYoutubeTrailer($title) {
        $url = $this->youtubeApiUrl . '?part=snippet&q=' . urlencode($title . ' trailer') . '&key=' . $this->youtubeApiKey;
        $response = file_get_contents($url);
        if ($response === FALSE) {
            return null;
        }

        $data = json_decode($response, true);
        if (empty($data['items'])) {
            return null;
        }

        // Get the first video ID
        $videoId = $data['items'][0]['id']['videoId'];
        return $videoId;
    }
}
?>