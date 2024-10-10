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

    -- Referral information (for patients referred from other hospitals)
    is_referenced BOOLEAN,                      -- Whether the patient is referred from another hospital
    referral_source VARCHAR(100),               -- Source of referral to the hospital (e.g., self, doctor, other hospital)

    -- Disaster-related information (for disaster patients)
    disaster_type VARCHAR(100),                 -- Type of disaster (e.g., Earthquake, Flood, Epidemic)
    injury_type VARCHAR(100),                   -- Type of injury (e.g., Physical, Psychological, Infectious)

    -- Local status (for disaster patients)
    local_status_range VARCHAR(50),             -- Local status range of the patient (e.g., 00-09, 10-19, 20-29)
    local_status_color VARCHAR(50),             -- Local status color of the patient (e.g., Green, Yellow, Red)
    alergies TEXT,                              -- Known allergies of the patient (e.g., food, medication)

    -- Discovery details (for disaster patients)
    discovery_timestamp DATETIME,               -- Timestamp when the patient was found (Waktu Ditemukan)
    discovery_location VARCHAR(255),            -- Location where the patient was found (Lokasi Ditemukan)

    -- Vital signs and initial assessment (for disaster patients)
    vital_sign_blood_pressure VARCHAR(50),      -- Blood pressure in mmHg (Vital Sign: TD)
    vital_sign_pulse INT,                       -- Pulse rate in beats per minute (Nadi)
    vital_sign_respiratory_rate INT,            -- Respiratory rate in breaths per minute (Respiratory)
    vital_sign_temperature DECIMAL(5, 2),       -- Body temperature in Celsius (Suhu)

    -- Condition status (Kondisi)
    condition_color VARCHAR(50),                -- Condition color code (e.g., P1, P2, P3, P4)

    -- Initial examination (Pemeriksaan Awal)
    pupil_status VARCHAR(50),                   -- Pupil examination status (isokor/arisokor)
    light_reflex_left DECIMAL(5, 2),            -- Light reflex on the left (Reflek Cahaya)
    light_reflex_right DECIMAL(5, 2),           -- Light reflex on the right (Reflek Cahaya)
    airway_c_spine VARCHAR(50),                 -- Airway and C-spine status
    breathing_status VARCHAR(50),               -- Breathing status (Breathing)
    circulation_status VARCHAR(50),             -- Circulation status (Circulation)
    gcs_disability_status VARCHAR(50),          -- Glasgow Coma Scale (Disability GCS)
    exposure_status VARCHAR(50),                -- Exposure status (Eksposure)
    prehospital_status VARCHAR(50),             -- Prehospital care (Prehospital)

    -- Medical details
    anamnesis TEXT,                              -- Patient anamnesis (ANAMNESIS)
    diagnosis TEXT,                              -- Diagnosis of the patient (DIAGNOSIS)
    therapy TEXT,                                -- Therapy that has been given (TERAPI YANG SUDAH DIBERIKAN)
    actions_taken TEXT,                          -- Actions taken (TINDAKAN)

    -- Finder's details
    finder_full_name VARCHAR(100),               -- Full name of the person who found the patient (Identitas Penemu - Nama)
    finder_age INT,                              -- Age of the finder (Umur)
    finder_gender VARCHAR(10),                   -- Gender of the finder (Jenis Kelamin)
    finder_address TEXT,                         -- Address of the finder (Alamat)
    finder_phone_number VARCHAR(20),             -- Phone number of the finder (No Telepon)

    -- Additional confirmation
    confirmation_datetime DATETIME,             -- Date and time of confirmation
    confirmation_issue VARCHAR(255),            -- Issue of confirmation
    confirmation_therapy TEXT,                  -- Therapy after confirmation

    -- Additional information
    status VARCHAR(50) -- Current status of the patient (e.g., Active, Discharged)
);
