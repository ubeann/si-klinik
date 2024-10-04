<?php

namespace App\Controllers;

use App\Controllers\Controller;

class CashierController extends Controller
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
            $_SESSION['errors']['auth'] = 'You must be logged in to access the cashier.';

            // Redirect to the home page
            header('Location: '. '/');
            exit;
        }
    }

    /**
     * Display the cashier index page.
     *
     * This method handles the "index" action for the cashier index page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`cashier/index.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function index(): void
    {
        // Render the cashier index view (located in the 'views/cashier/index.php' file).
        $this->view('cashier/index');
    }

    /**
     * Display the cashier registration form.
     *
     * This method handles the "registerForm" action for the cashier registration page.
     * It calls the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`cashier/register.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function registerForm(): void
    {
        // Render the cashier registration form view (located in the 'views/cashier/register.php' file).
        $this->view('cashier/register');
    }
}
