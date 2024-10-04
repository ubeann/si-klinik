<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telemedicine Schedule</title>
    <link rel="stylesheet" href="<?= asset('css/telemedicine/index.css') ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="<?= asset('assets/logo-si-klin.png') ?>" alt="Klinik Logo">
            </div>
            <div id="contents">
                <a href="<?= route('dashboard') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 30 20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </a>
            </div>
        </header>
        <div class="schedule-section">
            <a href="<?= route('telemedicine/form-register') ?>">
                <button id="schedule-btn">Registrasi Telemedicine</button>
            </a>
            <div class="dropdown">
                <button class="dropbtn" id="doctor-btn">Nama dan Jadwal Tersedia Dokter</button>
                <input type="text" id="doctor-search" placeholder="Cari Dokter..." class="search-input">
                <div class="dropdown-content" id="doctor-list">
                    <!-- Doctor names will appear here -->
                </div>
            </div>
        </div>
    </div>
    <script src="<?= asset('js/telemedicine.js') ?>"></script>
</body>

</html>