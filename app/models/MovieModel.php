<?php
class MovieModel {
    private $apiUrl = 'http://www.omdbapi.com/';

    public function getMovieDetailsByTitle($title) {
        $apiKey = getenv('OMDB_API_KEY');
        //echo "API Key: $apiKey<br>"; // Debugging line
        $url = $this->apiUrl . '?apikey=' . $apiKey . '&t=' . urlencode($title);
        //echo "Request URL: $url<br>"; // Debugging line

        $response = file_get_contents($url);
        if ($response === FALSE) {
            //echo "Failed to get response from OMDB API.<br>"; // Debugging line
            return null;
        }

        $data = json_decode($response, true);
        if ($data['Response'] == 'False') {
            //echo "OMDB API returned an error: " . $data['Error'] . "<br>"; // Debugging line
            return null;
        }

        return $data;
    }

    public function saveRating($userId, $movieName, $imdbId, $rating) {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO movie_ratings (user_id, movie_name, imdb_id, rating) VALUES (:user_id, :movie_name, :imdb_id, :rating)");
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':movie_name', $movieName);
        $statement->bindValue(':imdb_id', $imdbId);
        $statement->bindValue(':rating', $rating, PDO::PARAM_STR);
        $statement->execute();
    }
}
?>