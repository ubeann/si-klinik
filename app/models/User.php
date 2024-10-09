<?php

namespace App\Models;

use PDO;

/**
 * User Model Class
 *
 * Handles user data management, authentication, and password security.
 * This class extends the base Model class and provides functionality for
 * user creation, validation, and password management.
 */
class User extends Model
{
    /** @var string Table name for user records */
    protected string $table = 'users';

    /** @var string User's full name */
    private string $name = '';

    /** @var string User's email address */
    private string $email = '';

    /** @var string User's phone number */
    private string $phoneNumber = '';

    /** @var string User's address */
    private string $address = '';

    /** @var string User's password (hashed when stored) */
    private string $password = '';

    /** @var string User's role in the system */
    private string $role = '';

    /**
     * Defines valid user roles in the system.
     * @var array<string> List of allowed roles
     */
    private const VALID_ROLES = ['admin', 'doctor', 'officer'];

    /**
     * Cost factor for password hashing.
     * Higher values make hashing slower but more secure.
     * Recommended range: 10-12 for production environments.
     * @var int
     */
    private const PASSWORD_COST = 12;

    /**
     * Constructor initializes a new User instance with provided data.
     *
     * @param array<string, mixed> $data Associative array of user data
     *                                   Expected keys: name, email, password, role
     */
    public function __construct(array $data = [])
    {
        parent::__construct();
        $this->setProperties($data);
    }

    /**
     * Safely sets user properties with proper sanitization.
     * This method ensures all incoming data is properly sanitized
     * before being assigned to object properties.
     *
     * @param array<string, mixed> $data User data to be set
     */
    private function setProperties(array $data): void
    {
        // Using null coalescing operator for cleaner default value handling
        $this->name = $this->sanitizeString($data['name'] ?? '');
        $this->email = $this->sanitizeEmail($data['email'] ?? '');
        $this->phoneNumber = $this->sanitizeString($data['phone_number'] ?? '');
        $this->address = $this->sanitizeString($data['address'] ?? '');
        $this->setPassword($data['password'] ?? '');
        $this->role = $this->sanitizeString($data['role'] ?? '');
    }

