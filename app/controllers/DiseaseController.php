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
        // Initialize an instance of the Disease model
        $disease = new Disease();

        // Get pagination page number from the query string
        $page = $_GET['page'] ?? 1;

        // Load all diseases from the database
        $diseases = $disease->getAllDisease(
            page: $page
        );

        // Generate the pagination links
        $pagination = $disease->getPaginationLinks(
            page: $page
        );

        // Render the disease list view (located in the 'views/disease/index.php' file).
        $this->view('disease/index', compact('diseases', 'pagination'));
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

        // Redirect to the disease list page
        header('Location: '. '/disease');
        exit;
    }

    /**
     * Display the disease edit form.
     *
     * This method handles the "edit" action for the disease page.
     * It retrieves the disease record with the specified ID from the database
     * and displays the disease edit form.
     *
     * @return void
     */
    public function editForm(): void {
        // Initialize an instance of the Disease model
        $disease = new Disease();

        // Get the disease record with the specified ID
        $disease->load($_GET['id']);

        // Render the disease edit form view (located in the 'views/disease/edit.php' file).
        $this->view('disease/edit', ['disease' => $disease, 'id' => $_GET['id']]);
    }

    /**
     * Update a disease record.
     *
     * This method handles the "edit" action for the disease edit form.
     * It processes the form submission, validates the input data, and updates
     * the disease record with the specified ID in the database.
     *
     * @return void
     */
    public function edit(): void {
        // Redirect to the form registration page when the method is not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. '/disease/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Initialize an instance of the Disease model
        $disease = new Disease();

        // Get the disease record with the specified ID
        $disease->load($_GET['id']);

        // Set properties of the disease object
        $disease->setProperties($_POST);

        // Validate the form data
        $errors = $disease->validate($_POST);

        // When there are validation errors, store the errors in the session
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;

            // Redirect back to the disease edit form
            header('Location: '. '/disease/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Update the disease record in the database
        $disease->update($_GET['id']);

        // Create a success message
        $_SESSION['success'] = 'The disease has been updated successfully.';

        // Redirect to the disease list page
        header('Location: '. '/disease');
        exit;
    }

    /**
     * Delete a disease record.
     *
     * This method handles the "delete" action for the disease page.
     * It deletes the disease record with the specified ID from the database.
     *
     * @return void
     */
    public function delete(): void {
        // Initialize an instance of the Disease model
        $disease = new Disease();

        // Delete the disease record
        $success = $disease->delete($_GET['id']);

        // Create a success message
        if ($success) {
            $_SESSION['success'] = 'The disease has been deleted successfully.';
        } else {
            $_SESSION['errors']['delete'] = 'Failed to delete the disease.';
        }

        // Redirect to the disease list page
        header('Location: '. '/disease');
    }
}