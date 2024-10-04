<?php

namespace App\Controllers;

/**
 * Class Controller
 *
 * An abstract class that provides common functionality for all controllers,
 * such as rendering views. Controllers that extend this class will inherit
 * the `view` method to load views with associated data.
 */
abstract class Controller
{
    /**
     * Render a view file and pass data to it.
     *
     * @param string $viewName The name of the view file (without the .php extension).
     * @param array<string, mixed> $data An optional associative array of data to be extracted
     *                                  and made available to the view.
     *
     * @return void
     */
    protected function view(string $viewName, array $data = []): void
    {
        // Extract the associative array so keys become variables in the view
        extract($data);

        // Include the helper file for constants and functions
        require_once __DIR__ . "/../helpers/url.php";

        // Include the specified view file
        require_once __DIR__ . "/../../views/{$viewName}.php";
    }
}
