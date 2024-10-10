CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique identifier for each user record
    name VARCHAR(100) NOT NULL,         -- Full name of the user
    role VARCHAR(50) NOT NULL,          -- User's role (e.g., Admin, Doctor, Officer)
    email VARCHAR(100) NOT NULL,        -- User's email address for login and communication
    phone_number VARCHAR(20),           -- User's phone number (optional)
    address TEXT,                       -- User's full address (optional)
    password VARCHAR(100) NOT NULL      -- User's encrypted password for authentication
);
