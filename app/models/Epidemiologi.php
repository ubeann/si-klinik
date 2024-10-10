<?php

namespace App\Models;

use DateTime;
use InvalidArgumentException;
use PDO;

class Epidemiologi extends Model
{
    protected string $table = 'epidemiologi'; // The name of the database table

    // Epidemiologi properties
    private string $fullName = '';
    private string $nationalIdNumber = '';
    private string $gender = '';
    private int $age = 0;
    private string $address = '';
    private string $diagnosis = '';
    private string $diagnosisDate = '';

    // Constants for valid field values
    private const VALID_GENDERS = ['l', 'p'];

    /**
     * Get all epidemiologi with optional filtering and pagination
     *
     * @param array $filters Optional filters (status, search)
     * @param int $page Current page number for pagination
     * @param int $perPage Number of records per page
     * @return array An array of epidemiologi
     */
    public function getAllEpidemiologi(array $filters = [], int $page = 1, int $perPage = 10): array
    {
        $conditions = []; // Stores the WHERE conditions for the SQL query
        $params = []; // Stores the parameter values for the query

        // Filter by status if provided
        if (!empty($filters['status'])) {
            $conditions[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        // Filter by search query if provided
        if (!empty($filters['search'])) {
            $conditions[] = "(full_name LIKE :name OR national_id_number LIKE :number)";
            $params[':name'] = "%{$filters['search']}%";
            $params[':number'] = "%{$filters['search']}%";
        }

        // Build the WHERE clause if conditions are set
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        // Calculate the offset for pagination
        $offset = ($page - 1) * $perPage;

        // SQL query to retrieve the epidemiologis with optional filters and pagination
        $sql = "SELECT * FROM {$this->table}
                {$whereClause}
                ORDER BY full_name ASC
                LIMIT :limit OFFSET :offset";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, array_merge($params, [
            ':limit' => $perPage,
            ':offset' => $offset
        ]));

        // Fetch and return all epidemiologi records
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the pagination links for the epidemiologi list
     *
     * @param array $filters Optional filters (status, search)
     * @param int $page Current page number for pagination
     * @param int $perPage Number of records per page
     * @return array An array of pagination links
     */
    public function getPaginationLinks(array $filters = [], int $page = 1, int $perPage = 10): array
    {
        $conditions = []; // Stores the WHERE conditions for the SQL query
        $params = []; // Stores the parameter values for the query

        // Filter by status if provided
        if (!empty($filters['status'])) {
            $conditions[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        // Filter by search query if provided
        if (!empty($filters['search'])) {
            $conditions[] = "(full_name LIKE :name OR national_id_number LIKE :number)";
            $params[':name'] = "%{$filters['search']}%";
            $params[':number'] = "%{$filters['search']}%";
        }

        // Build the WHERE clause if conditions are set
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        // SQL query to count the total number of epidemiologis
        $sql = "SELECT COUNT(*) FROM {$this->table} {$whereClause}";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, $params);

        // Get the total number of epidemiologis
        $totalRecords = $stmt->fetchColumn();

        // Calculate the total number of pages
        $totalPages = ceil($totalRecords / $perPage);

        // Generate the pagination links
        $links = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $links[] = [
                'page' => $i,
                'url' => "?page={$i}"
            ];
        }

        return $links;
    }

    /**
     * Set epidemiologi properties from an array of data
     *
     * @param array $data Associative array of epidemiologi data
     */
    public function setProperties(array $data): void
    {
        // Set the epidemiologi properties from the provided data
        $this->fullName = $this->sanitizeString($data['full_name'] ?? '');
        $this->nationalIdNumber = $this->sanitizeString($data['national_id_number'] ?? '');
        $this->gender = strtolower($this->sanitizeString($data['gender'] ?? ''));
        $this->age = (int) ($data['age'] ?? 0);
        $this->address = $this->sanitizeString($data['address'] ?? '');
        $this->diagnosis = $this->sanitizeString($data['diagnosis'] ?? '');
        $this->diagnosisDate = $this->sanitizeString($data['diagnosis_date'] ?? '');
    }

