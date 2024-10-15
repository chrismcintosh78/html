<?php
class Router {
    private $arrRoute = [];
    private $strDefaultRoute = 'Home';
    public $htmRouteContent;

    public function __construct() {
        $this->parseUrl();
    }

    private function parseUrl() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $strRequestUri = $_SERVER['REQUEST_URI'];
            $strCleanedUri = trim(str_replace('/public/', '', $strRequestUri), '/');
            $this->arrRoute = explode('/', $strCleanedUri);

            if (empty($this->arrRoute[0])) {
                $this->arrRoute[0] = $this->strDefaultRoute;
            }
        }
    }

    public function route() {
        // Get the controller (first part of the route)
        $strController = isset($this->arrRoute[0]) ? ucfirst($this->arrRoute[0]) : $this->strDefaultRoute;

        // Combine everything after the controller as subroute
        $strSubRoute = isset($this->arrRoute[1]) ? implode('/', array_slice($this->arrRoute, 1)) : null;

        $strControllerFile = '../core/controllers/routes/' . $strController . '.php';

        if (file_exists($strControllerFile)) {
            require_once $strControllerFile;
            $strControllerClass = $strController;

            if (class_exists($strControllerClass)) {
                $objController = new $strControllerClass();

                // Pass the entire subroute as a string to the index method
                if (method_exists($objController, 'index')) {
                    $objController->index($strSubRoute);
                    $this->htmRouteContent = $objController->htmContent;
                } else {
                    $this->send404(); // If index method doesn't exist
                }
            } else {
                $this->send404(); // If class doesn't exist
            }
        } else {
            $this->send404(); // If file doesn't exist
        }
    }

    private function send404() {
        echo "404 - Page Not Found";
    }
}
?>
