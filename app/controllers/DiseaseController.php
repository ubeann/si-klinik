<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Disease;

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

    /**
     * Register a new disease.
     *
     * This method handles the "register" action for the disease registration form.
     * It processes the form submission, validates the input data, and saves the
     * new disease record to the database.
     *
     * @return void
     */
    public function register(): void
    {
        // Redirect to the form registration page when the method is not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. '/disease/form-register');
            exit;
        }

        // Initialize an instance of the Disease model
        $disease = new Disease();

        // Set properties of the disease object
        $disease->setProperties($_POST);

        // Validate the form data
        $errors = $disease->validate($_POST);

        // When there are validation errors, store the errors in the session
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;

            // Redirect back to the disease registration form
            header('Location: '. '/disease/form-register');
            exit;
        }

        // Save the disease record to the database
        $disease->create();

        // Create a success message
        $_SESSION['success'] = 'The disease has been registered successfully.';

        // Redirect to the patient list page
        header('Location: '. '/disease');
        exit;
    }
}