    /**
     * Validate epidemiologi data
     *
     * @return array<string, string> Array of validation errors if any
     */
    public function validate(): array
    {
        $errors = [];

        // Validate the full name
        if (empty($this->fullName)) {
            $errors['full_name'] = 'Full Name is required.';
        }

        // Validate the national ID number
        if (!empty($this->nationalIdNumber) && !preg_match('/^\d{16}$/', $this->nationalIdNumber)) {
            $errors['national_id_number'] = 'National ID Number must be 16 digits';
        }

        // Validate gender
        if (!in_array($this->gender, self::VALID_GENDERS, true)) {
            $errors['gender'] = 'Invalid gender selected';
        }

        // Validate age
        if ($this->age <= 0) {
            $errors['age'] = 'Age must be greater than 0';
        }

        // Validate address
        if (empty($this->address)) {
            $errors['address'] = 'Address is required';
        }

        // Validate diagnosis
        if (empty($this->diagnosis)) {
            $errors['diagnosis'] = 'Diagnosis is required';
        }

        // Date validation for diagnosis date
        try {
            $diagnosisDate = new DateTime($this->diagnosisDate);

            // Birth date cannot be in the future
            if ($diagnosisDate > new DateTime()) {
                $errors['diagnosis_date'] = 'Diagnosis date cannot be in the future';
            }
        } catch (\Exception $e) {
            $errors['date'] = 'Invalid date format';
        }

        // Return any validation errors
        return $errors;
    }

    /**
     * Create a new epidemiologi record in the database
     *
     * @return int|false The ID of the newly created epidemiologi or false on failure
     */
    public function create(): int|false
    {
        // Validate the data before proceeding
        $errors = $this->validate();
        if (!empty($errors)) {
            throw new InvalidArgumentException(json_encode($errors)); // Throw an exception if validation fails
        }

        // SQL query to insert a new epidemiologi record
        $sql = "INSERT INTO {$this->table} (
            full_name, national_id_number, gender,
            age, address, diagnosis, diagnosis_date
        ) VALUES (
            :full_name, :national_id, :gender,
            :age, :address, :diagnosis, :diagnosis_date
        )";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, [
            ':full_name' => $this->fullName,
            ':national_id' => $this->nationalIdNumber,
            ':gender' => $this->gender,
            ':age' => $this->age,
            ':address' => $this->address,
            ':diagnosis' => $this->diagnosis,
            ':diagnosis_date' => $this->diagnosisDate
        ]);

        // Return the ID of the newly created record
        return $stmt->rowCount() > 0
            ? (int) $this->db->lastInsertId()
            : false;
    }

    /**
     * Update an existing epidemiologi record in the database
     *
     * @param int $id The ID of the epidemiologi to update
     * @return bool True if the update was successful, false otherwise
     */
    public function update(int $id): bool
    {
        // Validate the data before proceeding
        $errors = $this->validate();
        if (!empty($errors)) {
            throw new InvalidArgumentException(json_encode($errors)); // Throw an exception if validation fails
        }

        // SQL query to update the epidemiologi record
        $sql = "UPDATE {$this->table} SET
            full_name = :full_name,
            national_id_number = :national_id,
            gender = :gender,
            age = :age,
            address = :address,
            diagnosis = :diagnosis,
            diagnosis_date = :diagnosis_date
            WHERE id = :id";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, [
            ':full_name' => $this->fullName,
            ':national_id' => $this->nationalIdNumber,
            ':gender' => $this->gender,
            ':age' => $this->age,
            ':address' => $this->address,
            ':diagnosis' => $this->diagnosis,
            ':diagnosis_date' => $this->diagnosisDate,
            ':id' => $id
        ]);

        // Return true if the update was successful
        return $stmt->rowCount() > 0;
    }

    /**
     * Load a epidemiologi record by ID
     *
     * @param int $id The ID of the epidemiologi to load
     * @return bool True if the epidemiologi was loaded successfully, false otherwise
     */
    public function load(int $id): bool
    {
        // SQL query to retrieve the epidemiologi record by ID
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->query($sql, ['id' => $id]);

        // Fetch the epidemiologi record
        if ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->setProperties($record);
            return true;
        }

        // Return false if the record was not found
        return false;
    }

    /**
     * Delete a epidemiologi record by ID
     *
     * This method deletes the epidemiologi record with the specified ID from the database.
     *
     * @param int $id The ID of the epidemiologi to delete
     * @return bool True if the epidemiologi was deleted successfully, false otherwise
     */
    public function delete(int $id): bool
    {
        // SQL query to delete the epidemiologi record by ID
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->query($sql, ['id' => $id]);

        // Return true if the delete was successful
        return $stmt->rowCount() > 0;
    }

    /**
     * Sanitize input to prevent XSS or unwanted characters
     *
     * @param string $input The input string to sanitize
     * @return string The sanitized string
     */
    private function sanitizeString(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8'); // Sanitize and trim input
    }

    // Getters
    public function getFullName(): string { return $this->fullName; }
    public function getNationalIdNumber(): string { return $this->nationalIdNumber; }
    public function getAge(): int { return $this->age; }
    public function getAddress(): string { return $this->address; }
    public function getDiagnosis(): string { return $this->diagnosis; }
    public function getDiagnosisDate(): string { return $this->diagnosisDate; }
    public function getGender(): string
    {
        switch ($this->gender) {
            case 'l': return 'Laki-laki';
            case 'p': return 'Perempuan';
            default: return '';
        }
    }
}
