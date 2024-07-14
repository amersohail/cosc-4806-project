<?php

class Movie {

    public function __construct() {
        private $apiUrl = 'http://www.omdbapi.com/';

        public function getMovieDetailsByTitle($title) {
            $url = $this->apiUrl . '?apikey=' . $_ENV['OMDB_API_KEY'] . '&t=' . urlencode($title);

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
    } 
}
?>