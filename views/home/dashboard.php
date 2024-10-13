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
        // Get the chart data from PHP
        const chartData = <?php echo json_encode($data); ?>;

        // Prepare the data for Chart.js
        const labels = chartData.map(item => item.month_name);
        const p1Data = chartData.map(item => parseInt(item.p1));
        const p2Data = chartData.map(item => parseInt(item.p2));
        const p3Data = chartData.map(item => parseInt(item.p3));
        const p4Data = chartData.map(item => parseInt(item.p4));

        // Create the chart
        const ctx = document.getElementById('patientVisitChart').getContext('2d');

        // Candy-like colors
        const candyRed = 'rgba(255, 87, 87, 1)';
        const candyYellow = 'rgba(255, 206, 84, 1)';
        const candyGreen = 'rgba(111, 207, 151, 1)';
        const candyPurple = 'rgba(156, 136, 255, 1)';

        // Setup gradient fill for the chart
        const gradient1 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient1.addColorStop(0, 'rgba(255, 87, 87, 0.6)');
        gradient1.addColorStop(1, 'rgba(255, 87, 87, 0.1)');

        const gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient2.addColorStop(0, 'rgba(255, 206, 84, 0.6)');
        gradient2.addColorStop(1, 'rgba(255, 206, 84, 0.1)');

        const gradient3 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient3.addColorStop(0, 'rgba(111, 207, 151, 0.6)');
        gradient3.addColorStop(1, 'rgba(111, 207, 151, 0.1)');

        const gradient4 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient4.addColorStop(0, 'rgba(156, 136, 255, 0.6)');
        gradient4.addColorStop(1, 'rgba(156, 136, 255, 0.1)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'P1 - Gawat Dan Darurat',
                        data: p1Data,
                        borderColor: candyRed,
                        backgroundColor: gradient1,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'P2 - Gawat Tidak Darurat',
                        data: p2Data,
                        borderColor: candyYellow,
                        backgroundColor: gradient2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'P3 - Tidak Gawat Dan Tidak Darurat',
                        data: p3Data,
                        borderColor: candyGreen,
                        backgroundColor: gradient3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'P4 - Meninggal',
                        data: p4Data,
                        borderColor: candyPurple,
                        backgroundColor: gradient4,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Laporan Kunjungan Pasien Dalam 1 Tahun (per Bulan)'
                    }
                }
            }
        });
    </script>
</body>

</html>