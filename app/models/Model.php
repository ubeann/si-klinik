<?php

namespace App\Models;

use App\Database;
use PDO;
use PDOStatement;

/**
 * Class Model
 *
 * A base model class that provides a common interface to interact with the database.
 * It establishes a database connection using the Database singleton and provides
 * a method for executing queries.
 */
abstract class Model
{
    /**
     * @var PDO $db The PDO database connection instance.
     */
    protected PDO $db;

    /**
     * Model constructor.
     *
     * Initializes the database connection by retrieving the singleton PDO instance
     * from the Database class.
     */
    public function __construct()
    {
        // Get the PDO connection from the Database singleton
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Execute a prepared SQL query with optional parameters.
     *
     * @param string $sql The SQL query to be executed.
     * @param array<int|string, mixed> $params Optional associative array or indexed array
     *                                         of parameters to bind to the query.
     *
     * @return PDOStatement The PDO statement after execution.
     */
    protected function query(string $sql, array $params = []): PDOStatement
    {
        // Prepare the SQL statement
        $stmt = $this->db->prepare($sql);

        // Execute the statement with the provided parameters
        $stmt->execute($params);

        // Return the executed statement
        return $stmt;
    }
}
