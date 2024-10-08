<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Patient;

/**
 * PatientController
 *
 * This controller handles patient-related tasks such as patient registration,
 * editing, and deletion. It uses the `Patient` model to interact with the patient
 * data and manages session states for handling error/success messages.
 */
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

        // Create a success message
        $_SESSION['success'] = 'Patient record created successfully.';

        // Redirect to the patient list page
        header('Location: '. '/patients');
        exit;
    }

    /**
     * Display the patient edit form.
     *
     * This method handles the "edit" action for the patient page.
     * It retrieves the patient record with the specified ID from the database
     * and displays the patient edit form.
     *
     * @return void
     */
    public function editForm(): void {
        // Initialize an instance of the Patient model
        $patient = new Patient();

        // Get the patient record with the specified ID
        $patient->load($_GET['id']);

        // Render the patient edit form view (located in the 'views/patient/edit.php' file).
        $this->view('patient/edit', ['patient' => $patient, 'id' => $_GET['id']]);
    }

    /**
     * Update a patient record.
     *
     * This method handles the "edit" action for the patient edit form.
     * It processes the form submission, validates the input data, and updates
     * the patient record with the specified ID in the database.
     *
     * @return void
     */
    public function edit(): void {
        // Redirect to the form registration page when the method is not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. '/patients/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Initialize an instance of the Patient model
        $patient = new Patient();

        // Get the patient record with the specified ID
        $patient->load($_GET['id']);

        // Set properties of the patient object
        $patient->setProperties($_POST);

        // Validate the form data
        $errors = $patient->validate($_POST);

        // When there are validation errors, store the errors in the session
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;

            // Redirect back to the patient edit form
            header('Location: '. '/patients/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Update the patient record in the database
        $patient->update($_GET['id']);

        // Create a success message
        $_SESSION['success'] = 'Patient record updated successfully.';

        // Redirect to the patient list page
        header('Location: '. '/patients');
        exit;
    }

    /**
     * Delete a patient record.
     *
     * This method handles the "delete" action for the patient page.
     * It deletes the patient record with the specified ID from the database.
     *
     * @return void
     */
    public function delete(): void {
        // Initialize an instance of the Patient model
        $patient = new Patient();

        // Delete the patient record
        $success = $patient->delete($_GET['id']);

        // Create a success message
        if ($success) {
            $_SESSION['success'] = 'Patient record deleted successfully.';
        } else {
            $_SESSION['errors']['delete'] = 'Failed to delete patient record.';
        }

        // Redirect to the patient list page
        header('Location: '. '/patients');
    }
}
