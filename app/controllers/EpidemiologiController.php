<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Epidemiologi;

class EpidemiologiController extends Controller
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
            $_SESSION['errors']['auth'] = 'You must be logged in to access the epidemiologi.';

            // Redirect to the home page
            header('Location: '. '/');
            exit;
        }
    }

    /**
     * Display the list of epidemiologis.
     *
     * This method handles the "index" action for the epidemiologi page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`epidemiologi/index.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function index(): void
    {
        // Initialize an instance of the Epidemiologi model
        $epidemiologi = new Epidemiologi();

        // Get pagination page number from the query string
        $page = $_GET['page'] ?? 1;

        // Load all epidemiologis from the database
        $epidemiologis = $epidemiologi->getAllEpidemiologi(
            page: $page
        );

        // Generate the pagination links
        $pagination = $epidemiologi->getPaginationLinks(
            page: $page
        );

        // Render the epidemiologi list view (located in the 'views/epidemiologi/index.php' file).
        $this->view('epidemiologi/index', compact('epidemiologis', 'pagination'));
    }

    /**
     * Display the epidemiologi registration form.
     *
     * This method handles the "register" action for the epidemiologi registration page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`epidemiologi/register.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function registerForm(): void
    {
        // Render the epidemiologi registration form view (located in the 'views/epidemiologi/register.php' file).
        $this->view('epidemiologi/register');
    }

    /**
     * Register a new epidemiologi.
     *
     * This method handles the "register" action for the epidemiologi registration form.
     * It processes the form submission, validates the input data, and saves the
     * new epidemiologi record to the database.
     *
     * @return void
     */
    public function register(): void
    {
        // Redirect to the form registration page when the method is not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. '/epidemiologi/form-register');
            exit;
        }

        // Initialize an instance of the epidemiologi model
        $epidemiologi = new Epidemiologi();

        // Set properties of the epidemiologi object
        $epidemiologi->setProperties($_POST);

        // Validate the form data
        $errors = $epidemiologi->validate($_POST);

        // When there are validation errors, store the errors in the session
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;

            // Redirect back to the epidemiologi registration form
            header('Location: '. '/epidemiologi/form-register');
            exit;
        }

        // Save the epidemiologi record to the database
        $epidemiologi->create();

        // Create a success message
        $_SESSION['success'] = 'Epidemiologi data has been successfully registered.';

        // Redirect to the epidemiologi list page
        header('Location: '. '/epidemiologi');
        exit;
    }
}