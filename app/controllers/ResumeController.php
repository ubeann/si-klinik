<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Patient;

class ResumeController extends Controller
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
     * Display the list of resume patients.
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

        // Render the resume list view (located in the 'views/resume/index.php' file).
        $this->view('resume/index', ['patients' => $patients, 'pagination' => $pagination]);
    }

    /**
     * Display the form to submit a new resume for a patient.
     *
     * This method handles the "form" action for the resume page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`resume/form.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function form(): void
    {
        // Check if the patient ID is provided in the query string
        if (!isset($_GET['id'])) {
            // Create an error message for missing patient ID
            $_SESSION['errors']['id'] = 'Patient ID is required to submit a resume.';

            // Redirect to the resume list page
            header('Location: '. '/resume');
            exit;
        }

        // Initialize an instance of the Patient model
        $patient = new Patient();

        // Get the patient record with the specified ID
        $patient->load($_GET['id']);

        // Render the resume form view (located in the 'views/resume/form.php' file).
        $this->view('resume/form', ['patient' => $patient]);
    }
}