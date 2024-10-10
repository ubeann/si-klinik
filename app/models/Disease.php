<?php

namespace App\Models;

use DateTime;
use InvalidArgumentException;
use PDO;

class Disease extends Model
{
    protected string $table = 'diseases'; // The name of the database table

    // Disease properties
    private string $name = '';
    private string $code = '';
    private string $category = '';
    private string $description = '';
    private string $severity_level = '';
    private string $affected_region = '';
    private string $incident_date = '';
    private int $victim_count = 0;
    private string $status = '';
    private string $history = '';
    private string $contact_information = '';

    // Constants for valid field values
    private const VALID_CATEGORIES = ['natural-disaster', 'epidemic', 'disease'];
    private const VALID_SEVERITY_LEVELS = ['low', 'medium', 'high', 'very-high'];
    private const VALID_STATUSES = ['active', 'inactive'];

    /**
     * Get all disease without filtering
     *
     * @return array An array of disease
     */
    public function getAllDiseaseRecord(): array
    {
        // SQL query to retrieve all disease records
        $sql = "SELECT * FROM {$this->table} ORDER BY full_name ASC";

        // Execute the query
        $stmt = $this->query($sql);

        // Fetch and return all disease records
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all disease with optional filtering and pagination
     *
     * @param array $filters Optional filters (status, search)
     * @param int $page Current page number for pagination
     * @param int $perPage Number of records per page
     * @return array An array of disease
     */
    public function getAllDisease(array $filters = [], int $page = 1, int $perPage = 10): array
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
            $conditions[] = "(name LIKE :name OR code LIKE :code)";
            $params[':name'] = "%{$filters['search']}%";
            $params[':code'] = "%{$filters['search']}%";
        }

        // Build the WHERE clause if conditions are set
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        // Calculate the offset for pagination
        $offset = ($page - 1) * $perPage;

