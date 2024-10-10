<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Penyakit/Bencana</title>
    <link rel="stylesheet" href="<?= asset('css/disease/main.css') ?>">
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
        <h1>Index Penyakit/Bencana</h1>

        <div style="display: flex; justify-content: space-between;">
            <div style="display: flex; gap: 10px;">
                <a class="btn-download" href="<?= route('disease/download/csv') ?>" target="_blank">Ekspor ke CSV</a>
            </div>
            <a class="btn-create" href="<?= route('disease/form-register') ?>">Tambahkan Data</a>
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
                    <th>Kode</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Tingkat Keparahan</th>
                    <th>Wilayah Terdampak</th>
                    <th>Tanggal Kejadian</th>
                    <th>Jumlah Korban</th>
                    <th>Status</th>
                    <th>Sejarah</th>
                    <th>Kontak</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($diseases as $disease) : ?>
                    <tr>
                        <td><?= $disease['name'] ?></td>
                        <td><?= $disease['code'] ?></td>
                        <td>
                            <?php if ($disease['category'] === 'natural-disaster') : ?>
                                Bencana Alam
                            <?php elseif ($disease['category'] === 'epidemic') : ?>
                                Epidemi
                            <?php elseif ($disease['category'] === 'disease') : ?>
                                Penyakit
                            <?php endif; ?>
                        </td>
                        <td><?= $disease['description'] ?></td>
                        <td>
                            <?php if ($disease['severity_level'] === 'low') : ?>
                                Rendah
                            <?php elseif ($disease['severity_level'] === 'medium') : ?>
                                Sedang
                            <?php elseif ($disease['severity_level'] === 'high') : ?>
                                Tinggi
                            <?php elseif ($disease['severity_level'] === 'very-high') : ?>
                                Sangat Tinggi
                            <?php endif; ?>
                        </td>
                        <td><?= $disease['affected_region'] ?></td>
                        <td><?= $disease['incident_date'] ?></td>
                        <td><?= number_format($disease['victim_count']) ?></td>
                        <td>
                            <?php if ($disease['status'] === 'active') : ?>
                                Aktif
                            <?php elseif ($disease['status'] === 'inactive') : ?>
                                Tidak Aktif
                            <?php endif; ?>
                        </td>
                        <td><?= $disease['history'] ?></td>
                        <td><?= $disease['contact_information'] ?></td>
                        <td style="text-align: center;">
                            <a href="<?= route('disease/form-edit?id=' . $disease['id']) ?>" class="edit-button"><i class="fas fa-edit"></i></a>
                            <a href="<?= route('disease/delete?id=' . $disease['id']) ?>" class="delete-button" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($diseases)) : ?>
                    <tr>
                        <td colspan="12">No records found, please input a new disease first</td>
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