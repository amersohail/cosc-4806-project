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
}
?>