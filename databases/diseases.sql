CREATE TABLE diseases (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- Unique identifier for each disease or disaster record
    name VARCHAR(100) NOT NULL,             -- Name of the disease or disaster
    code VARCHAR(10) NOT NULL,              -- Unique code for the disease or disaster (max 10 characters)
    category VARCHAR(100) NOT NULL,         -- Category of the event: Natural Disaster, Epidemic, or Disease
    description TEXT NOT NULL,              -- Detailed description of the disease or disaster
    severity_level VARCHAR(10) NOT NULL,    -- Severity level: Mild, Moderate, Severe, or Very Severe
    affected_region TEXT NOT NULL,          -- Regions affected by the disease or disaster
    incident_date DATETIME NOT NULL,        -- Date and time when the incident occurred
    victim_count INT NOT NULL,              -- Number of victims affected by the disease or disaster
    status VARCHAR(10) NOT NULL,            -- Current status: Active or Inactive
    history TEXT NOT NULL,                  -- History of the disease or disaster (e.g., previous occurrences and victim counts)
    contact_information TEXT NOT NULL       -- Contact information for further inquiries (phone numbers, etc.)
);
