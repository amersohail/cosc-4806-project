<?php

class App {

    protected $controller = 'login';
    protected $method = 'index';
    protected $special_url = ['apply'];
    protected $params = [];

    public function __construct() {
        if (isset($_SESSION['auth']) == 1) {
            $this->controller = 'home';
        }

        $url = $this->parseUrl();

        // Output parsed URL for debugging (temporarily)
        // echo "Parsed URL: ";
        // var_dump($url);

        if (!empty($url) && file_exists('app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            $_SESSION['controller'] = $this->controller;

            if (in_array($this->controller, $this->special_url)) {
                $this->method = 'index';
            }
            unset($url[0]);
        } else {
            header('Location: /home');
            die;
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
        // echo "Controller: " . get_class($this->controller) . "<br>";
        // echo "Method: " . $this->method . "<br>";

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = filter_var(trim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return array_slice($url, 0); // No need to shift elements
        }
        return [];
    }
}
?>