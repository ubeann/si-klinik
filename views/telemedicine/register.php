<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Telemedicine</title>
    <link rel="stylesheet" href="<?= asset('css/telemedicine/register.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
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
    </div>
</body>

<body>
    <h1>Form Pendaftaran Telemedicine</h1>
    <form method="POST" action="<?= route('telemedicine/register') ?>">
        <div class="form-group">
            <label for="nomerRM">Nomer RM</label>
            <input type="text" id="nomerRM">
            <label for="tglDaftar">Tgl. Daftar</label>
            <input type="date" id="tglDaftar">
            <label for="nik">NIK</label>
            <input type="text" id="nik">
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" class="long">
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="sex">Sex</label>
            <input type="radio" id="sexL" name="sex" value="L">
            <label for="sexL">L</label>
            <input type="radio" id="sexP" name="sex" value="P">
            <label for="sexP">P</label>
            <label for="tglLahir">Tgl. Lahir</label>
            <input type="date" id="tglLahir">
        </div>
        <div class="form-group">
            <label for="penjamin">Penjamin</label>
            <input type="text" id="penjamin">
            <label for="noPeserta">No. Peserta</label>
            <input type="text" id="noPeserta">
        </div><br>
        <div class="form-group">
            <label for="telpon">Telpon</label>
            <input type="text" id="telpon">
            <label for="agama">Agama</label>
            <input type="text" id="agama">
        </div>
        <div class="form-buttons">
            <a href="<?= route('telemedicine') ?>">
                <button style='font-size:20px' type="button">
                    Batal <i class='fas fa-trash-alt'></i>
                </button>
            </a>
            <button style='font-size:20px' type="submit">
                Simpan <i class='fas fa-save'></i>
            </button>
        </div>
    </form>
</body>

</html>