    /**
     * Sanitize a string input
     *
     * @param string $input Input string to sanitize
     * @return string Sanitized string
     */
    private function sanitizeString(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize an email input
     *
     * @param string $email Email address to sanitize
     * @return string Sanitized email address
     */
    private function sanitizeEmail(string $email): string
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sets the user's password.
     * Note: Password hashing is deferred until actually needed
     * to avoid unnecessary processing.
     *
     * @param string $password Plain text password
     */
    private function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Hashes the password using secure bcrypt algorithm.
     * Only hashes if password is not empty and not already hashed.
     */
    private function hashPassword(): void
    {
        if (empty($this->password) || $this->isPasswordHashed()) {
            return;
        }

        $this->password = password_hash(
            $this->password,
            PASSWORD_BCRYPT,
            ['cost' => self::PASSWORD_COST]
        );
    }

    /**
     * Checks if the current password is already hashed.
     * Validates both length and format of bcrypt hash.
     *
     * @return bool True if password is already hashed
     */
    private function isPasswordHashed(): bool
    {
        return strlen($this->password) === 60 &&
               preg_match('/^\$2[ayb]\$.{56}$/', $this->password);
    }

    /**
     * Verifies if a given plain text password matches the stored hash.
     *
     * @param string $password Plain text password to verify
     * @return bool True if password matches
     */
    public function verifyPassword(string $password): bool
    {
        return !empty($this->password) && password_verify($password, $this->password);
    }

    /**
     * Checks if password needs rehashing based on current security settings.
     *
     * @return bool True if password needs rehash
     */
    public function needsRehash(): bool
    {
        return !empty($this->password) && password_needs_rehash(
            $this->password,
            PASSWORD_BCRYPT,
            ['cost' => self::PASSWORD_COST]
        );
    }

    /**
     * Rehashes password if current hash doesn't meet security requirements.
     * Updates database with new hash if rehashing occurs.
     *
     * @param string $plainPassword Original plain text password
     */
    public function rehashPasswordIfNeeded(string $plainPassword): void
    {
        if ($this->needsRehash()) {
            $this->setPassword($plainPassword);
            $this->hashPassword();
            $this->updatePassword();
        }
    }

    /**
     * Updates password hash in database.
     *
     * @return bool True if update was successful
     */
    private function updatePassword(): bool
    {
        $sql = "UPDATE {$this->table} SET password = :password WHERE email = :email";
        $stmt = $this->query($sql, [
            'password' => $this->password,
            'email' => $this->email
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Validates all user data according to business rules.
     * Performs comprehensive validation of name, email, password, and role.
     *
     * @return array<string, string> Array of validation errors (empty if valid)
     */
    public function validate(): array
    {
        $errors = [];

        // Name validation - letters, spaces, hyphens only, minimum 2 chars
        if (empty($this->name)) {
            $errors['name'] = 'Name is required';
        } elseif (!preg_match('/^[a-zA-Z\s-]{2,}$/', $this->name)) {
            $errors['name'] = 'Name must contain only letters, spaces, and hyphens';
        }

        // Email validation using PHP's built-in filter
        if (empty($this->email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Valid email is required';
        }

        // Password validation - minimum 8 chars if not already hashed
        if (empty($this->password)) {
            $errors['password'] = 'Password is required';
        } elseif (!$this->isPasswordHashed() && strlen($this->password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters long';
        }

        // Role validation against predefined valid roles
        if (empty($this->role)) {
            $errors['role'] = 'Role is required';
        } elseif (!in_array($this->role, self::VALID_ROLES, true)) {
            $errors['role'] = 'Invalid role selected';
        }

        return $errors;
    }

    /**
     * Get the user's full name.
     *
     * @return string User's full name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the user's email address.
     *
     * @return string User's email address
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get the user's phone number.
     *
     * @return string User's phone number
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * Get the user's address.
     *
     * @return string User's address
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Get the user's role.
     *
     * @return string User's role
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Creates a new user record in the database.
     * Performs validation and checks for existing email before creation.
     *
     * @return int|false User ID if successful, false otherwise
     */
    public function create(): int|false
    {
        // Early return if validation fails
        $errors = $this->validate();
        if (!empty($errors)) {
            return false;
        }

        // Early return if email already exists
        if ($this->checkEmailExists()) {
            return false;
        }

        // Ensure password is hashed before saving
        $this->hashPassword();

        // SQL query to insert user data
        $sql = "INSERT INTO {$this->table} (name, email, password, role, phone_number, address)
                VALUES (:name, :email, :password, :role, :phone_number, :address)";

        // Parameters for the query
        $params = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'phone_number' => empty($this->phoneNumber) ? null : $this->phoneNumber,
            'address' => empty($this->address) ? null : $this->address
        ];

        // Execute the query and return the new user ID
        $stmt = $this->query($sql, $params);

        // Return the new user ID if the query was successful
        return $stmt->rowCount() > 0
            ? (int) $this->db->lastInsertId()
            : false;
    }

    /**
     * Loads user data by email address.
     * Useful for authentication and profile lookups.
     *
     * @param string $email Email address to search for
     * @return bool True if user was found and loaded
     */
    public function loadByEmail(string $email): bool
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->query($sql, ['email' => $this->sanitizeEmail($email)]);

        if ($userData = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->setProperties($userData);
            return true;
        }

        return false;
    }

    /**
     * Check if the user's email already exists in the database.
     * Useful for preventing duplicate user records.
     *
     * @return bool True if email already exists
     */
    public function checkEmailExists(): bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
        $stmt = $this->query($sql, ['email' => $this->email]);
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Get all users with optional filtering and pagination
     *
     * @param array $filters Optional filters (role, search)
     * @param int $page Current page number for pagination
     * @param int $perPage Number of records per page
     * @return array An array of users
     */
    public function getAllUsers(array $filters = [], int $page = 1, int $perPage = 10): array
    {
        $conditions = []; // Stores the WHERE conditions for the SQL query
        $params = []; // Stores the parameter values for the query

        // Filter by status if provided
        if (!empty($filters['role'])) {
            $conditions[] = "role = :role";
            $params[':role'] = $filters['role'];
        }

        // Filter by search query if provided (matches full name or medical record number)
        if (!empty($filters['search'])) {
            $conditions[] = "(name LIKE :name OR email LIKE :email)";
            $params[':name'] = "%{$filters['search']}%";
            $params[':email'] = "%{$filters['search']}%";
        }

        // Build the WHERE clause if conditions are set
        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        // Calculate the offset for pagination
        $offset = ($page - 1) * $perPage;

        // SQL query to retrieve the users with optional filters and pagination
        $sql = "SELECT * FROM {$this->table}
                {$whereClause}
                ORDER BY name DESC
                LIMIT :limit OFFSET :offset";

        // Execute the query with the provided parameters
        $stmt = $this->query($sql, array_merge($params, [
            ':limit' => $perPage,
            ':offset' => $offset
        ]));

        // Fetch and return all user records
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the pagination links for the user list
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
        if (!empty($filters['role'])) {
            $conditions[] = "role = :role";
            $params[':role'] = $filters['role'];
        }

        // Filter by search query if provided (matches full name or medical record number)
        if (!empty($filters['search'])) {
            $conditions[] = "(name LIKE :name OR email LIKE :email or phone_number LIKE :phone_number)";
            $params[':name'] = "%{$filters['search']}%";
            $params[':email'] = "%{$filters['search']}%";
            $params[':phone_number'] = "%{$filters['search']}%";
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
                'url' => "?page={$i}&role={$filters['role']}&search={$filters['search']}"
            ];
        }

        return $links;
    }
}