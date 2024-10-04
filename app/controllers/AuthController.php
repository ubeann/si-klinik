<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;

/**
 * AuthController
 *
 * This controller handles user authentication tasks such as registration,
 * login, and logout. It uses the `User` model to interact with the user
 * data and manages session states for handling authentication status and
 * error/success messages.
 */
class AuthController extends Controller
{
    /**
     * Constructor
     *
     * Initializes the controller by clearing session messages (errors, success)
     * from the previous request and checking the user's authentication status.
     * If the user is already authenticated, they are redirected to the dashboard.
     * If the request method is not POST, the user is redirected to the home page.
     */
    public function __construct()
    {
        // Remove error messages from the previous request
        unset($_SESSION['errors']);

        // Remove success messages from the previous request
        unset($_SESSION['success']);

        // Check if the user is authenticated, redirect to dashboard if authenticated
        if (isset($_SESSION['user']) && $_SERVER['REQUEST_URI'] !== '/logout') {
            header('Location: /dashboard');
            exit;
        }

        // Ensure the request method is POST, otherwise redirect to home
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /');
            exit;
        }
    }

    /**
     * Register a new user.
     *
     * This method handles user registration by validating form data submitted
     * via POST. If the data is valid, a new user is created. If there are validation
     * errors, they are stored in the session, and the user is redirected back
     * to the home page.
     *
     * @return void
     */
    public function register(): void
    {
        // Create a new User model instance with the form data
        $user = new User(data: $_POST);

        // Validate the registration form data
        $errors = $user->validate();

        // If validation fails, save errors to the session and redirect to home
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /');
            exit;
        }

        // If data is valid, create the new user
        $user->create();

        // Save a success message to the session
        $_SESSION['success'] = 'User created successfully!';

        // Redirect to the home page
        header('Location: /');
    }

    /**
     * Log in an existing user.
     *
     * This method handles user login by checking the user's email and password
     * against the data in the database. If the credentials are valid, the user
     * is authenticated and redirected to the dashboard. If invalid, an error
     * message is saved to the session and the user is redirected back to the
     * home page.
     *
     * @return void
     */
    public function login(): void
    {
        // Create a new User model instance
        $user = new User();

        // Load the user data from the database using the provided email
        $user->loadByEmail($_POST['email']);

        // Verify the password, redirect with an error if invalid
        if (!$user || !$user->verifyPassword($_POST['password'])) {
            // Save an error message to the session
            $_SESSION['errors']['login'] = 'Invalid email or password';

            // Redirect to the home page
            header('Location: /');
            exit;
        }

        // Store authenticated user information in the session
        $_SESSION['user'] = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'role' => $user->getRole(),
        ];

        // Redirect to the dashboard
        header('Location: /dashboard');
    }

    /**
     * Log out the user.
     *
     * This method logs out the current user by destroying their session and
     * redirecting them to the home page.
     *
     * @return void
     */
    public function logout(): void
    {
        // Destroy the current session to log out the user
        session_destroy();

        // Redirect to the home page
        header('Location: /');
    }
}
