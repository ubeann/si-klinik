<?php

namespace App;

/**
 * Class Router
 *
 * A simple routing class that handles the mapping of URLs to their respective
 * controllers and methods, simulating a basic web routing system.
 */
class Router
{
    /**
     * @var array<string, array<string, string>> $routes
     * An associative array to store routes where the key is the URL and the value
     * is an array containing the 'controller' and 'method' to be called for that URL.
     */
    private array $routes = [];

    /**
     * Add a new route to the router.
     *
     * @param string $url The URL pattern for the route.
     * @param string $controller The controller class that will handle the request.
     * @param string $method The method inside the controller that will be called.
     */
    public function addRoute(string $url, string $controller, string $method): void
    {
        // Add the URL, controller, and method to the routes array
        $this->routes[$url] = ['controller' => $controller, 'method' => $method];
    }

    /**
     * Dispatch the request to the appropriate controller and method based on the URL.
     *
     * @param string $url The current URL to match against the routes.
     */
    public function dispatch(string $url): void
    {
        // Trim `?` and everything after it from the URL
        $url = strtok($url, '?');

        // Check if the URL exists in the defined routes
        if (array_key_exists($url, $this->routes)) {
            // Get the corresponding controller and method for the URL
            $controller = $this->routes[$url]['controller'];
            $method = $this->routes[$url]['method'];

            // Create an instance of the controller class
            $controllerInstance = new $controller();

            // Call the specified method on the controller instance
            $controllerInstance->$method();
        } else {
            // If the URL is not found in the routes, return a 404 response
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }
}
