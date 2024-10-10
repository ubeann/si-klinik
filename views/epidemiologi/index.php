<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metadata Epidemiologi & Data Pasien Satuan</title>
    <link rel="stylesheet" href="<?= asset('css/epidemiologi/main.css') ?>">
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1>Metadata Epidemiologi & Input Data Pasien Satuan</h1>

        <!-- Tabel Metadata Epidemiologi -->
        <table>
            <thead>
                <tr>
                    <th>ID Epidemiologi</th>
                    <th>Nama Epidemiologi</th>
                    <th>Kode</th>
                    <th>Kategori</th>
                    <th>Status Penularan</th>
                    <th>Jumlah Kasus</th>
                    <th>Jumlah Kematian</th>
                    <th>Wilayah Terdampak</th>
                    <th>Tanggal Awal Kasus</th>
                    <th>Update Terakhir</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>202</td>
                    <td>Flu Burung (H5N1)</td>
                    <td>EPD202</td>
                    <td>Penyakit Menular</td>
                    <td>Tinggi</td>
                    <td>1500</td>
                    <td>550</td>
                    <td>Asia, Eropa Timur</td>
                    <td>2003-11-25</td>
                    <td>2023-08-01</td>
                </tr>
            </tbody>
        </table>

        <hr>

        <!-- Tabel untuk menampilkan data pasien yang dimasukkan -->
        <h2 style="margin-bottom: 0;">Data Pasien yang Diinput</h2>

        <div style="display: flex; justify-content: space-between;">
            <div style="display: flex; gap: 10px;">
                <a class="btn-download" target="_blank">Ekspor ke CSV</a>
                <a class="btn-download" target="_blank">Ekspor ke XLSX</a>
            </div>
            <a class="btn-create" href="<?= route('epidemiologi/form-register') ?>">Tambahkan Data Pasien</a>
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

        <table id="pasienTable">
            <thead>
                <tr>
                    <th>Nama Pasien</th>
                    <th>No. Identitas</th>
                    <th>Umur</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Diagnosis</th>
                    <th>Tanggal Diagnosis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($epidemiologis as $epidemiologi) : ?>
                    <tr>
                        <td><?= $epidemiologi['full_name'] ?></td>
                        <td><?= $epidemiologi['national_id_number'] ?></td>
                        <td><?= $epidemiologi['age'] ?></td>
                        <td><?= $epidemiologi['gender'] === 'l' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <td><?= $epidemiologi['address'] ?></td>
                        <td><?= $epidemiologi['diagnosis'] ?></td>
                        <td><?= date('d M Y', strtotime($epidemiologi['diagnosis_date'])) ?></td>
                        <td style="text-align: center;">
                            <a href="<?= route('epidemiologi/form-edit?id=' . $epidemiologi['id']) ?>" class="edit-button"><i class="fas fa-edit"></i></a>
                            <a href="<?= route('epidemiologi/delete?id=' . $epidemiologi['id']) ?>" class="delete-button" onclick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($epidemiologis)) : ?>
                    <tr>
                        <td colspan="8">No records found, please input a new patient first</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Clear session -->
    <?php unset($_SESSION['errors'], $_SESSION['success']) ?>
</body>

</html>