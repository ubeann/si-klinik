<?php

namespace App;

use PDO;

/**
 * Class Database
 *
 * Implements the Singleton pattern to ensure only one instance of the database connection is created.
 * It uses PDO to connect to a MySQL database using credentials stored in a configuration file.
 */
class Database
{
    /**
     * @var Database|null $instance The single instance of the Database class.
     */
    private static ?Database $instance = null;

    /**
     * @var PDO $pdo The PDO instance for database connection.
     */
    private PDO $pdo;

    /**
     * Private constructor to prevent multiple instances.
     * It creates a PDO connection using configuration from the database.php file.
     */
    private function __construct()
    {
        // Load the database configuration from the database.php config file
        $config = require_once __DIR__ . '../../config/database.php';

        // Set up the DSN (Data Source Name) string for the PDO connection
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        // PDO options for error handling, fetching mode, and emulated prepares
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions for PDO errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set the default fetch mode to associative arrays
            PDO::ATTR_EMULATE_PREPARES => false, // Disable emulated prepared statements for security
        ];

        // Attempt to establish a PDO connection
        try {
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (\PDOException $e) {
            // Throw a new PDOException with the error message and code
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Get the singleton instance of the Database class.
     *
     * @return Database The single instance of the Database class.
     */
    public static function getInstance(): Database
    {
        // If no instance exists, create one
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    /**
     * Get the PDO connection.
     *
     * @return PDO The PDO connection instance.
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
