<?php

namespace App\Models;

use DateTime;
use InvalidArgumentException;
use PDO;

class Patient extends Model
{
    protected string $table = 'patients'; // The name of the database table

    // Patient attributes
    private string $medicalRecordNumber = '';
    private string $registrationDate = '';
    private string $nationalIdNumber = '';
    private string $fullName = '';
    private string $address = '';
    private string $gender = '';
    private string $birthDate = '';
    private string $guarantor = '';
    private string $phoneNumber = '';
    private string $religion = '';
    private string $occupation = '';
    private string $education = '';
    private string $maritalStatus = '';
    private string $status = 'active'; // Default status is 'active'

    // Constants for valid field values
    private const VALID_GENDERS = ['l', 'p']; // Valid gender options
    private const VALID_RELIGIONS = ['islam', 'catholic', 'protestant', 'hindu', 'buddha', 'other']; // Valid religion options
    private const VALID_EDUCATION_LEVELS = ['sd', 'smp', 'sma', 'd1', 'd2', 'd3', 'd4', 's1', 's2', 's3']; // Valid education levels
    private const VALID_MARITAL_STATUS = ['single', 'married', 'divorced', 'widowed']; // Valid marital status options
    private const VALID_STATUS = ['not-filled', 'incomplete', 'complete']; // Valid status options

    /**
     * Get all patients with optional filtering and pagination
     *
     * @param array $filters Optional filters (status, search)
     * @param int $page Current page number for pagination
     * @param int $perPage Number of records per page
     * @return array An array of patients
     */
    public function getAllPatients(array $filters = [], int $page = 1, int $perPage = 10): array
    {
        $conditions = []; // Stores the WHERE conditions for the SQL query
        $params = []; // Stores the parameter values for the query

        // Filter by status if provided
        if (!empty($filters['status'])) {
            $conditions[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        // Filter by search query if provided (matches full name or medical record number)
        if (!empty($filters['search'])) {
            $conditions[] = "(full_name LIKE :name OR medical_record_number LIKE :number)";
            $params[':name'] = "%{$filters['search']}%";
            $params[':number'] = "%{$filters['search']}%";
        }

        // Build the WHERE clause if conditions are set
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        // Calculate the offset for pagination
        $offset = ($page - 1) * $perPage;

        // SQL query to retrieve the patients with optional filters and pagination
        $sql = "SELECT * FROM {$this->table}
                {$whereClause}
                ORDER BY registration_date DESC
                LIMIT :limit OFFSET :offset";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, array_merge($params, [
            ':limit' => $perPage,
            ':offset' => $offset
        ]));

        // Fetch and return all patient records
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the pagination links for the patient list
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

        // Filter by search query if provided (matches full name or medical record number)
        if (!empty($filters['search'])) {
            $conditions[] = "(full_name LIKE :name OR medical_record_number LIKE :number)";
            $params[':name'] = "%{$filters['search']}%";
            $params[':number'] = "%{$filters['search']}%";
        }

