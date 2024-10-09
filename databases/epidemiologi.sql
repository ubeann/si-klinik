CREATE TABLE epidemiologi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    national_id_number VARCHAR(16) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    age INT NOT NULL,
    address TEXT NOT NULL,
    diagnosis TEXT NOT NULL,
    diagnosis_date DATE NOT NULL
);
