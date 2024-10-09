<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metadata Epidemiologi & Data Pasien Satuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1, h3 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #4CAF50;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"], input[type="number"], input[type="date"] {
            padding: 10px;
            margin: 5px 0;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
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

    <!-- Form Input Data Pasien Satuan -->
    <h3>Input Data Pasien Satuan</h3>
    <form id="form-pasien">
        <label for="nama_pasien">Nama Pasien:</label>
        <input type="text" id="nama_pasien" placeholder="Masukkan nama pasien" required>

        <label for="no_identitas">No. Identitas (KTP/Passport):</label>
        <input type="text" id="no_identitas" placeholder="Masukkan nomor identitas pasien" required>

        <label for="umur">Umur Pasien:</label>
        <input type="number" id="umur" placeholder="Masukkan umur pasien" required>

        <label for="jenis_kelamin">Jenis Kelamin:</label>
        <input type="text" id="jenis_kelamin" placeholder="Laki-laki/Perempuan" required>

        <label for="alamat">Alamat Pasien:</label>
        <input type="text" id="alamat" placeholder="Masukkan alamat pasien" required>

        <label for="diagnosis">Diagnosis:</label>
        <input type="text" id="diagnosis" placeholder="Diagnosis penyakit pasien" required>

        <label for="tanggal_diagnosis">Tanggal Diagnosis:</label>
        <input type="date" id="tanggal_diagnosis" required>

        <button type="submit">Tambahkan Data Pasien</button>
    </form>

    <!-- Tabel untuk menampilkan data pasien yang dimasukkan -->
    <h3>Data Pasien yang Diinput</h3>
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

    <div class="export-options">
        <h3>Ekspor Data</h3>
        <button onclick="exportData('csv')">Ekspor ke CSV</button>
        <button onclick="exportData('xlsx')">Ekspor ke XLSX</button>
        <button onclick="exportData('json')">Ekspor ke JSON</button>
    </div>
</div>

<script>
    const formPasien = document.getElementById('form-pasien');
    const pasienTable = document.getElementById('pasienTable').getElementsByTagName('tbody')[0];

    // Fungsi untuk menambahkan data pasien ke tabel
    formPasien.addEventListener('submit', function(e) {
        e.preventDefault();

        // Ambil nilai dari form input pasien
        const namaPasien = document.getElementById('nama_pasien').value;
        const noIdentitas = document.getElementById('no_identitas').value;
        const umur = document.getElementById('umur').value;
        const jenisKelamin = document.getElementById('jenis_kelamin').value;
        const alamat = document.getElementById('alamat').value;
        const diagnosis = document.getElementById('diagnosis').value;
        const tanggalDiagnosis = document.getElementById('tanggal_diagnosis').value;

        // Tambahkan baris baru ke tabel pasien
        const row = pasienTable.insertRow();
        row.insertCell(0).innerText = namaPasien;
        row.insertCell(1).innerText = noIdentitas;
        row.insertCell(2).innerText = umur;
        row.insertCell(3).innerText = jenisKelamin;
        row.insertCell(4).innerText = alamat;
        row.insertCell(5).innerText = diagnosis;
        row.insertCell(6).innerText = tanggalDiagnosis;

        // Tambahkan tombol hapus
        const aksiCell = row.insertCell(7);
        const deleteButton = document.createElement('button');
        deleteButton.innerText = "Hapus";
        deleteButton.className = "delete-btn";
        deleteButton.onclick = function() {
            pasienTable.deleteRow(row.rowIndex - 1);
        };
        aksiCell.appendChild(deleteButton);

        // Kosongkan form setelah data pasien ditambahkan
        formPasien.reset();
    });

    // Fungsi untuk mengekspor data (dummy alert)
    function exportData(format) {
        alert("Ekspor data dalam format " + format + " sedang diproses.");
        // Logika ekspor data akan ditambahkan di sini.
    }
</script>

</body>
</html>