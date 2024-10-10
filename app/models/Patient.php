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

    // Referral information attributes
    private bool $isReferenced = false;
    private string $referralSource = '';

    // Disaster medical records attributes
    private string $disasterType = '';
    private string $injuryType = '';

    // Local status attributes
    private string $localStatusRange = '';
    private string $localStatusColor = '';
    private string $allergies = '';

    // Discovery details attributes
    private string $discoveryTimestamp = '';
    private string $discoveryLocation = '';

    // Vital signs and initial assessment attributes
    private string $vitalSignBloodPressure = '';
    private int $vitalSignPulse = 0;
    private int $vitalSignRespiratoryRate = 0;
    private float $vitalSignTemperature = 0.0;

    // Condition status attributes
    private string $conditionColor = '';

    // Initial examination attributes
    private string $pupilStatus = '';
    private float $lightReflexLeft = 0.0;
    private float $lightReflexRight = 0.0;
    private string $airwayCSpine = '';
    private string $breathingStatus = '';
    private string $circulationStatus = '';
    private string $gcsDisabilityStatus = '';
    private string $exposureStatus = '';
    private string $prehospitalStatus = '';

    // Medical details attributes
    private string $anamnesis = '';
    private string $diagnosis = '';
    private string $therapy = '';
    private string $actionsTaken = '';

    // Finder's details attributes
    private string $finderFullName = '';
    private int $finderAge = 0;
    private string $finderGender = '';
    private string $finderAddress = '';
    private string $finderPhoneNumber = '';

    // Additional confirmation attributes
    private string $confirmationDatetime = '';
    private string $confirmationIssue = '';
    private string $confirmationTherapy = '';

    // Constants for valid field values
    private const VALID_GENDERS = ['l', 'p']; // Valid gender options
    private const VALID_RELIGIONS = ['islam', 'catholic', 'protestant', 'hindu', 'buddha', 'other']; // Valid religion options
    private const VALID_EDUCATION_LEVELS = ['sd', 'smp', 'sma', 'd1', 'd2', 'd3', 'd4', 's1', 's2', 's3']; // Valid education levels
    private const VALID_MARITAL_STATUS = ['single', 'married', 'divorced', 'widowed']; // Valid marital status options
    private const VALID_STATUS = ['not-filled', 'incomplete', 'complete']; // Valid status options

    // Constants for valid field values for referral information
    private const VALID_REFERRAL_SOURCES = [
        'hospital',         // RS (Rumah Sakit)
        'clinic',           // Pusk (Puskesmas)
        'doctor',           // Dr (Dokter)
        'midwife',          // Bidan
        'nurse',            // Perawat
        'emergency_rj_rsd', // RJ-RSD (Emergency room)
        'rna',              // RNA (Rawat Naik Ambulan)
        'sds',              // SDS (Sarana Darurat Siaga)
        'other'             // Lain-lain (Other)
    ];

    // Constants for valid field values for disaster medical records
    private const VALID_DISASTER_TYPES = [
        'earthquake',       // Gempa Bumi
        'tsunami',          // Tsunami
        'flood',            // Banjir
        'landslide',        // Tanah Longsor
        'fire',             // Kebakaran
        'epidemic',         // Wabah
        'other'             // Lain-lain (Other)
    ];
    private const VALID_INJURY_TYPES = [
        'blunt_force',      // Tumpul (Blunt force)
        'sharp_object',     // Tajam (Sharp object)
        'gunshot',          // Peluru (Gunshot)
        'burn',             // Bakar (Burn)
        'poisoning',        // Keracunan (Poisoning)
        'drowning',         // Tenggelam (Drowning)
        'asphyxia',         // Afiksia (Asphyxia)
        'other'             // Other (Lain-lain)
    ];

    // Constants for valid field values for local status
    private const VALID_LOCAL_STATUS_RANGE = [
        '00-09',            // 00-09
        '10-19',            // 10-19
        '20-29',            // 20-29
        '30-39',            // 30-39
        '40-49',            // 40-49
        '50-59',            // 50-59
        '60-69',            // 60-69
        '70-79',            // 70-79
        '80-89',            // 80-89
        '90-99'             // 90-99
    ];
    private const VALID_LOCAL_STATUS_COLORS = [
        'green',            // Hijau (Green)
        'yellow',           // Kuning (Yellow)
        'red',              // Merah (Red)
        'black',            // Hitam (Black)
        'white',            // Putih (White)
        'blue',             // Biru (Blue)
        'orange',           // Oranye (Orange)
        'other'             // Lain-lain (Other)
    ];

    // Constants for valid field values for condition status
    private const VALID_CONDITION_COLORS = [
        'P1',               // P1 (Gawat dan Darurat)
        'P2',               // P2 (Gawat dan Tidak Darurat)
        'P3',               // P3 (Tidak Gawat dan Tidak Darurat)
        'P4',               // P4 (Meninggal)
    ];

    // Constants for valid field values for initial examination
    private const VALID_PUPIL_STATUS = [
        'isokor',           // Isokor
        'anisokor',         // Anisokor
        'miotic',           // Miotik
        'mydriatic',        // Midriatik
        'other'             // Lain-lain (Other)
    ];
    private const VALID_AIRWAY_CSPINE = [
        'clear',            // Jernih (Bersih)
        'sputum',           // Sputum (Slem Sumbatan)
        'partial',          // Parsial (Partial)
        'total',            // Total (Sumbatan Total)
        'other'             // Lain-lain (Other)
    ];
    private const VALID_BREATHING_STATUS = [
        'normal',               // Normal
        'wheezing',             // Wheezing
        'ronchi',               // Ronchi
        'retraction',           // Retraksi
        'nasal-flaring',        // Nasal Flaring
        'abnormal-position',    // Posisi Abnormal
    ];
    private const VALID_CIRCULATION_STATUS = [
        'pallor',               // Pucat (Pallor)
        'mottling',             // Motling
        'cyanosis',             // Sianosis (Cyanosis)
        'capillary-refill',     // Capillary Refill
    ];
    private const VALID_GCS_DISABILITY_STATUS = [
        'eye-movement',         // Gerakan Mata (Eye Movement)
        'motor-reflex',         // Reflek Motorik (Motor Reflex)
        'verbal'                // Verbal
    ];
    private const VALID_EXPOSURE_STATUS = [
        'bleeding',             // Pendarahan (Bleeding)
        'fracture',             // Fraktur (Fracture)
        'paralysis',            // Parase (Paralysis)
        'plegia',               // Plegi (Plegia)
        'paraparesis'           // Paraperesis
    ];
    private const VALID_PREHOSPITAL_STATUS = [
        'rjp',                  // RJP (Resusitasi Jantung Paru)
        'intubasi',             // Intubasi
        'oksigen',              // Oksigen
        'ecollar',              // Ecollar
        'balut',                // Balut/Bi
        'obat'                  // Obat
    ];


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
     * Set patient resume properties from an array of data
     *
     * @param array $data Associative array of patient resume data
     */
    public function setResumeProperties(array $data): void
    {
        // Set each patient resume attribute after sanitizing the input data
        $this->isReferenced = isset($data['is_referenced']);
        $this->referralSource = strtolower($this->sanitizeString($data['referral_source'] ?? ''));
        $this->disasterType = strtolower($this->sanitizeString($data['disaster_type'] ?? ''));
        $this->injuryType = strtolower($this->sanitizeString($data['injury_type'] ?? ''));
        $this->localStatusRange = strtolower($this->sanitizeString($data['local_status_range'] ?? ''));
        $this->localStatusColor = strtolower($this->sanitizeString($data['local_status_color'] ?? ''));
        $this->allergies = $this->sanitizeString($data['allergies'] ?? '');
        $this->discoveryTimestamp = $data['discovery_timestamp'] ?? '';
        $this->discoveryLocation = $this->sanitizeString($data['discovery_location'] ?? '');
        $this->vitalSignBloodPressure = $this->sanitizeString($data['vital_sign_blood_pressure'] ?? '');
        $this->vitalSignPulse = (int) ($data['vital_sign_pulse'] ?? 0);
        $this->vitalSignRespiratoryRate = (int) ($data['vital_sign_respiratory_rate'] ?? 0);
        $this->vitalSignTemperature = (float) ($data['vital_sign_temperature'] ?? 0.0);
        $this->conditionColor = strtolower($this->sanitizeString($data['condition_color'] ?? ''));
        $this->pupilStatus = strtolower($this->sanitizeString($data['pupil_status'] ?? ''));
        $this->lightReflexLeft = (float) ($data['light_reflex_left'] ?? 0.0);
        $this->lightReflexRight = (float) ($data['light_reflex_right'] ?? 0.0);
        $this->airwayCSpine = strtolower($this->sanitizeString($data['airway_cspine'] ?? ''));
        $this->breathingStatus = strtolower($this->sanitizeString($data['breathing_status'] ?? ''));
        $this->circulationStatus = strtolower($this->sanitizeString($data['circulation_status'] ?? ''));
        $this->gcsDisabilityStatus = strtolower($this->sanitizeString($data['gcs_disability_status'] ?? ''));
        $this->exposureStatus = strtolower($this->sanitizeString($data['exposure_status'] ?? ''));
        $this->prehospitalStatus = strtolower($this->sanitizeString($data['prehospital_status'] ?? ''));
        $this->anamnesis = $this->sanitizeString($data['anamnesis'] ?? '');
        $this->diagnosis = $this->sanitizeString($data['diagnosis'] ?? '');
        $this->therapy = $this->sanitizeString($data['therapy'] ?? '');
        $this->actionsTaken = $this->sanitizeString($data['actions_taken'] ?? '');
        $this->finderFullName = $this->sanitizeString($data['finder_full_name'] ?? '');
        $this->finderAge = (int) ($data['finder_age'] ?? 0);
        $this->finderGender = strtolower($this->sanitizeString($data['finder_gender'] ?? ''));
        $this->finderAddress = $this->sanitizeString($data['finder_address'] ?? '');
        $this->finderPhoneNumber = $this->sanitizeString($data['finder_phone_number'] ?? '');
        $this->confirmationDatetime = $data['confirmation_datetime'] ?? '';
        $this->confirmationIssue = $this->sanitizeString($data['confirmation_issue'] ?? '');
        $this->confirmationTherapy = $this->sanitizeString($data['confirmation_therapy'] ?? '');
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
     * Validate patient resume data
     *
     * @return array<string, string> Array of validation errors if any
     */
    public function validateResume(): array
    {
        $errors = [];

        // Validate referral information
        if (empty($this->isReferenced)) {
            $errors['referral']['is_referenced'] = 'Silahkan pilih pasien dirujuk atau tidak.';
        }
        if (!in_array($this->referralSource, self::VALID_REFERRAL_SOURCES, true)) {
            $errors['referral']['referral_source'] = 'Keterangan atau sumber rujukan tidak valid, silahkan pilih opsi yang tersedia.';
        }

        // Validate disaster medical records
        if (!in_array($this->disasterType, self::VALID_DISASTER_TYPES, true)) {
            $errors['disaster']['disaster_type'] = 'Jenis bencana tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (!in_array($this->injuryType, self::VALID_INJURY_TYPES, true)) {
            $errors['disaster']['injury_type'] = 'Jenis cedera tidak valid, silahkan pilih opsi yang tersedia.';
        }

        // Validate local status
        if (!in_array($this->localStatusRange, self::VALID_LOCAL_STATUS_RANGE, true)) {
            $errors['medical']['local_status_range'] = 'Lokal status tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (!in_array($this->localStatusColor, self::VALID_LOCAL_STATUS_COLORS, true)) {
            $errors['medical']['local_status_color'] = 'Warna lokal status tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (empty($this->allergies)) {
            $errors['medical']['allergies'] = "Alergi tidak boleh kosong, silahkan isi dengan informasi yang sesuai atau '-' jika tidak ada.";
        }

        // Validate discovery details
        if (empty($this->discoveryTimestamp)) {
            $errors['discovery']['timestamp'] = 'Waktu penemuan tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        } else {
            try {
                $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $this->discoveryTimestamp);
                if ($dateTime === false) {
                    throw new Exception();
                } else if ($dateTime > new DateTime()) {
                    $errors['discovery']['timestamp'] = 'Waktu penemuan tidak boleh di masa depan.';
                }
            } catch (\Exception $e) {
                $errors['discovery']['timestamp'] = 'Format waktu penemuan tidak valid, silahkan gunakan format YYYY-MM-DDTHH:MM.';
            }
        }
        if (empty($this->discoveryLocation)) {
            $errors['discovery']['location'] = 'Lokasi penemuan tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }

        // Validate vital signs
        if (empty($this->vitalSignBloodPressure)) {
            $errors['vital_sign']['blood_pressure'] = 'Tekanan darah tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }
        if ($this->vitalSignPulse < 20 || $this->vitalSignPulse > 250) {
            $errors['vital_sign']['pulse'] = 'Denyut nadi harus berada di antara 20-250 bpm. Nilai normal adalah 60-100 bpm.';
        }
        if ($this->vitalSignRespiratoryRate < 4 || $this->vitalSignRespiratoryRate > 60) {
            $errors['vital_sign']['respiratory_rate'] = 'Frekuensi pernapasan harus berada di antara 4-60 x/menit. Nilai normal adalah 12-20 x/menit.';
        }
        if ($this->vitalSignTemperature < 32 || $this->vitalSignTemperature > 42) {
            $errors['vital_sign']['temperature'] = 'Suhu tubuh harus berada di antara 32-42°C. Nilai normal adalah 36.5-37.5°C.';
        }

        // Validate condition patient
        if (!in_array($this->conditionColor, self::VALID_CONDITION_COLORS, true)) {
            $errors['patient']['condition_color'] = 'Warna kondisi pasien tidak valid, silahkan pilih opsi yang tersedia.';
        }

        // Validate initial examination
        if (!in_array($this->pupilStatus, self::VALID_PUPIL_STATUS, true)) {
            $errors['examination']['pupil_status'] = 'Status pupil tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if ($this->lightReflexLeft < 0 || $this->lightReflexLeft > 10) {
            $errors['examination']['light_reflex_left'] = 'Refleks cahaya kiri harus berada di antara 0-10 mm. Nilai normal adalah 2-4 mm.';
        }
        if ($this->lightReflexRight < 0 || $this->lightReflexRight > 10) {
            $errors['examination']['light_reflex_right'] = 'Refleks cahaya kanan harus berada di antara 0-10 mm. Nilai normal adalah 2-4 mm.';
        }
        if (!in_array($this->airwayCSpine, self::VALID_AIRWAY_CSPINE, true)) {
            $errors['examination']['airway_cspine'] = 'Airway C-Spine tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (!in_array($this->breathingStatus, self::VALID_BREATHING_STATUS, true)) {
            $errors['examination']['breathing_status'] = 'Kondisi pernapasan tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (!in_array($this->circulationStatus, self::VALID_CIRCULATION_STATUS, true)) {
            $errors['examination']['circulation_status'] = 'Kondisi sirkulasi tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (!in_array($this->gcsDisabilityStatus, self::VALID_GCS_DISABILITY_STATUS, true)) {
            $errors['examination']['gcs_disability_status'] = 'Status disabilitas GCS tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (!in_array($this->exposureStatus, self::VALID_EXPOSURE_STATUS, true)) {
            $errors['examination']['exposure_status'] = 'Status eksposur tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (!in_array($this->prehospitalStatus, self::VALID_PREHOSPITAL_STATUS, true)) {
            $errors['examination']['prehospital_status'] = 'Status pra-rumah sakit tidak valid, silahkan pilih opsi yang tersedia.';
        }

        // Validate medical details
        if (empty($this->anamnesis)) {
            $errors['medical_details']['anamnesis'] = 'Anamnesis tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }
        if (empty($this->diagnosis)) {
            $errors['medical_details']['diagnosis'] = 'Diagnosis tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }
        if (empty($this->therapy)) {
            $errors['medical_details']['therapy'] = 'Terapi tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }
        if (empty($this->actionsTaken)) {
            $errors['medical_details']['actions_taken'] = 'Tindakan yang diambil tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }

        // Validate finder's details
        if (empty($this->finderFullName)) {
            $errors['finder']['full_name'] = 'Nama penemu tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }
        if ($this->finderAge < 0 || $this->finderAge > 120) {
            $errors['finder']['age'] = 'Usia penemu harus berada di antara 0-120 tahun.';
        }
        if (!in_array($this->finderGender, self::VALID_GENDERS, true)) {
            $errors['finder']['gender'] = 'Jenis kelamin penemu tidak valid, silahkan pilih opsi yang tersedia.';
        }
        if (empty($this->finderAddress)) {
            $errors['finder']['address'] = 'Alamat penemu tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }
        if (!preg_match('/^\+?[\d-]{10,15}$/', $this->finderPhoneNumber)) {
            $errors['finder']['phone_number'] = 'Nomor telepon penemu tidak valid, silahkan isi dengan informasi yang sesuai. Contoh: 081234567890.';
        }

        // Validate additional confirmation
        if (empty($this->confirmationDatetime)) {
            $errors['confirmation']['datetime'] = 'Tanggal dan Waktu tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        } else {
            try {
                $confirmationDatetime = DateTime::createFromFormat('Y-m-d\TH:i', $this->confirmationDatetime);
                if ($confirmationDatetime === false) {
                    throw new Exception();
                } else if ($confirmationDatetime > new DateTime()) {
                    $errors['confirmation']['datetime'] = 'Tanggal dan waktu konfirmasi tidak boleh di masa depan.';
                }
            } catch (\Exception $e) {
                $errors['confirmation']['datetime'] = 'Format tanggal dan waktu tidak valid.';
            }
        }
        if (empty($this->confirmationIssue)) {
            $errors['confirmation']['issue'] = 'Masalah tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }
        if (empty($this->confirmationTherapy)) {
            $errors['confirmation']['therapy'] = 'Terapi tidak boleh kosong, silahkan isi dengan informasi yang sesuai.';
        }

        // Return any validation errors found
        return $errors;
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
            $this->setResumeProperties($patientData);
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
    public function getIsReferenced(): bool { return $this->isReferenced; }
    public function getReferralSource(): string { return $this->referralSource; }
    public function getDisasterType(): string { return $this->disasterType; }
    public function getInjuryType(): string { return $this->injuryType; }
    public function getLocalStatusRange(): string { return $this->localStatusRange; }
    public function getLocalStatusColor(): string { return $this->localStatusColor; }
    public function getAllergies(): string { return $this->allergies; }
    public function getDiscoveryTimestamp(): string { return $this->discoveryTimestamp; }
    public function getDiscoveryLocation(): string { return $this->discoveryLocation; }
    public function getVitalSignBloodPressure(): string { return $this->vitalSignBloodPressure; }
    public function getVitalSignPulse(): int { return $this->vitalSignPulse; }
    public function getVitalSignRespiratoryRate(): int { return $this->vitalSignRespiratoryRate; }
    public function getVitalSignTemperature(): float { return $this->vitalSignTemperature; }
    public function getConditionColor(): string { return $this->conditionColor; }
    public function getPupilStatus(): string { return $this->pupilStatus; }
    public function getLightReflexLeft(): float { return $this->lightReflexLeft; }
    public function getLightReflexRight(): float { return $this->lightReflexRight; }
    public function getAirwayCSpine(): string { return $this->airwayCSpine; }
    public function getBreathingStatus(): string { return $this->breathingStatus; }
    public function getCirculationStatus(): string { return $this->circulationStatus; }
    public function getGcsDisabilityStatus(): string { return $this->gcsDisabilityStatus; }
    public function getExposureStatus(): string { return $this->exposureStatus; }
    public function getPrehospitalStatus(): string { return $this->prehospitalStatus; }
    public function getAnamnesis(): string { return $this->anamnesis; }
    public function getDiagnosis(): string { return $this->diagnosis; }
    public function getTherapy(): string { return $this->therapy; }
    public function getActionsTaken(): string { return $this->actionsTaken; }
    public function getFinderFullName(): string { return $this->finderFullName; }
    public function getFinderAge(): int { return $this->finderAge; }
    public function getFinderGender(): string { return $this->finderGender; }
    public function getFinderAddress(): string { return $this->finderAddress; }
    public function getFinderPhoneNumber(): string { return $this->finderPhoneNumber; }
    public function getConfirmationDatetime(): string { return $this->confirmationDatetime; }
    public function getConfirmationIssue(): string { return $this->confirmationIssue; }
    public function getConfirmationTherapy(): string { return $this->confirmationTherapy; }
}
