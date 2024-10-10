<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Rekam Medis Bencana</title>
    <link rel="stylesheet" href="<?= asset('css/resume/form.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;">Form Rekam Medis Bencana: <?= $patient->getMedicalRecordNumber() ?></h1>
        <form method="POST" action="<?= route('resume/save?id=' . $id) ?>">
            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-user"></i>&nbsp;
                    Data Pasien
                </h2>
                <div class="row">
                    <label>No. RM:</label><input disabled type="text" value="<?= $patient->getMedicalRecordNumber() ?>">
                </div>
                <div class="row">
                    <label>Nama pasien</label><input disabled type="text" value="<?= $patient->getFullName() ?>">
                </div>
                <div class="row">
                    <label>Tanggal lahir</label><input disabled type="text" value="<?= $patient->getBirthDate() ?>">
                </div>
                <div class="row">
                    <label>Jenis Kelamin</label><input disabled type="text" value="<?= $patient->getGender() === 'l' ? 'Laki-laki' : 'Perempuan' ?>">
                </div>
                <div class="row">
                    <label>Alamat</label><input disabled type="text" value="<?= $patient->getAddress() ?>">
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-notes-medical"></i>&nbsp;
                    Informasi Rujukan
                </h2>
                <?php if (isset($_SESSION['errors']['referral'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['referral'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <div class="row">
                    <label for="is_referenced">Rujukan</label>
                    <select required name="is_referenced" id="is_referenced" style="border-color: <?= isset($_SESSION['errors']['referral']['is_referenced']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Rujukan --</option>
                        <option value="1" <?= $patient->getIsReferenced() ? 'selected' : '' ?>>Ya</option>
                        <option value="0" <?= $patient->getIsReferenced() ? 'selected' : '' ?>>Tidak</option>
                    </select>
                </div>
                <div class="row">
                    <label for="referral_source">Keterangan</label>
                    <select required name="referral_source" id="referral_source" style="border-color: <?= isset($_SESSION['errors']['referral']['referral_source']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Keterangan --</option>
                        <option value="hospital" <?= $patient->getReferralSource() === 'hospital' ? 'selected' : '' ?>>RS (Rumah Sakit)</option>
                        <option value="clinic" <?= $patient->getReferralSource() === 'clinic' ? 'selected' : '' ?>>Pusk (Puskesmas)</option>
                        <option value="doctor" <?= $patient->getReferralSource() === 'doctor' ? 'selected' : '' ?>>Dr (Dokter)</option>
                        <option value="midwife" <?= $patient->getReferralSource() === 'midwife' ? 'selected' : '' ?>>Bidan</option>
                        <option value="nurse" <?= $patient->getReferralSource() === 'nurse' ? 'selected' : '' ?>>Perawat</option>
                        <option value="emergency_rj_rsd" <?= $patient->getReferralSource() === 'emergency_rj_rsd' ? 'selected' : '' ?>>RJ-RSD (Emergency room)</option>
                        <option value="rna" <?= $patient->getReferralSource() === 'rna' ? 'selected' : '' ?>>RNA (Rawat Naik Ambulan)</option>
                        <option value="sds" <?= $patient->getReferralSource() === 'sds' ? 'selected' : '' ?>>SDS (Sarana Darurat Siaga)</option>
                        <option value="other" <?= $patient->getReferralSource() === 'other' ? 'selected' : '' ?>>Lain-lain (Other)</option>
                    </select>
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-diagnoses"></i>&nbsp;
                    Data Bencana
                </h2>
                <?php if (isset($_SESSION['errors']['disaster'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['disaster'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <div class="row">
                    <label for="disaster_type">Jenis Bencana</label>
                    <select required name="disaster_type" id="disaster_type" style="border-color: <?= isset($_SESSION['errors']['disaster']['disaster_type']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Jenis Bencana --</option>
                        <option value="earthquake" <?= $patient->getDisasterType() === 'earthquake' ? 'selected' : '' ?>>Gempa Bumi</option>
                        <option value="tsunami" <?= $patient->getDisasterType() === 'tsunami' ? 'selected' : '' ?>>Tsunami</option>
                        <option value="flood" <?= $patient->getDisasterType() === 'flood' ? 'selected' : '' ?>>Banjir</option>
                        <option value="landslide" <?= $patient->getDisasterType() === 'landslide' ? 'selected' : '' ?>>Tanah Longsor</option>
                        <option value="fire" <?= $patient->getDisasterType() === 'fire' ? 'selected' : '' ?>>Kebakaran</option>
                        <option value="epidemic" <?= $patient->getDisasterType() === 'epidemic' ? 'selected' : '' ?>>Wabah</option>
                        <option value="other" <?= $patient->getDisasterType() === 'other' ? 'selected' : '' ?>>Lain-lain</option>
                    </select>
                </div>
                <div class="row">
                    <label for="injury_type">Jenis Cedera</label>
                    <select required name="injury_type" id="injury_type" style="border-color: <?= isset($_SESSION['errors']['disaster']['injury_type']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Jenis Cedera --</option>
                        <option value="blunt_force" <?= $patient->getInjuryType() === 'blunt_force' ? 'selected' : '' ?>>Tumpul</option>
                        <option value="sharp_object" <?= $patient->getInjuryType() === 'sharp_object' ? 'selected' : '' ?>>Tajam</option>
                        <option value="gunshot" <?= $patient->getInjuryType() === 'gunshot' ? 'selected' : '' ?>>Peluru</option>
                        <option value="burn" <?= $patient->getInjuryType() === 'burn' ? 'selected' : '' ?>>Bakar</option>
                        <option value="poisoning" <?= $patient->getInjuryType() === 'poisoning' ? 'selected' : '' ?>>Keracunan</option>
                        <option value="drowning" <?= $patient->getInjuryType() === 'drowning' ? 'selected' : '' ?>>Tenggelam</option>
                        <option value="asphyxia" <?= $patient->getInjuryType() === 'asphyxia' ? 'selected' : '' ?>>Afiksia</option>
                        <option value="other" <?= $patient->getInjuryType() === 'other' ? 'selected' : '' ?>>Lain-lain</option>
                    </select>
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-file-medical-alt"></i>&nbsp;
                    Data Medis
                </h2>
                <?php if (isset($_SESSION['errors']['medical'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['medical'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <img src="<?= asset('assets/resume/local-status.png') ?>" alt="Status Lokal" style="margin-bottom: 16px;">
                <div class="row">
                    <label for="local_status_range">Status Lokal (Range)</label>
                    <select required name="local_status_range" id="local_status_range" style="border-color: <?= isset($_SESSION['errors']['medical']['local_status_range']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Status Lokal (Range) --</option>
                        <option value="00-09" <?= $patient->getLocalStatusRange() === '00-09' ? 'selected' : '' ?>>00-09</option>
                        <option value="10-19" <?= $patient->getLocalStatusRange() === '10-19' ? 'selected' : '' ?>>10-19</option>
                        <option value="20-29" <?= $patient->getLocalStatusRange() === '20-29' ? 'selected' : '' ?>>20-29</option>
                        <option value="30-39" <?= $patient->getLocalStatusRange() === '30-39' ? 'selected' : '' ?>>30-39</option>
                        <option value="40-49" <?= $patient->getLocalStatusRange() === '40-49' ? 'selected' : '' ?>>40-49</option>
                        <option value="50-59" <?= $patient->getLocalStatusRange() === '50-59' ? 'selected' : '' ?>>50-59</option>
                        <option value="60-69" <?= $patient->getLocalStatusRange() === '60-69' ? 'selected' : '' ?>>60-69</option>
                        <option value="70-79" <?= $patient->getLocalStatusRange() === '70-79' ? 'selected' : '' ?>>70-79</option>
                        <option value="80-89" <?= $patient->getLocalStatusRange() === '80-89' ? 'selected' : '' ?>>80-89</option>
                        <option value="90-99" <?= $patient->getLocalStatusRange() === '90-99' ? 'selected' : '' ?>>90-99</option>
                    </select>
                </div>
                <div class="row">
                    <label for="local_status_color">Status Lokal (Warna)</label>
                    <select required name="local_status_color" id="local_status_color" style="border-color: <?= isset($_SESSION['errors']['medical']['local_status_color']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Status Lokal (Warna) --</option>
                        <option value="green" <?= $patient->getLocalStatusColor() === 'green' ? 'selected' : '' ?>>Hijau (Green)</option>
                        <option value="yellow" <?= $patient->getLocalStatusColor() === 'yellow' ? 'selected' : '' ?>>Kuning (Yellow)</option>
                        <option value="red" <?= $patient->getLocalStatusColor() === 'red' ? 'selected' : '' ?>>Merah (Red)</option>
                        <option value="black" <?= $patient->getLocalStatusColor() === 'black' ? 'selected' : '' ?>>Hitam (Black)</option>
                        <option value="white" <?= $patient->getLocalStatusColor() === 'white' ? 'selected' : '' ?>>Putih (White)</option>
                        <option value="blue" <?= $patient->getLocalStatusColor() === 'blue' ? 'selected' : '' ?>>Biru (Blue)</option>
                        <option value="orange" <?= $patient->getLocalStatusColor() === 'orange' ? 'selected' : '' ?>>Oranye (Orange)</option>
                        <option value="other" <?= $patient->getLocalStatusColor() === 'other' ? 'selected' : '' ?>>Lain-lain (Other)</option>
                    </select>
                </div>
                <div class="row">
                    <label for="alergies">Alergi</label>
                    <textarea required name="alergies" id="alergies" placeholder="Tulis alergi pasien (seperti obat, makanan, dll)" style="margin-bottom: 16px;border-color: <?= isset($_SESSION['errors']['medical']['alergies']) ? 'red' : '' ?>"><?= $patient->getAlergies() ?></textarea>
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-user-clock"></i>&nbsp;
                    Data Penemuan Pasien
                </h2>
                <?php if (isset($_SESSION['errors']['discovery'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['discovery'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <div class="row">
                    <label for="discovery_timestamp">Waktu Ditemukan</label>
                    <input required type="datetime-local" name="discovery_timestamp" id="discovery_timestamp" value="<?= $patient->getDiscoveryTimestamp() ?>" style="border-color: <?= isset($_SESSION['errors']['discovery']['timestamp']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="discovery_location">Lokasi Ditemukan</label>
                    <input required type="text" name="discovery_location" id="discovery_location" value="<?= $patient->getDiscoveryLocation() ?>" placeholder="Tulis lokasi ditemukan pasien" style="border-color: <?= isset($_SESSION['errors']['discovery']['location']) ? 'red' : '' ?>">
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-user-md"></i>&nbsp;
                    Tanda Vital
                </h2>
                <?php if (isset($_SESSION['errors']['vital_sign'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['vital_sign'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <div class="row">
                    <label for="vital_sign_blood_pressure">Tekanan Darah (mmHg):</label>
                    <input required type="text" name="vital_sign_blood_pressure" id="vital_sign_blood_pressure" value="<?= $patient->getVitalSignBloodPressure() ?>" placeholder="Tulis tekanan darah pasien" style="border-color: <?= isset($_SESSION['errors']['vital_sign']['blood_pressure']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="vital_sign_pulse">Denyut Nadi (bpm):</label>
                    <input required type="number" name="vital_sign_pulse" id="vital_sign_pulse" value="<?= $patient->getVitalSignPulse() ?>" placeholder="Tulis nadi pasien" style="border-color: <?= isset($_SESSION['errors']['vital_sign']['pulse']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="vital_sign_respiratory_rate">Respirasi (kali/menit)</label>
                    <input required type="number" name="vital_sign_respiratory_rate" id="vital_sign_respiratory_rate" value="<?= $patient->getVitalSignRespiratoryRate() ?>" placeholder="Tulis respirasi pasien" style="border-color: <?= isset($_SESSION['errors']['vital_sign']['respiratory_rate']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="vital_sign_temperature">Suhu (°C)</label>
                    <input required type="number" name="vital_sign_temperature" id="vital_sign_temperature" value="<?= $patient->getVitalSignTemperature() ?>" placeholder="Tulis suhu pasien" style="border-color: <?= isset($_SESSION['errors']['vital_sign']['temperature']) ? 'red' : '' ?>">
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-user-injured"></i>&nbsp;
                    Kondisi Pasien
                </h2>
                <?php if (isset($_SESSION['errors']['patient'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['patient'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <img src="<?= asset('assets/resume/condition.png') ?>" alt="Tipe Kondisi" style="margin-bottom: 16px;">
                <div class="row">
                    <label for="condition_color">Kondisi</label>
                    <select required name="condition_color" id="condition_color" style="border-color: <?= isset($_SESSION['errors']['patient']['condition_color']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Kondisi --</option>
                        <option value="P1" <?= $patient->getConditionColor() === 'p1' ? 'selected' : '' ?>>P1 (Gawat dan Darurat)</option>
                        <option value="P2" <?= $patient->getConditionColor() === 'p2' ? 'selected' : '' ?>>P2 (Gawat dan Tidak Darurat)</option>
                        <option value="P3" <?= $patient->getConditionColor() === 'p3' ? 'selected' : '' ?>>P3 (Tidak Gawat dan Tidak Darurat)</option>
                        <option value="P4" <?= $patient->getConditionColor() === 'p4' ? 'selected' : '' ?>>P4 (Meninggal)</option>
                    </select>
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-eye"></i>&nbsp;
                    Pemeriksaan Awal
                </h2>
                <?php if (isset($_SESSION['errors']['examination'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['examination'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <div class="row">
                    <label for="pupil_status">Status Pupil</label>
                    <select required name="pupil_status" id="pupil_status" style="border-color: <?= isset($_SESSION['errors']['examination']['pupil_status']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Status Pupil --</option>
                        <option value="isokor" <?= $patient->getPupilStatus() === 'isokor' ? 'selected' : '' ?>>Isokor</option>
                        <option value="anisokor" <?= $patient->getPupilStatus() === 'anisokor' ? 'selected' : '' ?>>Anisokor</option>
                        <option value="miotic" <?= $patient->getPupilStatus() === 'miotic' ? 'selected' : '' ?>>Miotik</option>
                        <option value="mydriatic" <?= $patient->getPupilStatus() === 'mydriatic' ? 'selected' : '' ?>>Midriatik</option>
                        <option value="other" <?= $patient->getPupilStatus() === 'other' ? 'selected' : '' ?>>Lain-lain (Other)</option>
                    </select>
                </div>
                <div class="row">
                    <label for="light_reflex_left">Refleks Cahaya Kiri</label>
                    <input required type="number" name="light_reflex_left" id="light_reflex_left" value="<?= $patient->getLightReflexLeft() ?>" placeholder="Tulis refleks cahaya kiri pasien" style="border-color: <?= isset($_SESSION['errors']['examination']['light_reflex_left']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="light_reflex_right">Refleks Cahaya Kanan</label>
                    <input required type="number" name="light_reflex_right" id="light_reflex_right" value="<?= $patient->getLightReflexRight() ?>" placeholder="Tulis refleks cahaya kanan pasien" style="border-color: <?= isset($_SESSION['errors']['examination']['light_reflex_right']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="airway_c_spine">Airway C-Spine</label>
                    <select required name="airway_c_spine" id="airway_c_spine" style="border-color: <?= isset($_SESSION['errors']['examination']['airway_cspine']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Airway C-Spine --</option>
                        <option value="clear" <?= $patient->getAirwayCSpine() === 'clear' ? 'selected' : '' ?>>Bersih</option>
                        <option value="sputum" <?= $patient->getAirwayCSpine() === 'sputum' ? 'selected' : '' ?>>Slem Sumbatan</option>
                        <option value="partial" <?= $patient->getAirwayCSpine() === 'partial' ? 'selected' : '' ?>>Parsial</option>
                        <option value="total" <?= $patient->getAirwayCSpine() === 'total' ? 'selected' : '' ?>>Sumbatan Total</option>
                        <option value="other" <?= $patient->getAirwayCSpine() === 'other' ? 'selected' : '' ?>>Lain-lain</option>
                    </select>
                </div>
                <div class="row">
                    <label for="breathing_status">Pernapasan</label>
                    <select required name="breathing_status" id="breathing_status" style="border-color: <?= isset($_SESSION['errors']['examination']['breathing_status']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Pernapasan --</option>
                        <option value="normal" <?= $patient->getBreathingStatus() === 'normal' ? 'selected' : '' ?>>Normal</option>
                        <option value="wheezing" <?= $patient->getBreathingStatus() === 'wheezing' ? 'selected' : '' ?>>Wheezing</option>
                        <option value="ronchi" <?= $patient->getBreathingStatus() === 'ronchi' ? 'selected' : '' ?>>Ronchi</option>
                        <option value="retraction" <?= $patient->getBreathingStatus() === 'retraction' ? 'selected' : '' ?>>Retraksi</option>
                        <option value="nasal-flaring" <?= $patient->getBreathingStatus() === 'nasal-flaring' ? 'selected' : '' ?>>Nasal Flaring</option>
                        <option value="abnormal-position" <?= $patient->getBreathingStatus() === 'abnormal-position' ? 'selected' : '' ?>>Posisi Abnormal</option>
                        <option value="other" <?= $patient->getBreathingStatus() === 'other' ? 'selected' : '' ?>>Lain-lain</option>
                    </select>
                </div>
                <div class="row">
                    <label for="circulation_status">Sirkulasi</label>
                    <select required name="circulation_status" id="circulation_status" style="border-color: <?= isset($_SESSION['errors']['examination']['circulation_status']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Sirkulasi --</option>
                        <option value="pallor" <?= $patient->getCirculationStatus() === 'pallor' ? 'selected' : '' ?>>Pallor</option>
                        <option value="mottling" <?= $patient->getCirculationStatus() === 'mottling' ? 'selected' : '' ?>>Motling</option>
                        <option value="cyanosis" <?= $patient->getCirculationStatus() === 'cyanosis' ? 'selected' : '' ?>>Cyanosis</option>
                        <option value="capillary-refill" <?= $patient->getCirculationStatus() === 'capillary-refill' ? 'selected' : '' ?>>Capillary Refill</option>
                    </select>
                </div>
                <div class="row">
                    <label for="gcs_disability_status">GCS (Glasgow Coma Scale)</label>
                    <select required name="gcs_disability_status" id="gcs_disability_status" style="border-color: <?= isset($_SESSION['errors']['examination']['gcs_disability_status']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih GCS (Glasgow Coma Scale) --</option>
                        <option value="eye-movement" <?= $patient->getGcsDisabilityStatus() === 'eye-movement' ? 'selected' : '' ?>>Eye Movement</option>
                        <option value="motor-reflex" <?= $patient->getGcsDisabilityStatus() === 'motor-reflex' ? 'selected' : '' ?>>Reflek Motorik</option>
                        <option value="verbal" <?= $patient->getGcsDisabilityStatus() === 'verbal' ? 'selected' : '' ?>>Verbal</option>
                    </select>
                </div>
                <div class="row">
                    <label for="exposure_status">Eksposur</label>
                    <select required name="exposure_status" id="exposure_status" style="border-color: <?= isset($_SESSION['errors']['examination']['exposure_status']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Eksposur --</option>
                        <option value="bleeding" <?= $patient->getExposureStatus() === 'bleeding' ? 'selected' : '' ?>>Pendarahan</option>
                        <option value="fracture" <?= $patient->getExposureStatus() === 'fracture' ? 'selected' : '' ?>>Fraktur</option>
                        <option value="paralysis" <?= $patient->getExposureStatus() === 'paralysis' ? 'selected' : '' ?>>Parase</option>
                        <option value="plegia" <?= $patient->getExposureStatus() === 'plegia' ? 'selected' : '' ?>>Plegi</option>
                        <option value="paraparesis" <?= $patient->getExposureStatus() === 'paraparesis' ? 'selected' : '' ?>>Paraperesis</option>
                    </select>
                </div>
                <div class="row">
                    <label for="prehospital_status">Pra Rumah Sakit</label>
                    <select required name="prehospital_status" id="prehospital_status" style="border-color: <?= isset($_SESSION['errors']['examination']['prehospital_status']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih Pra Rumah Sakit --</option>
                        <option value="rjp" <?= $patient->getPrehospitalStatus() === 'rjp' ? 'selected' : '' ?>>RJP (Resusitasi Jantung Paru)</option>
                        <option value="intubasi" <?= $patient->getPrehospitalStatus() === 'intubasi' ? 'selected' : '' ?>>Intubasi</option>
                        <option value="oksigen" <?= $patient->getPrehospitalStatus() === 'oksigen' ? 'selected' : '' ?>>Oksigen</option>
                        <option value="ecollar" <?= $patient->getPrehospitalStatus() === 'ecollar' ? 'selected' : '' ?>>Ecollar</option>
                        <option value="balut" <?= $patient->getPrehospitalStatus() === 'balut' ? 'selected' : '' ?>>Balut/Bi</option>
                        <option value="obat" <?= $patient->getPrehospitalStatus() === 'obat' ? 'selected' : '' ?>>Obat</option>
                    </select>
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-medkit"></i>
                    Rincian Medis
                </h2>
                <?php if (isset($_SESSION['errors']['medical_details'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['medical_details'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <div class="row">
                    <label for="anamnesis">Anamnesis</label>
                    <textarea required name="anamnesis" id="anamnesis" placeholder="Jelaskan riwayat kesehatan, keluhan utama, dan gejala yang dialami pasien"  style="border-color: <?= isset($_SESSION['errors']['medical_details']['anamnesis']) ? 'red' : '' ?>"><?= $patient->getAnamnesis() ?></textarea>
                </div>
                <div class="row">
                    <label for="diagnosis">Diagnosis</label>
                    <textarea required name="diagnosis" id="diagnosis" placeholder="Tuliskan diagnosis utama dan diagnosis banding jika ada" style="border-color: <?= isset($_SESSION['errors']['medical_details']['diagnosis']) ? 'red' : '' ?>"><?= $patient->getDiagnosis() ?></textarea>
                </div>
                <div class="row">
                    <label for="therapy">Terapi</label>
                    <textarea required name="therapy" id="therapy" placeholder="Cantumkan jenis pengobatan, dosis obat, dan durasi pemberian terapi" style="border-color: <?= isset($_SESSION['errors']['medical_details']['therapy']) ? 'red' : '' ?>"><?= $patient->getTherapy() ?></textarea>
                </div>
                <div class="row">
                    <label for="actions_taken">Tindak Lanjut</label>
                    <textarea required name="actions_taken" id="actions_taken" placeholder="Jelaskan rencana perawatan selanjutnya, rujukan, atau instruksi khusus untuk pasien" style="margin-bottom: 16px;border-color: <?= isset($_SESSION['errors']['medical_details']['actions_taken']) ? 'red' : '' ?>"><?= $patient->getActionsTaken() ?></textarea>
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-user-friends"></i>&nbsp;
                    Data Penemu Pasien
                </h2>
                <?php if (isset($_SESSION['errors']['finder'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['finder'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <div class="row">
                    <label for="finder_full_name">Nama Lengkap Penemu</label>
                    <input required type="text" name="finder_full_name" id="finder_full_name" value="<?= $patient->getFinderFullName() ?>" placeholder="Masukkan nama lengkap penemu" style="border-color: <?= isset($_SESSION['errors']['finder']['full_name']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="finder_age">Usia Penemu</label>
                    <input required type="text" name="finder_age" id="finder_age" value="<?= $patient->getFinderAge() ?>" placeholder="Contoh: 25" style="border-color: <?= isset($_SESSION['errors']['finder']['age']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="finder_gender">Jenis Kelamin Penemu</label>
                    <select required name="finder_gender" id="finder_gender" style="border-color: <?= isset($_SESSION['errors']['finder']['gender']) ? 'red' : '' ?>">
                        <option disabled selected value="">-- Pilih jenis kelamin --</option>
                        <option value="l" <?= $patient->getFinderGender() === 'l' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="p" <?= $patient->getFinderGender() === 'p' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="row">
                    <label for="finder_phone_number">Nomor Handphone Penemu</label>
                    <input required type="tel" name="finder_phone_number" id="finder_phone_number" value="<?= $patient->getFinderPhoneNumber() ?>" placeholder="Contoh: 08123456789" style="border-color: <?= isset($_SESSION['errors']['finder']['phone_number']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="finder_address">Alamat Lengkap Penemu</label>
                     <textarea required name="finder_address" id="finder_address" placeholder="Masukkan alamat lengkap termasuk RT/RW" style="margin-bottom: 16px;border-color: <?= isset($_SESSION['errors']['finder']['address']) ? 'red' : '' ?>"><?= $patient->getFinderAddress() ?></textarea>
                </div>
            </div>

            <hr>

            <div>
                <h2 style="text-align: left;">
                    <i class="fas fa-user-check"></i>&nbsp;
                    Konfirmasi Pasien
                </h2>
                <?php if (isset($_SESSION['errors']['confirmation'])) : ?>
                    <div class="errors">
                        <ol>
                            <?php foreach ($_SESSION['errors']['confirmation'] as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ol>
                    </div>
                <?php endif ?>
                <div class="row">
                    <label for="confirmation_datetime">Tanggal dan Waktu</label>
                    <input required type="datetime-local" name="confirmation_datetime" id="confirmation_datetime" value="<?= $patient->getConfirmationDatetime() ?>" style="border-color: <?= isset($_SESSION['errors']['confirmation']['datetime']) ? 'red' : '' ?>">
                </div>
                <div class="row">
                    <label for="confirmation_issue">Masalah</label>
                    <textarea required name="confirmation_issue" id="confirmation_issue" placeholder="Tuliskan masalah yang dihadapi pasien" style="border-color: <?= isset($_SESSION['errors']['confirmation']['issue']) ? 'red' : '' ?>"><?= $patient->getConfirmationIssue() ?></textarea>
                </div>
                <div class="row">
                    <label for="confirmation_therapy">Terapi</label>
                    <textarea required name="confirmation_therapy" id="confirmation_therapy" placeholder="Tuliskan terapi yang diberikan kepada pasien" style="margin-bottom: 16px; border-color: <?= isset($_SESSION['errors']['confirmation']['therapy']) ? 'red' : '' ?>"><?= $patient->getConfirmationTherapy() ?></textarea>
                </div>
            </div>

            <div class="buttons">
                <a class="btn-reset" href="<?= route('resume') ?>">
                    Batal
                </a>
                <button type="submit" style="margin-left: 12px;">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Clear session -->
    <?php unset($_SESSION['errors']) ?>
</body>

</html>