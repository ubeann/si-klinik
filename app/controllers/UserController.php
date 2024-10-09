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
     * Display the list of users.
     *
     * This method handles the "index" action for the user page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`user/index.php`). Additional data can
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

        // Render the user list view (located in the 'views/user/index.php' file).
        $this->view('user/index', [
            'users' => $users,
            'pagination' => $pagination
        ]);
    }

    /**
     * Display the user registration form.
     *
     * This method handles the "register" action for the user registration page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`user/register.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function registerForm(): void
    {
        // Render the user registration form view (located in the 'views/user/register.php' file).
        $this->view('user/register');
    }

    /**
     * Register a new user.
     *
     * This method handles the "register" action for the user registration form.
     * It processes the form submission, validates the input data, and saves the
     * new user record to the database.
     *
     * @return void
     */
    public function register(): void
    {
        // Redirect to the form registration page when the method is not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. '/users/form-register');
            exit;
        }

        // Create a new User model instance with the form data
        $user = new User(data: $_POST);

        // Validate the registration form data
        $errors = $user->validate();

        // If validation fails, save errors to the session and redirect to home
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: '. '/users/form-register');
            exit;
        }

        // If data is valid, create the new user
        $user->create();

        // Save a success message to the session
        $_SESSION['success'] = 'User created successfully!';

        // Redirect to the home page
        header('Location: '. '/users');
    }

    /**
     * Display the user edit form.
     *
     * This method handles the "edit" action for the user page.
     * It retrieves the user record with the specified ID from the database
     * and displays the user edit form.
     *
     * @return void
     */
    public function editForm(): void {
        // Initialize an instance of the User model
        $user = new User();

        // Get the user record with the specified ID
        $user->load($_GET['id']);

        // Render the user edit form view (located in the 'views/user/edit.php' file).
        $this->view('user/edit', ['user' => $user, 'id' => $_GET['id']]);
    }

    /**
     * Update a user record.
     *
     * This method handles the "edit" action for the user edit form.
     * It processes the form submission, validates the input data, and updates
     * the user record with the specified ID in the database.
     *
     * @return void
     */
    public function edit(): void {
        // Redirect to the form registration page when the method is not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. '/users/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Initialize an instance of the User model
        $user = new User();

        // Load the user record to be updated
        $user->load($_GET['id']);

        // Set the updated user record properties
        $user->setInfo($_POST);

        // Validate the updated user record
        $errors = $user->validate();

        // If validation fails, save errors to the session and redirect to the user edit form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: '. '/users/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Update the user record in the database
        $user->update($_GET['id']);

        // Save a success message to the session
        $_SESSION['success'] = 'User updated successfully.';

        // Redirect to the user list page
        header('Location: '. '/users');
    }

    /**
     * Change the user password.
     *
     * This method handles the "change-password" action for the user page.
     * It processes the form submission, validates the input data, and updates
     * the user's password in the database.
     *
     * @return void
     */
    public function changePassword(): void {
        // Redirect to the form registration page when the method is not POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. '/users/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Check `password` and `password_confirmation` fields are not empty and match
        if (empty($_POST['password']) || empty($_POST['password_confirmation']) || $_POST['password'] !== $_POST['password_confirmation']) {
            // Create an error message for password mismatch
            $_SESSION['errors']['password'] = 'Password and confirmation do not match.';

            // Redirect to the user edit form
            header('Location: '. '/users/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Initialize an instance of the User model
        $user = new User();

        // Load the user record to be updated
        $user->load($_GET['id']);

        // Set the updated user password
        $user->setPassword($_POST['password']);

        // Hash the updated password
        $user->hashPassword();

        // Validate the updated user password
        $errors = $user->validate();

        // If validation fails, save errors to the session and redirect to the user edit form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: '. '/users/form-edit?id=' . $_GET['id']);
            exit;
        }

        // Update the user password in the database
        $user->updatePassword();

        // Save a success message to the session
        $_SESSION['success'] = 'Password updated successfully.';

        // Redirect to the user list page
        header('Location: '. '/users');
    }

    /**
     * Delete a user record.
     *
     * This method handles the "delete" action for the user page.
     * It deletes the user record with the specified ID from the database.
     *
     * @return void
     */
    public function delete(): void {
        // Initialize an instance of the User model
        $user = new User();

        // Load the user record to be deleted
        $user->load($_GET['id']);

        // Check if the user is trying to delete their own account
        if ($_SESSION['user']['email'] === $user->getEmail()) {
            // Create an error message for unauthorized access
            $_SESSION['errors']['delete'] = 'You cannot delete your own account.';

            // Redirect to the user list page
            header('Location: '. '/users');
            exit;
        }

        // Delete the user record
        $success = $user->delete($_GET['id']);

        // Create a success message
        if ($success) {
            $_SESSION['success'] = 'User deleted successfully.';
        } else {
            $_SESSION['errors']['delete'] = 'Failed to delete user.';
        }

        // Redirect to the user list page
        header('Location: '. '/users');
    }
}