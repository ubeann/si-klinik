CREATE TABLE patients (
    -- Information about the patient
    id INT AUTO_INCREMENT PRIMARY KEY,          -- Unique identifier for each patient record
    medical_record_number VARCHAR(8) NOT NULL,  -- Unique medical record number for the patient (max 8 characters)
    registration_date DATE NOT NULL,            -- Date of patient registration
    national_id_number VARCHAR(16) NOT NULL,    -- National identification number (e.g., KTP or Passport)
    full_name VARCHAR(100) NOT NULL,            -- Full name of the patient
    address TEXT NOT NULL,                      -- Full address of the patient
    gender VARCHAR(10) NOT NULL,                -- Gender of the patient (e.g., Male or Female)
    birth_date DATE NOT NULL,                   -- Birth date of the patient
    guarantor VARCHAR(100),                     -- Name of the guarantor (optional, e.g., family member or insurance)
    phone_number VARCHAR(20),                   -- Contact phone number of the patient
    religion VARCHAR(50),                       -- Patient's religion (optional)
    occupation VARCHAR(100),                    -- Patient's occupation (optional)
    education VARCHAR(100),                     -- Educational background of the patient (optional)
    marital_status VARCHAR(50),                 -- Marital status of the patient (e.g., Single, Married)

    -- Information about the patient's medical resume
    initial_diagnosis TEXT,         -- Initial diagnosis at the time of admission
    initial_icd_code VARCHAR(10),   -- ICD code for the initial diagnosis (max 10 characters)
    primary_diagnosis TEXT,         -- Primary diagnosis during the patient's stay
    primary_icd_code VARCHAR(10),   -- ICD code for the primary diagnosis (max 10 characters)
    anamnesis TEXT,                 -- Information gathered from the patient's medical history (anamnesis)
    physical_examination TEXT,      -- Results of the physical examination performed on the patient
    prescribed_medication TEXT,     -- Medications prescribed to the patient
    treatment_or_follow_up TEXT,    -- Information on the treatment or follow-up required

    -- Additional information
    status VARCHAR(50) -- Current status of the patient (e.g., Active, Discharged)
);