        // SQL query to retrieve the diseases with optional filters and pagination
        $sql = "SELECT * FROM {$this->table}
                {$whereClause}
                ORDER BY full_name ASC
                LIMIT :limit OFFSET :offset";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, array_merge($params, [
            ':limit' => $perPage,
            ':offset' => $offset
        ]));

        // Fetch and return all disease records
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the pagination links for the disease list
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

        // SQL query to count the total number of diseases
        $sql = "SELECT COUNT(*) FROM {$this->table} {$whereClause}";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, $params);

        // Get the total number of diseases
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
     * Set disease properties from an array of data
     *
     * @param array $data Associative array of disease data
     */
    public function setProperties(array $data): void
    {
        // Set the disease properties from the provided data
        $this->name = $this->sanitizeString($data['name'] ?? '');
        $this->code = $this->sanitizeString($data['code'] ?? '');
        $this->category = $this->sanitizeString($data['category'] ?? '');
        $this->description = $this->sanitizeString($data['description'] ?? '');
        $this->severity_level = $this->sanitizeString($data['severity_level'] ?? '');
        $this->affected_region = $this->sanitizeString($data['affected_region'] ?? '');
        $this->incident_date = $this->sanitizeString($data['incident_date'] ?? '');
        $this->victim_count = (int) ($data['victim_count'] ?? 0);
        $this->status = $this->sanitizeString($data['status'] ?? '');
        $this->history = $this->sanitizeString($data['history'] ?? '');
        $this->contact_information = $this->sanitizeString($data['contact_information'] ?? '');
    }

    /**
     * Validate disease data
     *
     * @return array<string, string> Array of validation errors if any
     */
    public function validate(): array
    {
        $errors = []; // Initialize the errors array

        // Validate the disease name
        if (empty($this->name)) {
            $errors['name'] = 'Please enter the disease name';
        }

        // Validate the disease code
        if (empty($this->code)) {
            $errors['code'] = 'Please enter the disease code';
        }

        // Validate the disease category
        if (!in_array($this->category, self::VALID_CATEGORIES)) {
            $errors['category'] = 'Please select a valid category';
        }

        // Validate the disease severity level
        if (!in_array($this->severity_level, self::VALID_SEVERITY_LEVELS)) {
            $errors['severity_level'] = 'Please select a valid severity level';
        }

        // Validate the affected region
        if (empty($this->affected_region)) {
            $errors['affected_region'] = 'Please enter the affected region';
        }

        // Validate the incident date
        if (empty($this->incident_date)) {
            $errors['incident_date'] = 'Please enter the incident date';
        } else {
            $date = DateTime::createFromFormat('Y-m-d\TH:i', $this->incident_date);
            if (!$date) {
                $errors['incident_date'] = 'Please enter a valid date in the format YYYY-MM-DDTHH:MM';
            }
        }

        // Validate the victim count
        if ($this->victim_count < 0) {
            $errors['victim_count'] = 'Please enter a valid victim count';
        }

        // Validate the disease status
        if (!in_array($this->status, self::VALID_STATUSES)) {
            $errors['status'] = 'Please select a valid status';
        }

        // Return the errors array
        return $errors;
    }

    /**
     * Create a new disease record in the database
     *
     * @return int|false The ID of the newly created disease or false on failure
     */
    public function create(): int|false
    {
        // Validate the data before proceeding
        $errors = $this->validate();
        if (!empty($errors)) {
            throw new InvalidArgumentException(json_encode($errors)); // Throw an exception if validation fails
        }

        // SQL query to insert a new disease record
        $sql = "INSERT INTO {$this->table} (
            name, code, category, description, severity_level,
            affected_region, incident_date, victim_count, status,
            history, contact_information
        ) VALUES (
            :name, :code, :category, :description, :severity_level,
            :affected_region, :incident_date, :victim_count, :status,
            :history, :contact_information
        )";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, [
            ':name' => $this->name,
            ':code' => $this->code,
            ':category' => $this->category,
            ':description' => $this->description,
            ':severity_level' => $this->severity_level,
            ':affected_region' => $this->affected_region,
            ':incident_date' => $this->incident_date,
            ':victim_count' => $this->victim_count,
            ':status' => $this->status,
            ':history' => $this->history,
            ':contact_information' => $this->contact_information
        ]);

        // Return the ID of the newly created record
        return $stmt->rowCount() > 0
            ? (int) $this->db->lastInsertId()
            : false;
    }

    /**
     * Update an existing disease record in the database
     *
     * @param int $id The ID of the disease to update
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
            name = :name,
            code = :code,
            category = :category,
            description = :description,
            severity_level = :severity_level,
            affected_region = :affected_region,
            incident_date = :incident_date,
            victim_count = :victim_count,
            status = :status,
            history = :history,
            contact_information = :contact_information
            WHERE id = :id";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, [
            ':id' => $id,
            ':name' => $this->name,
            ':code' => $this->code,
            ':category' => $this->category,
            ':description' => $this->description,
            ':severity_level' => $this->severity_level,
            ':affected_region' => $this->affected_region,
            ':incident_date' => $this->incident_date,
            ':victim_count' => $this->victim_count,
            ':status' => $this->status,
            ':history' => $this->history,
            ':contact_information' => $this->contact_information
        ]);

        // Return true if the update was successful
        return $stmt->rowCount() > 0;
    }

    /**
     * Load a disease record by ID
     *
     * @param int $id The ID of the disease to load
     * @return bool True if the disease was loaded successfully, false otherwise
     */
    public function load(int $id): bool
    {
        // SQL query to retrieve the disease record by ID
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->query($sql, ['id' => $id]);

        // Fetch the disease record
        if ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->setProperties($record);
            return true;
        }

        // Return false if the record was not found
        return false;
    }

    /**
     * Delete a disease record by ID
     *
     * This method deletes the disease record with the specified ID from the database.
     *
     * @param int $id The ID of the disease to delete
     * @return bool True if the disease was deleted successfully, false otherwise
     */
    public function delete(int $id): bool
    {
        // SQL query to delete the disease record by ID
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
    public function getName(): string { return $this->name; }
    public function getCode(): string { return $this->code; }
    public function getCategory(): string { return $this->category; }
    public function getDescription(): string { return $this->description; }
    public function getSeverityLevel(): string { return $this->severity_level; }
    public function getAffectedRegion(): string { return $this->affected_region; }
    public function getIncidentDate(): string { return $this->incident_date; }
    public function getVictimCount(): int { return $this->victim_count; }
    public function getStatus(): string { return $this->status; }
    public function getHistory(): string { return $this->history; }
    public function getContactInformation(): string { return $this->contact_information; }
}