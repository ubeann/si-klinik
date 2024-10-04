<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kasir</title>
    <link rel="stylesheet" href="<?= asset('css/cashier/register.css') ?>">
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
        <h1>Form Pendaftaran Kasir</h1><br><br><br><br>
        <form method="POST" action="<?= route('cashier/register') ?>">
            <div class="row">
                <label>No. RM</label>
                <input type="text" value="P20637022019">

                <label>Poli</label>
                <input type="text" value="Dalam">
            </div>
            <div class="row">
                <label>Nama Pasien</label>
                <input type="text" value="Jovvy">

                <label>Dokter</label>
                <input type="text" value="drg. Ernawati Sp.Ort">
            </div>
            <div class="row">
                <label>Jenis Kelamin</label>
                <input type="text" value="Laki - Laki">

                <label>NIK</label>
                <input type="text" value="321234567898">
            </div>
            <div class="row">
                <label>Alamat</label>
                <input type="text" value="Perum Salsabila">

                <label>Jaminan</label>
                <input type="text" value="Umum">
            </div>
            <div class="row">
                <label>No. HP</label>
                <input type="text" value="0812xxxx1861">

                <label>Tanggal Kunjungan</label>
                <input type="text" value="22-08-2024">
            </div>

            <div class="total-section">
                <label>TOTAL</label>
                <input type="text" value="RP.100.000">
            </div>

            <div class="buttons">
                <button type="reset" class="cancel-button">Batal</button>
                <button type="submit" class="pay-button">Bayar</button>
            </div>
        </form>
    </div>
</body>

</html>