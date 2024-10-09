CREATE TABLE patients (
    -- Information about the patient
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

    -- Information about the patient's resumes
    initial_diagnosis TEXT,
    initial_icd_code VARCHAR(10),
    primary_diagnosis TEXT,
    primary_icd_code VARCHAR(10),
    anamnesis TEXT,
    physical_examination TEXT,
    prescribed_medication TEXT,
    treatment_or_follow_up TEXT,

    -- Additional information
    status VARCHAR(50)
);
