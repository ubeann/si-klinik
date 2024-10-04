<?php

namespace App\Helpers;

/**
 * URL Helper Functions
 *
 * This file contains helper functions for generating URLs within the application.
 * It defines constants and functions that assist in constructing asset paths
 * and the base URL, ensuring a centralized and consistent way to reference
 * resources in the application.
 */

/**
 * Define a constant for the base URL of the application.
 *
 * This constant represents the root URL of the application, which can be used
 * throughout the application to construct absolute URLs for different resources.
 *
 * You may change this constant based on the environment (e.g., development,
 * staging, production) to ensure that URLs point to the correct base path.
 */
define('BASE_URL', 'http://localhost:8000');

/**
 * Generate a URL for an asset file.
 *
 * This function takes a relative path to an asset file and generates the full
 * URL by appending the relative path to the defined BASE_URL.
 *
 * @param string $path The relative path to the asset file (e.g., 'css/style.css').
 *
 * @return string The full URL to the asset file. The returned URL will have
 *                the base URL prepended and any leading slashes removed from
 *                the relative path to avoid double slashes.
 *
 * Example usage:
 *   - Calling asset('images/logo.png') will return
 *     'http://localhost:8000/images/logo.png'.
 */
function asset(string $path): string
{
    // Ensure the base URL and the relative path are combined correctly
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Generate a URL for a route.
 *
 * This function takes a route name and generates the full URL by appending the
 * route name to the defined BASE_URL. It is useful for generating URLs for
 * named routes in the application.
 *
 * @param string $routeName The name of the route to generate a URL for.
 *
 * @return string The full URL to the route. The returned URL will have the
 *                base URL prepended and any leading slashes removed from the
 *                route name to avoid double slashes.
 *
 * Example usage:
 *   - Calling route('home') will return 'http://localhost:8000/'.
 */
function route(string $routeName): string
{
    // Ensure the base URL and the route name are combined correctly
    return BASE_URL . '/' . ltrim($routeName, '/');
}