<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean Klinik</title>
    <link rel="stylesheet" href="<?= asset('css/patient/queue.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><img src="<?= asset('assets/logo-si-klin.png') ?>" alt="Klinik Logo"></li>
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
        <div class="dropdown" style="text-align: end;">
            <button class="dropbtn"><i class='fas fa-ellipsis-h'></i></button>
            <div class="dropdown-content">
                <a href="<?= route('dashboard') ?>">Kembali</a>
                <a href="<?= route('patients/telemedicine') ?>">Telemedicine</a>
            </div>
        </div>

        <h1>Antrian Klinik</h1>

        <div class="queue-info">
            <div>Nomor Antrian</div>
            <div class="queue-number">A001</div>

            <div>Tanggal</div>
            <div>13-07-2024</div>

            <div>Dokter</div>
            <div>dr. Jovan Sp.Assasin</div>
        </div>

        <div class="button-container">
            <button>Sebelum</button>
            <button class="button-call">Panggil</button>
            <button>Selanjutnya</button>
        </div>
    </div>
</body>

</html>