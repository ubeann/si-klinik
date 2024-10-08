<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Patient;

class PatientController extends Controller
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
            $_SESSION['errors']['auth'] = 'You must be logged in to access the patient.';

            // Redirect to the home page
            header('Location: '. '/');
            exit;
        }
    }

    /**
     * Display the list of patients.
     *
     * This method handles the "index" action for the patient page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`patient/index.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function index(): void
    {
        // Initialize an instance of the Patient model
        $patient = new Patient();

        // Get the status and search values from the query string
        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';

        // Set 'all' as the default status value
        if ($status === 'all') {
            $status = '';
        }

        // Get pagination page number from the query string
        $page = $_GET['page'] ?? 1;

        // Load all patients from the database
        $patients = $patient->getAllPatients(
            filters: ['status' => $status, 'search' => $search],
            page: $page
        );

        // Generate the pagination links
        $pagination = $patient->getPaginationLinks(
            filters: ['status' => $status, 'search' => $search],
            page: $page
        );

        // Render the patient list view (located in the 'views/patient/index.php' file).
        $this->view('patient/index', ['patients' => $patients, 'pagination' => $pagination]);
    }

    /**
     * Display the patient registration form.
     *
     * This method handles the "register" action for the patient registration page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`patient/register.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function registerForm(): void
    {
        // Render the patient registration form view (located in the 'views/patient/register.php' file).
        $this->view('patient/register');
    }

    /**
     * Register a new patient.
     *
     * This method handles the "register" action for the patient registration form.
     * It processes the form submission, validates the input data, and saves the
     * new patient record to the database.
     *
     * @return void
     */
    public function register(): void
    {
        // Redirect to the form registration page when the method is not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. '/patients/form-register');
            exit;
        }

        // Remove any existing errors from the session
        unset($_SESSION['errors']);

        // Initialize an instance of the Patient model
        $patient = new Patient();

        // Set properties of the patient object
        $patient->setProperties($_POST);

        // Validate the form data
        $errors = $patient->validate($_POST);

        // When there are validation errors, store the errors in the session
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;

            // Redirect back to the patient registration form
            header('Location: '. '/patients/form-register');
            exit;
        }

        // Save the patient record to the database
        $patient->create();

        // Redirect to the patient list page
        header('Location: '. '/patients');
        exit;
    }

    public function queue(): void
    {
        // Render the patient queue view (located in the 'views/patient/queue.php' file).
        $this->view('patient/queue');
    }
}
