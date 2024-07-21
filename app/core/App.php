<?php

class App {

    protected $controller = 'home';  // Default controller is 'home'
    protected $method = 'index';
    protected $special_url = ['apply'];
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Debugging output for parsed URL
        // echo "Parsed URL: ";
        // var_dump($url);

        if (!empty($url) && file_exists('app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            $_SESSION['controller'] = $this->controller;

            if (in_array($this->controller, $this->special_url)) {
                $this->method = 'index';
            }
            unset($url[0]);
        } elseif (!empty($url) && $url[0] === 'login') {
            // Allow login controller without redirecting to home
            $this->controller = 'login';
        } else {
            // Keep the default controller as 'home'
            $this->controller = 'home';
        }

        require_once 'app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            $url[1] = explode('?', $url[1])[0]; // Remove query parameters from method
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                $_SESSION['method'] = $this->method;
                unset($url[1]);
            }
        }

        // Debugging after setting headers
        //echo "Controller: " . get_class($this->controller) . "<br>";
        //echo "Method: " . $this->method . "<br>";

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = filter_var(trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return array_slice($url, 0); // No need to shift elements
        }
        return [];
    }
}
?>