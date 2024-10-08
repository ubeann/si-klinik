<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
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
        // Initialize an instance of the User model
        $user = new User();

        // Get the role and search values from the query string
        $role = $_GET['role'] ?? '';
        $search = $_GET['search'] ?? '';

        // Set 'all' as the default role value
        if ($role === 'all') {
            $role = '';
        }

        // Get pagination page number from the query string
        $page = $_GET['page'] ?? 1;

        // Load all users from the database
        $users = $user->getAllUsers(
            filters: ['role' => $role, 'search' => $search],
            page: $page
        );

        // Generate the pagination links
        $pagination = $user->getPaginationLinks(
            filters: ['role' => $role, 'search' => $search],
            page: $page
        );

        // Render the patient list view (located in the 'views/patient/index.php' file).
        $this->view('user/index', [
            'users' => $users,
            'pagination' => $pagination
        ]);
    }
}