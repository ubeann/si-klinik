<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Darurat Bencana</title>
    <link rel="stylesheet" href="<?= asset('css/home/dashboard.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div id="container">
        <div id="sidebar">
            <div class="logo">
                <img src="<?= asset('assets/logo.png') ?>" alt="Klinik Logo">
            </div>
            <ul>
                <li>
                    <a href="<?= route('patients/form-register') ?>">
                        <img src="<?= asset('assets/home/patients-register.png') ?>" alt="Pendaftaran">
                        Pendaftaran
                    </a>
                </li>
                <li>
                    <a href="<?= route('patients') ?>">
                        <img src="<?= asset('assets/home/patients-search.png') ?>" alt="Pencarian">
                        Data Pasien
                    </a>
                </li>
                <li>
                    <a href="<?= route('resume') ?>">
                        <img src="<?= asset('assets/home/patients-report.png') ?>" alt="Resume Medis">
                        Resume Medis
                    </a>
                </li>
                <li>
                    <a href="<?= route('disease') ?>">
                        <img src="<?= asset('assets/home/patients-disease.png') ?>" alt="Index Penyakit">
                        Index Penyakit
                    </a>
                </li>
                <li>
                    <a href="<?= route('epidemiologi') ?>">
                        <img src="<?= asset('assets/home/patients-epidemiologi.png') ?>" alt="Epidemiologi">
                        Epidemiologi
                    </a>
                </li>
                <li>
                    <a href="<?= route('users') ?>">
                        <img src="<?= asset('assets/home/patients-profile.png') ?>" alt="Data Pengguna">
                        Data Pengguna
                    </a>
                </li>
            </ul>
        </div>
        <div id="content">
            <div class="dropdown">
                <button class="dropbtn"><i class='fas fa-ellipsis-h'></i></button>
                <div class="dropdown-content">
                    <a href="datapengguna.php">Profil</a>
                    <a href="#">Pengaturan</a>
                    <form action="<?= route('logout') ?>" method="POST">
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
            <h1>DASHBOARD SISTEM DARURAT BENCANA</h1><br>
            <div class="widget-container" style="margin-bottom: 40px;">
                <a class="widget" id="pasien-widget" href="<?= route('patients') ?>">
                    <i class="fas fa-users widget-icon"></i>
                    <div class="widget-content">
                        <h3>Total Pasien</h3>
                        <p class="widget-value" id="total-pasien"><?= $totalPatients ?></p>
                    </div>
                </a>
                <a class="widget" id="penyakit-widget" href="<?= route('disease') ?>">
                    <i class="fas fa-atom widget-icon"></i>
                    <div class="widget-content">
                        <h3>Index Penyakit</h3>
                        <p class="widget-value" id="index-penyakit"><?= $totalDiseases ?></p>
                    </div>
                </a>
                <a class="widget" id="epidemiologi-widget" href="<?= route('epidemiologi') ?>">
                    <i class="fas fa-skull-crossbones widget-icon"></i>
                    <div class="widget-content">
                        <h3>Epidemiologi</h3>
                        <p class="widget-value" id="epidemiologi"><?= $totalEpidemiologis ?></p>
                    </div>
                </a>
            </div>
            <div id="chart-container">
                <h2>Laporan Kunjungan Pasien</h2>
                <canvas id="patientVisitChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Setup the chart
        const ctx = document.getElementById('patientVisitChart').getContext('2d');
        const patientVisitChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['2024-09', '2024-10', '2024-11', '2024-12'],
                datasets: [{
                        label: 'Pasien Lama',
                        data: [15, 45, 30, 21],
                        borderColor: 'green',
                        fill: false
                    },
                    {
                        label: 'Pasien Baru',
                        data: [0, 10, 5, 0],
                        borderColor: 'purple',
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Jumlah Pasien'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>