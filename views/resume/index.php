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
    <link rel="stylesheet" href="<?= asset('css/resume/index.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <img src="<?= asset('assets/logo.png') ?>" alt="Klinik Logo">
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
            <div>
                <!-- Download CSV Button -->
                <a href="<?= route('resume/download') ?>" class="download-button">
                    <i class="fas fa-download"></i> Unduh Data Pasien
                </a>
            </div>
            <div>
                <form action="<?= route('resume') ?>" method="get">
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
                    <th>Jenis Bencana</th>
                    <th>Jenis Cedera</th>
                    <th>Anamnesis</th>
                    <th>Diagnosis</th>
                    <th>Terapi</th>
                    <th>Tindak Lanjut</th>
                    <th>Status RM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient) : ?>
                    <tr>
                        <td><?= $patient['medical_record_number'] ?></td>
                        <td><?= $patient['full_name'] ?></td>
                        <td>
                            <?php if ($patient['disaster_type'] === 'earthquake') : ?>
                                Gempa Bumi
                            <?php elseif ($patient['disaster_type'] === 'tsunami') : ?>
                                Tsunami
                            <?php elseif ($patient['disaster_type'] === 'flood') : ?>
                                Banjir
                            <?php elseif ($patient['disaster_type'] === 'landslide') : ?>
                                Tanah Longsor
                            <?php elseif ($patient['disaster_type'] === 'fire') : ?>
                                Kebakaran
                            <?php elseif ($patient['disaster_type'] === 'epidemic') : ?>
                                Wabah
                            <?php elseif ($patient['disaster_type'] === 'other') : ?>
                                Lain-lain
                            <?php else : ?>
                                -
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if ($patient['injury_type'] === 'blunt_force') : ?>
                                Tumpul
                            <?php elseif ($patient['injury_type'] === 'sharp_object') : ?>
                                Tajam
                            <?php elseif ($patient['injury_type'] === 'gunshot') : ?>
                                Peluru
                            <?php elseif ($patient['injury_type'] === 'burn') : ?>
                                Bakar
                            <?php elseif ($patient['injury_type'] === 'poisoning') : ?>
                                Keracunan
                            <?php elseif ($patient['injury_type'] === 'drowning') : ?>
                                Tenggelam
                            <?php elseif ($patient['injury_type'] === 'asphyxia') : ?>
                                Afiksia
                            <?php elseif ($patient['injury_type'] === 'other') : ?>
                                Lain-lain
                            <?php else : ?>
                                -
                            <?php endif ?>
                        </td>
                        <td><?= $patient['anamnesis'] ?? '-' ?></td>
                        <td><?= $patient['diagnosis'] ?? '-' ?></td>
                        <td><?= $patient['therapy'] ?? '-' ?></td>
                        <td><?= $patient['actions_taken'] ?? '-' ?></td>
                        <td>
                            <?php if ($patient['status'] === 'not-filled') : ?>
                                <span style="color: red;">Belum Diisi</span>
                            <?php elseif ($patient['status'] === 'incomplete') : ?>
                                <span style="color: orange;">Belum Dilengkapi</span>
                            <?php else : ?>
                                <span style="color: green;">Lengkap</span>
                            <?php endif ?>
                        </td>
                        <td>
                            <a href="<?= route('resume/form?id=' . $patient['id']) ?>" class="edit-button"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($patients)) : ?>
                    <tr>
                        <td colspan="10">No patients found, please create a new patient first</td>
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