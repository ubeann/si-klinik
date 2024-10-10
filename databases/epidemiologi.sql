CREATE TABLE epidemiologi (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Unique identifier for each patient record
    full_name VARCHAR(100) NOT NULL,            -- Full name of the patient
    national_id_number VARCHAR(16) NOT NULL,    -- National identification number (e.g., KTP or Passport)
    gender VARCHAR(10) NOT NULL,                -- Gender of the patient (e.g., Male or Female)
    age INT NOT NULL,                           -- Age of the patient
    address TEXT NOT NULL,                      -- Full address of the patient
    diagnosis TEXT NOT NULL,                    -- Medical diagnosis for the patient
    diagnosis_date DATE NOT NULL                -- Date when the diagnosis was made
);
