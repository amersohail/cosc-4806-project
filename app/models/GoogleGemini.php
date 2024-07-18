<?php
class GoogleGemini {
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    // Constructor to initialize API key from environment variables
    public function __construct() {
        $this->apiKey = $_ENV['GEMINI_API_KEY'];
    }

    // Method to send a prompt to Google Gemini and get a response
    public function ask($prompt) {
        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '?key=' . $this->apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        // Check if the response is false and return an error if it is
        if ($response === false) {
            return 'Error: ' . curl_error($ch);
        }

        // Decode the JSON response
        $responseData = json_decode($response, true);

        // Extract the review text from the response
        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return $responseData['candidates'][0]['content']['parts'][0]['text'];
        } else {
            return 'Error: Invalid response from Google Gemini';
        }
    }
}
?>