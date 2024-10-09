<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <link rel="stylesheet" href="<?= asset('css/patient/register.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="header">
            <div class="logo">
                <img src="<?= asset('assets/logo.png') ?>" alt="Klinik Logo">
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

    <h1>Form Pendaftaran Pasien Baru</h1>

    <?php if (isset($_SESSION['errors'])) : ?>
    <div class="errors">
            <ol>
                <?php foreach ($_SESSION['errors'] as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ol>
    </div>
    <?php endif ?>
    <form method="POST" action="<?= route('patients/register') ?>">
        <div class="form-group">
            <label for="medical_record_number">Nomer RM</label>
            <input type="text" id="medical_record_number" name="medical_record_number" required>

            <label for="registration_date">Tgl. Daftar</label>
            <input type="date" id="registration_date" name="registration_date" required>

            <label for="national_id_number">NIK</label>
            <input type="text" id="national_id_number" name="national_id_number" required>
        </div>

        <div class="form-group">
            <label for="full_name">Nama</label>
            <input class="long" type="text" id="full_name" name="full_name" required>
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea id="address" name="address" rows="3" required></textarea>
        </div>

        <div class="form-group">
            <label for="gender">Jenis Kelamin</label>
            <input type="radio" id="genderL" name="gender" value="L">
            <label for="gender">L</label>
            <input type="radio" id="genderP" name="gender" value="P">
            <label for="gender">P</label>

            <label for="birth_date">Tgl. Lahir</label>
            <input type="date" id="birth_date" name="birth_date">
        </div>

        <div class="form-group">
            <label for="guarantor">Penjamin</label>
            <input type="text" id="guarantor" name="guarantor">

            <label for="phone_number">Telephone</label>
            <input type="int" id="phone_number" name="phone_number">
        </div>

        <div class="form-group">
            <label for="religion">Agama</label>
            <select name="religion" id="religion">
                <option value="islam">Islam</option>
                <option value="catholic">Katolik</option>
                <option value="protestant">Protestan</option>
                <option value="hindu">Hindu</option>
                <option value="buddha">Buddha</option>
                <option value="other">Lainnya</option>
            </select>

            <label for="occupation">Pekerjaan</label>
            <input type="text" id="occupation" name="occupation">
        </div>

        <div>
            <div class="form-group">
                <label for="education">Pendidikan</label>
                 <select name="education" id="education">
                    <option value="sd">SD</option>
                    <option value="smp">SMP</option>
                    <option value="sma">SMA</option>
                    <option value="d1">D1</option>
                    <option value="d2">D2</option>
                    <option value="d3">D3</option>
                    <option value="s1">S1</option>
                    <option value="s2">S2</option>
                    <option value="s3">S3</option>
                </select>

                <label for="marital_status">Status Nikah</label>
                <select name="marital_status" id="marital_status">
                    <option value="single">Lajang</option>
                    <option value="married">Menikah</option>
                    <option value="divorced">Cerai</option>
                    <option value="widowed">Duda/Janda</option>
                </select>

                <label for="status">Status Rekam Medis</label>
                <select required name="status" id="status">
                    <option value="not-filled">Belum Diisi</option>
                    <option value="incomplete">Belum Dilengkapi</option>
                    <option value="complete">Lengkap</option>
                </select>
            </div>
            <div class="form-buttons">
                <a href="<?= route('patients') ?>">
                    <button style='font-size:20px' type="button">
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