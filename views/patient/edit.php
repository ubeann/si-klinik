<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien</title>
    <link rel="stylesheet" href="<?= asset('css/patient/register.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="header">
            <div class="logo">
                <img src="<?= asset('assets/logo-si-klin.png') ?>" alt="Klinik Logo">
                <div class="logo-text"></div>
            </div>
            <a href="<?= route('dashboard') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="0 0 30 20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </a>
        </div>
    </header>

    <h1>Form Edit Data Pasien RM:<?= $patient->getMedicalRecordNumber() ?></h1>

    <?php if (isset($_SESSION['errors'])) : ?>
    <div class="errors">
            <ol>
                <?php foreach ($_SESSION['errors'] as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ol>
    </div>
    <?php endif ?>
    <form method="POST" action="<?= route('patients/edit?id=' . $id) ?>">
        <div class="form-group">
            <label for="medical_record_number">Nomer RM</label>
            <input required type="text" id="medical_record_number" name="medical_record_number" value="<?= $patient->getMedicalRecordNumber() ?>">

            <label for="registration_date">Tgl. Daftar</label>
            <input required type="date" id="registration_date" name="registration_date" value="<?= $patient->getRegistrationDate() ?>">

            <label for="national_id_number">NIK</label>
            <input required type="text" id="national_id_number" name="national_id_number" value="<?= $patient->getNationalIdNumber() ?>">
        </div>

        <div class="form-group">
            <label for="full_name">Nama</label>
            <input class="long" required type="text" id="full_name" name="full_name" value="<?= $patient->getFullName() ?>">
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea required id="address" name="address" rows="3"><?= $patient->getAddress() ?></textarea>
        </div>

        <div class="form-group">
            <label for="gender">Jenis Kelamin</label>
            <input type="radio" id="genderL" name="gender" value="L" <?= $patient->getGender() === 'l' ? 'checked' : '' ?>>
            <label for="gender">L</label>
            <input type="radio" id="genderP" name="gender" value="P" <?= $patient->getGender() === 'p' ? 'checked' : '' ?>>
            <label for="gender">P</label>

            <label for="birth_date">Tgl. Lahir</label>
            <input required type="date" id="birth_date" name="birth_date" value="<?= $patient->getBirthDate() ?>">
        </div>

        <div class="form-group">
            <label for="guarantor">Penjamin</label>
            <input required type="text" id="guarantor" name="guarantor" value="<?= $patient->getGuarantor() ?>">

            <label for="phone_number">Telephone</label>
            <input required type="int" id="phone_number" name="phone_number" value="<?= $patient->getPhoneNumber() ?>">
        </div>

        <div class="form-group">
            <label for="religion">Agama</label>
            <select required name="religion" id="religion">
                <option value="islam" <?= $patient->getReligion() === 'islam' ? 'selected' : '' ?>>Islam</option>
                <option value="catholic" <?= $patient->getReligion() === 'catholic' ? 'selected' : '' ?>>Katolik</option>
                <option value="protestant" <?= $patient->getReligion() === 'protestant' ? 'selected' : '' ?>>Protestan</option>
                <option value="hindu" <?= $patient->getReligion() === 'hindu' ? 'selected' : '' ?>>Hindu</option>
                <option value="buddha" <?= $patient->getReligion() === 'buddha' ? 'selected' : '' ?>>Buddha</option>
                <option value="other" <?= $patient->getReligion() === 'other' ? 'selected' : '' ?>>Lainnya</option>
            </select>

            <label for="occupation">Pekerjaan</label>
            <input required type="text" id="occupation" name="occupation" value="<?= $patient->getOccupation() ?>">
        </div>

        <div>
            <div class="form-group">
                <label for="education">Pendidikan</label>
                 <select required name="education" id="education">
                    <option value="sd" <?= $patient->getEducation() === 'sd' ? 'selected' : '' ?>>SD</option>
                    <option value="smp" <?= $patient->getEducation() === 'smp' ? 'selected' : '' ?>>SMP</option>
                    <option value="sma" <?= $patient->getEducation() === 'sma' ? 'selected' : '' ?>>SMA</option>
                    <option value="d1" <?= $patient->getEducation() === 'd1' ? 'selected' : '' ?>>D1</option>
                    <option value="d2" <?= $patient->getEducation() === 'd2' ? 'selected' : '' ?>>D2</option>
                    <option value="d3" <?= $patient->getEducation() === 'd3' ? 'selected' : '' ?>>D3</option>
                    <option value="s1" <?= $patient->getEducation() === 's1' ? 'selected' : '' ?>>S1</option>
                    <option value="s2" <?= $patient->getEducation() === 's2' ? 'selected' : '' ?>>S2</option>
                    <option value="s3" <?= $patient->getEducation() === 's3' ? 'selected' : '' ?>>S3</option>
                </select>

                <label for="marital_status">Status Nikah</label>
                <select required name="marital_status" id="marital_status">
                    <option value="single" <?= $patient->getMaritalStatus() === 'single' ? 'selected' : '' ?>>Lajang</option>
                    <option value="married" <?= $patient->getMaritalStatus() === 'married' ? 'selected' : '' ?>>Menikah</option>
                    <option value="divorced" <?= $patient->getMaritalStatus() === 'divorced' ? 'selected' : '' ?>>Cerai</option>
                    <option value="widowed" <?= $patient->getMaritalStatus() === 'widowed' ? 'selected' : '' ?>>Duda/Janda</option>
                </select>

                <label for="status">Status Rekam Medis</label>
                <select required name="status" id="status">
                    <option value="not-filled" <?= $patient->getStatus() === 'not-filled' ? 'selected' : '' ?>>Belum Diisi</option>
                    <option value="incomplete" <?= $patient->getStatus() === 'incomplete' ? 'selected' : '' ?>>Belum Dilengkapi</option>
                    <option value="complete" <?= $patient->getStatus() === 'complete' ? 'selected' : '' ?>>Lengkap</option>
                </select>
            </div>
            <div class="form-buttons">
                <a href="<?= route('patients') ?>">
                    <button type="button" style='font-size:20px'>
                        Batal <i class='fas fa-trash-alt'></i>
                    </button>
                </a>
                <button style='font-size:20px' type="submit">
                    Simpan <i class='fas fa-save'></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Clear session -->
    <?php unset($_SESSION['errors']) ?>
</body>
</html>