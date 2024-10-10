<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epidemiologi Edit Data Pasien Satuan</title>
    <link rel="stylesheet" href="<?= asset('css/epidemiologi/main.css') ?>">
</head>

<body>
    <div class="container">
        <h1>Epidemiologi Edit Data Pasien Satuan: <?= $epidemiologi->getFullName() ?></h1>

        <?php if (isset($_SESSION['errors'])) : ?>
        <div class="errors">
                <ol>
                    <?php foreach ($_SESSION['errors'] as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach ?>
                </ol>
        </div>
        <?php endif ?>

        <form method="POST" action="<?= route('epidemiologi/edit?id=' . $id) ?>">
            <label for="full_name">Nama Pasien:</label>
            <input required type="text" id="full_name" name="full_name" placeholder="Masukkan nama pasien" style="margin-bottom: 16px;" value="<?= $epidemiologi->getFullName() ?>">

            <label for="national_id_number">No. Identitas (KTP/Passport):</label>
            <input required type="text" id="national_id_number" name="national_id_number" placeholder="Masukkan nomor identitas pasien" style="margin-bottom: 16px;" value="<?= $epidemiologi->getNationalIdNumber() ?>">

            <label for="age">Umur Pasien:</label>
            <input required type="number" id="age" name="age" placeholder="Masukkan umur pasien" style="margin-bottom: 16px;" value="<?= $epidemiologi->getAge() ?>">

            <label for="gender">Jenis Kelamin:</label>
            <select required id="gender" name="gender" style="margin-bottom: 16px;">
                <option value="L" <?= $epidemiologi->getGender() === 'l' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P <?= $epidemiologi->getGender() === 'p' ? 'selected' : '' ?>">Perempuan</option>
            </select>

            <label for="address">Alamat Pasien:</label>
            <textarea required name="address" id="address" placeholder="Masukkan alamat pasien" style="margin-bottom: 16px;"><?= $epidemiologi->getAddress() ?></textarea>

            <label for="diagnosis">Diagnosis:</label>
            <textarea required name="diagnosis" id="diagnosis" placeholder="Diagnosis penyakit pasien" style="margin-bottom: 16px;"><?= $epidemiologi->getDiagnosis() ?></textarea>

            <label for="diagnosis_date">Tanggal Diagnosis:</label>
            <input required type="date" id="diagnosis_date" name="diagnosis_date" value="<?= $epidemiologi->getDiagnosisDate() ?>">

            <div style="display: flex; justify-content: right; margin-top: 20px;">
                <button class="btn-download" type="submit">Simpan Data Pasien</button>
            </div>
        </form>
    </div>

    <!-- Clear session -->
    <?php unset($_SESSION['errors']) ?>
</body>

</html>