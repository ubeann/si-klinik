<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pengguna</title>
    <link rel="stylesheet" href="<?= asset('css/user/form.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="header">
            <div class="logo">
                <img src="<?= asset('assets/logo.png') ?>" alt="Klinik Logo">
                <div class="logo-text"></div>
            </div>
            <a href="<?= route('dashboard') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="0 0 30 20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </a>
        </div>
    </header>

    <h1>Form Edit Data Pengguna: <?= $user->getName() ?></h1>

    <?php if (isset($_SESSION['errors'])) : ?>
        <div class="errors">
            <ol>
                <?php foreach ($_SESSION['errors'] as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ol>
        </div>
    <?php endif ?>

    <form method="POST" action="<?= route('users/edit?id=' . $id) ?>">
        <div class="form-group">
            <label for="name">Nama</label>
            <input class="long" required type="text" id="name" name="name" value="<?= $user->getName() ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="long" required type="email" id="email" name="email" value="<?= $user->getEmail() ?>">
        </div>
        <div class="form-group">
            <label for="phone_number">Nomor HP</label>
            <input class="long" required type="text" id="phone_number" name="phone_number" value="<?= $user->getPhoneNumber() ?>">

            <label for="role">Jabatan</label>
            <select name="role" id="role" required>
                <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="doctor" <?= $user->getRole() === 'doctor' ? 'selected' : '' ?>>Dokter</option>
                <option value="officer" <?= $user->getRole() === 'officer' ? 'selected' : '' ?>>Petugas</option>
            </select>
        </div>
        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea id="address" name="address" rows="3" required><?= $user->getAddress() ?></textarea>
        </div>

        <div class="form-buttons">
            <a href="<?= route('users') ?>">
                <button style='font-size:20px' type="button">
                    Batal <i class='fas fa-trash-alt'></i>
                </button>
            </a>
            <button style='font-size:20px' type="submit">
                Simpan <i class='fas fa-save'></i>
            </button>
        </div>
    </form>

    <form method="POST" action="<?= route('users/change-password?id=' . $id) ?>" style="margin-top: 40px">
        <div class="form-group">
            <label for="password">Password Baru</label>
            <input class="long" type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input class="long" type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="form-buttons">
            <a href="<?= route('users') ?>">
                <button style='font-size:20px' type="button">
                    Batal <i class='fas fa-trash-alt'></i>
                </button>
            </a>
            <button style='font-size:20px' type="submit">
                Simpan <i class='fas fa-save'></i>
            </button>
        </div>
    </form>

    <!-- Clear session -->
    <?php unset($_SESSION['errors']) ?>
</body>
</html>