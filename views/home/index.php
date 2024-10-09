<?php

use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Darurat Bencana</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= asset('css/home/index.css') ?>">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><img src="<?= asset('assets/logo.png') ?>"></li>
                <li style="font-size:xx-large; margin-top: 25px">SISTEM DARURAT BENCANA</li>
                <li><img src="<?= asset('assets/logo.png') ?>" style="opacity: 0;"></li>
            </ul>
        </nav>
    </header>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="<?= route('register') ?>" method="POST">
                <h1>Buat ID baru</h1>
                <input type="text" placeholder="Name" name="name" required />
                <?php if (isset($_SESSION['errors']['name'])): ?>
                    <small class="error"><?= $_SESSION['errors']['name'] ?></small>
                <?php endif; ?>
                <input type="email" placeholder="Email" name="email" required />
                <?php if (isset($_SESSION['errors']['email'])): ?>
                    <small class="error"><?= $_SESSION['errors']['email'] ?></small>
                <?php endif; ?>
                <input type="password" placeholder="Password" name="password" required />
                <?php if (isset($_SESSION['errors']['password'])): ?>
                    <small class="error"><?= $_SESSION['errors']['password'] ?></small>
                <?php endif; ?>
                <select name="role" id="role">
                    <option value="admin">Admin</option>
                    <option value="doctor">Dokter</option>
                    <option value="officer">Petugas</option>
                </select>
                <?php if (isset($_SESSION['errors']['role'])): ?>
                    <small class="error"><?= $_SESSION['errors']['role'] ?></small>
                <?php endif; ?>
                <button type="submit">Daftar</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <!-- <form action="page2.php"> -->
            <form action="<?= route('login') ?>" method="POST">
                <h1>Halaman Masuk</h1><br>
                <?php if (isset($_SESSION['success'])): ?>
                    <small class="success"><?= $_SESSION['success'] ?></small>
                <?php endif; ?>
                <?php if (isset($_SESSION['errors']['auth'])): ?>
                    <small class="error"><?= $_SESSION['errors']['auth'] ?></small>
                <?php endif; ?>
                <?php if (isset($_SESSION['errors']['login'])): ?>
                    <small class="error"><?= $_SESSION['errors']['login'] ?></small>
                <?php endif; ?>
                <input type="email" placeholder="Email" name="email" required />
                <input type="password" placeholder="Password" name="password" required />
                <button>Masuk</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Daftar Akun!</h1>
                    <p>isi sesuai dengan data personal anda</p>
                    <button class="ghost" id="signIn">Punya Akun?</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Selamat Datang!</h1>
                    <p style="text-align: left; margin-left: 20px;">Sistem Darurat Bencana sederhana
                        dikembangkan oleh mahasiswa 3A
                        Rekam Medis dan Informasi Kesehatan
                        Poltekkes Kemenkes Tasikmalaya</p>
                    <button class="ghost" id="signUp">Lupa ID atau Password</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= asset('js/main.js') ?>"></script>
</body>

</html>