        // Build the WHERE clause if conditions are set
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        // SQL query to count the total number of patients
        $sql = "SELECT COUNT(*) FROM {$this->table} {$whereClause}";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, $params);

        // Get the total number of patients
        $totalPatients = $stmt->fetchColumn();

        // Calculate the total number of pages
        $totalPages = ceil($totalPatients / $perPage);

        // Generate the pagination links
        $links = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $links[] = [
                'page' => $i,
                'url' => "?page={$i}&status={$filters['status']}&search={$filters['search']}"
            ];
        }

        return $links;
    }

    /**
     * Set patient properties from an array of data
     *
     * @param array $data Associative array of patient data
     */
    public function setProperties(array $data): void
    {
        // Set each patient attribute after sanitizing the input data
        $this->medicalRecordNumber = $this->sanitizeString($data['medical_record_number'] ?? '');
        $this->registrationDate = $data['registration_date'] ?? date('Y-m-d');
        $this->nationalIdNumber = $this->sanitizeString($data['national_id_number'] ?? '');
        $this->fullName = $this->sanitizeString($data['full_name'] ?? '');
        $this->address = $this->sanitizeString($data['address'] ?? '');
        $this->gender = strtolower($this->sanitizeString($data['gender'] ?? ''));
        $this->birthDate = $data['birth_date'] ?? '';
        $this->guarantor = $this->sanitizeString($data['guarantor'] ?? '');
        $this->phoneNumber = $this->sanitizeString($data['phone_number'] ?? '');
        $this->religion = strtolower($this->sanitizeString($data['religion'] ?? ''));
        $this->occupation = $this->sanitizeString($data['occupation'] ?? '');
        $this->education = strtolower($this->sanitizeString($data['education'] ?? ''));
        $this->maritalStatus = strtolower($this->sanitizeString($data['marital_status'] ?? ''));
        $this->status = strtolower($this->sanitizeString($data['status'] ?? 'not-filled'));
    }

    /**
     * Validate patient data
     *
     * @return array<string, string> Array of validation errors if any
     */
    public function validate(): array
    {
        $errors = [];

        // Medical Record Number validation
        if (empty($this->medicalRecordNumber)) {
            $errors['medical_record_number'] = 'Medical Record Number is required';
        } elseif (!preg_match('/^[A-Z0-9-]+$/', $this->medicalRecordNumber)) {
            $errors['medical_record_number'] = 'Invalid Medical Record Number format';
        }

        // Full Name validation
        if (empty($this->fullName)) {
            $errors['full_name'] = 'Full Name is required';
        }

        // National ID Number validation (must be 16 digits if provided)
        if (!empty($this->nationalIdNumber) && !preg_match('/^\d{16}$/', $this->nationalIdNumber)) {
            $errors['national_id_number'] = 'National ID Number must be 16 digits';
        }

        // Date validation for birth date and registration date
        try {
            $regDate = new DateTime($this->registrationDate); // Parse registration date
            $birthDate = new DateTime($this->birthDate); // Parse birth date

            // Birth date cannot be in the future
            if ($birthDate > new DateTime()) {
                $errors['birth_date'] = 'Birth date cannot be in the future';
            }

            // Registration date cannot be in the future
            if ($regDate > new DateTime()) {
                $errors['registration_date'] = 'Registration date cannot be in the future';
            }
        } catch (\Exception $e) {
            $errors['date'] = 'Invalid date format';
        }

        // Validate gender
        if (!in_array($this->gender, self::VALID_GENDERS, true)) {
            $errors['gender'] = 'Invalid gender selected';
        }

        // Validate religion
        if (!in_array($this->religion, self::VALID_RELIGIONS, true)) {
            $errors['religion'] = 'Invalid religion selected';
        }

        // Validate education level
        if (!in_array($this->education, self::VALID_EDUCATION_LEVELS, true)) {
            $errors['education'] = 'Invalid education level selected';
        }

        // Validate marital status
        if (!in_array($this->maritalStatus, self::VALID_MARITAL_STATUS, true)) {
            $errors['marital_status'] = 'Invalid marital status selected';
        }

        // Validate status
        if (!in_array($this->status, self::VALID_STATUS, true)) {
            $errors['status'] = 'Invalid status selected';
        }

        // Phone number validation
        if (!empty($this->phoneNumber) && !preg_match('/^\+?[\d-]{10,15}$/', $this->phoneNumber)) {
            $errors['phone_number'] = 'Invalid phone number format';
        }

        return $errors; // Return any validation errors found
    }

    /**
     * Create a new patient record in the database
     *
     * @return int|false The ID of the newly created patient or false on failure
     */
    public function create(): int|false
    {
        // Validate the data before proceeding
        $errors = $this->validate();
        if (!empty($errors)) {
            throw new InvalidArgumentException(json_encode($errors)); // Throw an exception if validation fails
        }

        // SQL query to insert a new patient record
        $sql = "INSERT INTO {$this->table} (
            medical_record_number, registration_date, national_id_number,
            full_name, address, gender, birth_date, guarantor, phone_number,
            religion, occupation, education, marital_status, status
        ) VALUES (
            :mrn, :reg_date, :national_id, :full_name, :address, :gender,
            :birth_date, :guarantor, :phone, :religion, :occupation,
            :education, :marital_status, :status
        )";

        // Execute the query with the patient data
        $stmt = $this->query($sql, [
            'mrn' => $this->medicalRecordNumber,
            'reg_date' => $this->registrationDate,
            'national_id' => $this->nationalIdNumber,
            'full_name' => $this->fullName,
            'address' => $this->address,
            'gender' => $this->gender,
            'birth_date' => $this->birthDate,
            'guarantor' => $this->guarantor,
            'phone' => $this->phoneNumber,
            'religion' => $this->religion,
            'occupation' => $this->occupation,
            'education' => $this->education,
            'marital_status' => $this->maritalStatus,
            'status' => $this->status
        ]);

        return $stmt->rowCount() > 0
            ? (int) $this->db->lastInsertId()
            : false;
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

    /**
     * Update an existing patient record in the database
     *
     * @param int $id The ID of the patient to update
     * @return bool True if the update was successful, false otherwise
     */
    public function update(int $id): bool
    {
        $errors = $this->validate();
        if (!empty($errors)) {
            throw new InvalidArgumentException(json_encode($errors));
        }

        $sql = "UPDATE {$this->table} SET
            medical_record_number = :mrn,
            registration_date = :reg_date,
            national_id_number = :national_id,
            full_name = :full_name,
            address = :address,
            gender = :gender,
            birth_date = :birth_date,
            guarantor = :guarantor,
            phone_number = :phone,
            religion = :religion,
            occupation = :occupation,
            education = :education,
            marital_status = :marital_status,
            status = :status
            WHERE id = :id";

        $stmt = $this->query($sql, [
            'mrn' => $this->medicalRecordNumber,
            'reg_date' => $this->registrationDate,
            'national_id' => $this->nationalIdNumber,
            'full_name' => $this->fullName,
            'address' => $this->address,
            'gender' => $this->gender,
            'birth_date' => $this->birthDate,
            'guarantor' => $this->guarantor,
            'phone' => $this->phoneNumber,
            'religion' => $this->religion,
            'occupation' => $this->occupation,
            'education' => $this->education,
            'marital_status' => $this->maritalStatus,
            'status' => $this->status,
            'id' => $id
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Load a patient record by ID
     *
     * @param int $id The ID of the patient to load
     * @return bool True if the patient was loaded successfully, false otherwise
     */
    public function load(int $id): bool
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->query($sql, ['id' => $id]);

        if ($patientData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->setProperties($patientData);
            return true;
        }

        return false;
    }

    /**
     * Delete a patient record by ID
     *
     * This method deletes the patient record with the specified ID from the database.
     *
     * @param int $id The ID of the patient to delete
     * @return bool True if the patient was deleted successfully, false otherwise
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->query($sql, ['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Get the age of the patient based on the birth date
     *
     * @return int|null The age of the patient or null if the birth date is not set
     */
    public function getAge(): ?int
    {
        if (empty($this->birthDate)) {
            return null;
        }

        $birth = new DateTime($this->birthDate);
        $today = new DateTime();

        return $birth->diff($today)->y;
    }

    // Getters
    public function getMedicalRecordNumber(): string { return $this->medicalRecordNumber; }
    public function getRegistrationDate(): string { return $this->registrationDate; }
    public function getNationalIdNumber(): string { return $this->nationalIdNumber; }
    public function getFullName(): string { return $this->fullName; }
    public function getAddress(): string { return $this->address; }
    public function getGender(): string { return $this->gender; }
    public function getBirthDate(): string { return $this->birthDate; }
    public function getGuarantor(): string { return $this->guarantor; }
    public function getPhoneNumber(): string { return $this->phoneNumber; }
    public function getReligion(): string { return $this->religion; }
    public function getOccupation(): string { return $this->occupation; }
    public function getEducation(): string { return $this->education; }
    public function getMaritalStatus(): string { return $this->maritalStatus; }
    public function getStatus(): string { return $this->status; }
}
