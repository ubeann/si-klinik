<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Disease;
use App\Models\Epidemiologi;
use App\Models\Patient;

/**
 * HomeController
 *
 * This controller is responsible for handling requests to the home page of
 * the application. It extends the base Controller class, which provides
 * common functionality such as rendering views.
 */
class HomeController extends Controller
{
    /**
     * Constructor
     *
     * Initializes the controller by checking the user's authentication status.
     * If the user is authenticated, they are redirected to the dashboard.
     */
    public function __construct()
    {
        // Check user authentication status and redirect to the dashboard if authenticated
        if (isset($_SESSION['user']) && $_SERVER['REQUEST_URI'] === '/') {
            header('Location: '. '/dashboard');
            exit;
        }
    }

    /**
     * Display the home page.
     *
     * This method handles the "index" action for the home page. It calls
     * the `view` method (inherited from the base Controller class) to load
     * the corresponding view file (`home/index.php`). Additional data can
     * be passed to the view if needed.
     *
     * @return void
     */
    public function index(): void
    {
        // Render the home page view (located in the 'views/home/index.php' file).
        $this->view('home/index');
    }

    /**
     * Display the dashboard page.
     *
     * This method handles the "dashboard" action for the dashboard page. It
     * calls the `view` method (inherited from the base Controller class) to
     * load the corresponding view file (`home/dashboard.php`). Additional data
     * can be passed to the view if needed.
     *
     * @return void
     */
    public function dashboard(): void
    {
        // Check user authentication status and redirect to the login page if not authenticated
        if (!isset($_SESSION['user'])) {
            // Create an error message for unauthorized access
            $_SESSION['errors']['auth'] = 'You must be logged in to access the dashboard.';

            // Redirect to the home page
            header('Location: '. '/');
            exit;
        }

        // Initialize some models
        $diseaseModel = new Disease();
        $epidemiologiModel = new Epidemiologi();
        $patientModel = new Patient();

        // Count the total number of patients
        $totalDiseases = number_format($diseaseModel->count());
        $totalEpidemiologis = number_format($epidemiologiModel->count());
        $totalPatients = number_format($patientModel->count());

        // Get chart data
        $chartData = $patientModel->getChartData();

        // Render the dashboard view (located in the 'views/home/dashboard.php' file).
        $this->view('home/dashboard', [
            'totalPatients' => $totalPatients,
            'totalDiseases' => $totalDiseases,
            'totalEpidemiologis' => $totalEpidemiologis,
            'data' => $chartData,
        ]);
    }
}
