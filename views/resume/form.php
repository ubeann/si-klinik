<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Medis</title>
    <link rel="stylesheet" href="<?= asset('css/resume/form.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h2>Resume Medis: <?= $patient->getMedicalRecordNumber() ?></h2>
        <form method="POST" action="<?= route('resume/save') ?>">
            <div class="row">
                <label>No. RM:</label><input disabled type="text" value="<?= $patient->getMedicalRecordNumber() ?>">
            </div>
            <div class="row">
                <label>Nama pasien</label><input disabled type="text" value="<?= $patient->getFullName() ?>">
            </div>
            <div class="row">
                <div class="column" style="width: 70%;">
                    <label for="initial_diagnosis" style="width: 27%;">Diagnosa Awal</label>
                    <input type="text" name="initial_diagnosis" id="initial_diagnosis" style="width: 68%;">
                </div>
                <div class="column" style="width: 50%;">
                    <label for="initial_icd_code" style="width: 60px;">ICD-10</label>
                    <input type="text" name="initial_icd_code" id="initial_icd_code" style="width: 100%;">
                </div>
            </div>
            <div class="row">
                <div class="column" style="width: 70%;">
                    <label for="primary_diagnosis" style="width: 27%;">Diagnosa Utama</label>
                    <input type="text" name="primary_diagnosis" id="primary_diagnosis" style="width: 68%;">
                </div>
                <div class="column" style="width: 50%;">
                    <label for="primary_icd_code" style="width: 60px;">ICD-10</label>
                    <input type="text" name="primary_icd_code" id="primary_icd_code" style="width: 100%;">
                </div>
            </div>
            <div class="row">
                <label>Anamnesis</label><textarea name="anamnesis"></textarea>
            </div>
            <div class="row">
                <label>Pemeriksaan Fisik</label><textarea name="physical_examination"></textarea>
            </div>
            <div class="row">
                <label>Obat yang diresepkan</label><textarea name="prescribed_medication"></textarea>
            </div>
            <div class="row">
                <label>Pengobatan atau tindak lanjut</label><textarea name="treatment_or_follow_up"></textarea>
            </div>
            <div class="row">
                <label for="status">Status Pengisian RM</label>
                <select required name="status" id="status">
                    <option value="not-filled" <?= $patient->getStatus() === 'not-filled' ? 'selected' : '' ?>>Belum Diisi</option>
                    <option value="incomplete" <?= $patient->getStatus() === 'incomplete' ? 'selected' : '' ?>>Belum Dilengkapi</option>
                    <option value="complete" <?= $patient->getStatus() === 'complete' ? 'selected' : '' ?>>Lengkap</option>
                </select>
            </div>
            <div class="signature-section">
                <p>Tasikmalaya, <?= date('d F Y') ?></p>
                <div class="signature">
                    <img src="<?= asset('assets/resume/doctor-signature.png') ?>" alt="Signature" class="signature-image">
                    <p>(dr. Jovan Sp. Assasin)</p>
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