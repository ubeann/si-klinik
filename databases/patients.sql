CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medical_record_number VARCHAR(8) NOT NULL,
    registration_date DATE NOT NULL,
    national_id_number VARCHAR(16) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    gender VARCHAR(10) NOT NULL,
    birth_date DATE NOT NULL,
    guarantor VARCHAR(100),
    phone_number VARCHAR(20),
    religion VARCHAR(50),
    occupation VARCHAR(100),
    education VARCHAR(100),
    marital_status VARCHAR(50),
    status VARCHAR(50)
);
