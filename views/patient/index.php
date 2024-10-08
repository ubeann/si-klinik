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
                <form action="<?= route('patients') ?>" method="get">
                    <label for="status">Filter:</label>
                    <select name="status" id="status">
                        <option value="all" <?= ($_GET['status'] ?? null) === 'all' ? 'selected' : '' ?>>
                            Semua
                        </option>
                        <option value="not-filled" <?= ($_GET['status'] ?? null) === 'not-filled' ? 'selected' : '' ?>>
                            Belum Diisi
                        </option>
                        <option value="incomplete" <?= ($_GET['status'] ?? null) === 'incomplete' ? 'selected' : '' ?>>
                            Belum Dilengkapi
                        </option>
                        <option value="complete" <?= ($_GET['status'] ?? null) === 'complete' ? 'selected' : '' ?>>
                            Lengkap
                        </option>
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
                    <th>No. RM</th>
                    <th>Nama Pasien</th>
                    <th>Tgl. Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th width="200px">Alamat</th>
                    <th>Agama</th>
                    <th>Tgl. Daftar</th>
                    <th>Telepon</th>
                    <th>NIK</th>
                    <th>Status RM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient) : ?>
                    <tr>
                        <td><?= $patient['medical_record_number'] ?></td>
                        <td><?= $patient['full_name'] ?></td>
                        <td><?= date('d M Y', strtotime($patient['birth_date'])) ?></td>
                        <td><?= $patient['gender'] ==='l' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <td><?= $patient['address'] ?></td>
                        <td><?= strtoupper($patient['religion']) ?></td>
                        <td><?= date('d M Y', strtotime($patient['registration_date'])) ?></td>
                        <td><?= $patient['phone_number'] ?></td>
                        <td><?= $patient['national_id_number'] ?></td>
                        <td>
                            <?php if ($patient['status'] === 'not-filled') : ?>
                                <a href="<?= route('resume', ['id' => $patient['id']]) ?>" style="color: red; text-decoration: underline">Belum Diisi</a>
                            <?php elseif ($patient['status'] === 'incomplete') : ?>
                                <a href="<?= route('indexresume', ['id' => $patient['id']]) ?>" style="color: orange; text-decoration: underline">Belum Dilengkapi</a>
                            <?php else : ?>
                                <a href="<?= route('indexresume', ['id' => $patient['id']]) ?>" style="color: green; text-decoration: underline">Lengkap</a>
                            <?php endif ?>
                        </td>
                        <td>
                            <a href="<?= route('patients/form-edit?id=' . $patient['id']) ?>" class="edit-button"><i class="fas fa-edit"></i></a>
                            <a href="<?= route('patients/delete?id=' . $patient['id']) ?>" class="delete-button" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($patients)) : ?>
                    <tr>
                        <td colspan="8">No records found</td>
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