<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Penyakit/Bencana</title>
    <link rel="stylesheet" href="<?= asset('css/disease/main.css') ?>">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <img src="<?= asset('assets/logo.png') ?>" alt="Klinik Logo">
                </li>
                <li>
                    <a href="<?= route('dashboard') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="0 0 30 20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Tambah Data Penyakit/Bencana</h1>

        <?php if (isset($_SESSION['errors'])) : ?>
        <div class="errors">
                <ol>
                    <?php foreach ($_SESSION['errors'] as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach ?>
                </ol>
        </div>
        <?php endif ?>

        <form method="POST" action="<?= route('disease/register') ?>">
            <label for="name">Nama Penyakit/Bencana:</label>
            <input required type="text" id="name" name="name" placeholder="Nama Penyakit/Bencana" style="margin-bottom: 16px;">

            <label for="code">Kode:</label>
            <input required type="text" id="code" name="code" placeholder="Kode" style="margin-bottom: 16px;">

            <label for="category">Kategori:</label>
            <select required id="category" name="category" style="margin-bottom: 16px;">
                <option disabled selected value="">Pilih Kategori</option>
                <option value="natural-disaster">Bencana Alam</option>
                <option value="epidemic">Epidemi</option>
                <option value="disease">Penyakit</option>
            </select>

            <label for="description">Deskripsi:</label>
            <textarea required id="description" name="description" placeholder="Deskripsi" style="margin-bottom: 16px;"></textarea>

            <label for="severity_level">Tingkat Keparahan:</label>
            <select required id="severity_level" name="severity_level" style="margin-bottom: 16px;">
                <option disabled selected value="">Pilih Tingkat Keparahan</option>
                <option value="low">Rendah</option>
                <option value="medium">Sedang</option>
                <option value="high">Tinggi</option>
                <option value="very-high">Sangat Tinggi</option>
            </select>

            <label for="affected_region">Wilayah Terdampak:</label>
            <input required type="text" id="affected_region" name="affected_region" placeholder="Wilayah Terdampak" style="margin-bottom: 16px;">

            <label for="incident_date">Tanggal Kejadian:</label>
            <input required type="datetime-local" id="incident_date" name="incident_date" style="margin-bottom: 16px;">

            <label for="victim_count">Jumlah Korban:</label>
            <input required type="number" id="victim_count" name="victim_count" placeholder="Jumlah Korban" style="margin-bottom: 16px;">

            <label for="status">Status:</label>
            <select required id="status" name="status" style="margin-bottom: 16px;">
                <option disabled selected value="">Pilih Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Tidak Aktif</option>
            </select>

            <label for="history">Sejarah:</label>
            <textarea required id="history" name="history" placeholder="Sejarah" style="margin-bottom: 16px;"></textarea>

            <label for="contact_information">Kontak:</label>
            <textarea required id="contact_information" name="contact_information" placeholder="Kontak" style="margin-bottom: 16px;"></textarea>

            <div style="display: flex; justify-content: right; margin-top: 20px;">
                <button class="btn-download" type="submit">Tambahkan Data</button>
            </div>
        </form>
    </div>

    <!-- Clear session -->
    <?php unset($_SESSION['errors']) ?>
</body>

</html>