<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <link rel="stylesheet" href="<?= asset('css/patient/index.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <img src="<?= asset('assets/logo-si-klin.png') ?>" alt="Klinik Logo">
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
        <div class="header">
            <a href="<?= route('patients/form-register') ?>">
                <button>Buka Form</button>
            </a>
            <div>
                <form action="<?= route('users') ?>" method="get">
                    <label for="role">Filter:</label>
                    <select name="role" id="role">
                        <option value="all" <?= ($_GET['role'] ?? null) === 'all' ? 'selected' : '' ?>>Semua</option>
                        <option value="admin" <?= ($_GET['role'] ?? null) === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="doctor" <?= ($_GET['role'] ?? null) === 'doctor' ? 'selected' : '' ?>>Dokter</option>
                        <option value="officer" <?= ($_GET['role'] ?? null) === 'officer' ? 'selected' : '' ?>>Petugas</option>
                    </select>
                    <input type="text" placeholder="Pencarian..." name="search" value="<?= $_GET['search'] ?? '' ?>">
                    <button type="submit">Cari</button>
                </form>
            </div>
        </div>

        <?php if (isset($_SESSION['errors']['delete'])) : ?>
            <div class="errors">
                <span><?= $_SESSION['errors']['delete'] ?></span>
            </div>
        <?php endif ?>

        <?php if (isset($_SESSION['success'])) : ?>
            <div class="success">
                <span><?= $_SESSION['success'] ?></span>
            </div>
        <?php endif ?>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= strtoupper($user['role']) ?></td>
                        <td>
                            <a href="<?= route('patients/form-edit?id=' . $patient['id']) ?>" class="edit-button"><i class="fas fa-edit"></i></a>
                            <a href="<?= route('patients/delete?id=' . $patient['id']) ?>" class="delete-button" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)) : ?>
                    <tr>
                        <td colspan="4">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php foreach ($pagination as $link) : ?>
                <a href="<?= $link['url'] ?>"><?= $link['page'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Clear session -->
    <?php unset($_SESSION['errors'], $_SESSION['success']) ?>
</body>

</html>