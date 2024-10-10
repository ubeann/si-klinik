<?php

namespace App\Controllers;

use App\Controllers\Controller;

class DiseaseController extends Controller
{
    /**
     * Constructor
     *
     * Initializes the controller by checking the user's authentication status.
     * If the user is not authenticated, they are redirected to the home page.
     */
    public function __construct()
    {
        // Check user authentication status and redirect to the login page if not authenticated
        if (!isset($_SESSION['user'])) {
            // Create an error message for unauthorized access
            $_SESSION['errors']['auth'] = 'You must be logged in to access the index of diseases.';

            // Redirect to the home page
            header('Location: '. '/');
            exit;
        }
    }

    /**
     * Display the list of diseases.
     *
     * This method handles the "index" action for the disease page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`disease/index.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function index(): void
    {
        // Render the disease list view (located in the 'views/disease/index.php' file).
        $this->view('disease/index');
    }

    /**
     * Display the disease registration form.
     *
     * This method handles the "register" action for the disease registration page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`disease/register.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function registerForm(): void
    {
        // Render the disease registration form view (located in the 'views/disease/register.php' file).
        $this->view('disease/register');
    }
}