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
                <!-- Data pasien yang dimasukkan akan ditampilkan di sini -->
            </tbody>
        </table>
    </div>
</body>

</html>