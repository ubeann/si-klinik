<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Medis</title>
    <link rel="stylesheet" href="css/resume.css">
</head>
<body>
    <div class="container">
        <h2>Resume Medis</h2>
        <form method="POST" action="resume.php">
        <form>
            <div class="row">
                <label>No. RM:</label><input type="text" name="nomerRM">
            </div>
            <div class="row">
                <label>Nama pasien</label><input type="text" name="nama"> 
            </div>
            <div class="row">
                <label>Tanggal Lahir</label><input type="date" name="tglLahir">
                <label>Umur</label><input type="int" name="umur">
            </div>
            <div class="row">
                <label for="jeniskelamin">Jenis Kelamin</label>
                <input type="radio" id="jeniskelaminL" name="jenis kelamin" value="L">
                <label for="jeniskelamin">L</label>
                <input type="radio" id="jeniskelaminL" name="jenis kelamin" value="P">
                <label for="jeniskelamin">P</label> 
                <label for="tglDaftar">Tanggal Daftar</label>
                <input type="date" id="tglDaftar" name="tglDaftar">
            </div>
            <div class="row">
                <label>Diagnosa Awal</label><input type="text" name="diagnosaawal">
                <label>ICD-10:</label><input type="varchar" name="kodeawal">
            </div>
            <div class="row">
                <label>Diagnosa Utama</label><input type="text" name="diagnosautama">
                <label>ICD-10:</label><input type="varchar" name="kodeutama">
            </div>
            <div class="row">
                <label>Anamnesis</label><textarea name="anamnesis"></textarea>
            </div>
            <div class="row">
                <label>Pemeriksaan Fisik</label><textarea name="pemeriksaanfisik"></textarea>
            </div>
            <div class="row">
                <label>Obat yang diresepkan</label><textarea name="obat"></textarea>
            </div>
            <div class="row">
                <label>Pengobatan atau tindak lanjut</label><textarea name="tindakan"></textarea>
            </div>
            <div class="row">
                <label>Status Pengisian RM</label><textarea name="statusrm"></textarea>
            </div>
            <div class="signature-section">
                <p>Tasikmalaya, <span class="date">29 Februari</span> 2025</p>
                <div class="signature">
                    <img src="property/download-removebg-preview.png" alt="Signature" class="signature-image">
                    <p>(dr. Jovan Sp. Assasin)</p>
                </div>
            </div>
            <div class="buttons">
                <a href="index.php"><button type="reset">Batal</button>
                <a href="index.php"><button type="submit">Simpan</button></a>
            </div>
        </form>
    </div>
</body>
</html>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pendaftaran";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomerRM = $_POST['nomerRM'];
    $nama = $_POST['nama'];
    $tglLahir = $_POST['tglLahir'];
    $umur = $_POST['umur'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $tglDaftar = $_POST['tglDaftar'];
    $diagnosaawal = $_POST['diagnosaawal'];
    $kodeawal = $_POST['kodeawal'];
    $diagnosautama = $_POST['diagnosautama'];
    $kodeutama = $_POST['kodeutama'];
    $anamnesis = $_POST['anamnesis'];
    $pemeriksaanfisik = $_POST['pemeriksaanfisik'];
    $obat = $_POST['obat'];
    $tindakan = $_POST['tindakan'];
    $statusrm = $_POST['statusrm'];

    $sql = "INSERT INTO pendaftaran (nomerRM, nama, tglLahir, umur, jeniskelamin, tglDaftar, diagnosaawal, kodeawal, diagnosautama, kodeutama, anamnesis, pemeriksaanfisik, obat, tindakan, statusrm)
            VALUES ('$nomerRM', '$nama', '$tglLahir', '$umur', '$jeniskelamin', '$tglDaftar', '$diagnosaawal', '$kodeawal', '$diagnosautama', '$kodeutama', '$anamnesis', '$pemeriksaanfisik', '$obat','$tindakan','$statusrm')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
