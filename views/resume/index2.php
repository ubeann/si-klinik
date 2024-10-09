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

    $sql = "UPDATE pendaftaran SET
            nomerRM = '$nomerRM',
            nama = '$nama',
            tglLahir = '$tglLahir',
            umur = '$umur',
            jeniskelamin = '$jeniskelamin',
            tglDaftar = '$tglDaftar',
            diagnosaawal = '$diagnosaawal',
            kodeawal = '$kodeawal',
            diagnosautama = '$diagnosautama',
            kodeutama = '$kodeutama',
            anamnesis = '$anamnesis',
            pemeriksaanfisik = '$pemeriksaanfisik',
            obat = '$obat'
            tindakan = '$tindakan'
            statusrm = '$statusrm'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pendaftaran WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit();
    }
} else {
    echo "No ID provided";
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script><meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien</title>
    <link rel="stylesheet" href="css/indexresume.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="property/siklin.png" alt="Logo">
            <div class="logo-text"></div>
        </div>
            <a href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="0 0 30 20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
        </div>
    </div>
</body>
</html>
<body>
    <h1>Form Edit data pasien</h1>
    <form method="POST" action="edit.php">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="container">
        <div class="form-group">
            <label for="nomerRM">Nomer RM</label>
            <input type="text" id="nomerRM" name="nomerRM" value="<?php echo $row['nomerRM']; ?>">
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" class="long" value="<?php echo $row['nama']; ?>">
        </div>
        <div class="form-group">
    <label for="tglLahir">Tgl. Lahir</label>
    <input type="date" id="tglLahir" name="tglLahir" value="<?php echo $row['tglLahir']; ?>">

    <label for="umur">Umur</label>
    <?php
    $birthday = $row['tglLahir'];
    $age = calculateAge($birthday);
    ?>
    <input type="int" id="umur" name="umur" value="<?php echo $age; ?>">
</div>

<?php
function calculateAge($birthday) {
    $today = date("Y-m-d");
    $age = date_diff(date_create($birthday), date_create($today));
    return $age->y;
}
?>

        <div class="form-group">
        <label for="jeniskelamin">Jenis Kelamin</label>
            <span class="required">*</span>
            <input type="radio" id="jeniskelaminL" name="jeniskelamin" value="L">
            <label for="jeniskelamin">L</label>
            <input type="radio" id="jeniskelaminP" name="jeniskelamin" value="P">
            <label for="jeniskelamin">P</label>

            <label for="tglDaftar">Tgl. Daftar</label>
            <input type="date" id="tglDaftar" name="tglDaftar" value="<?php echo $row['tglDaftar']; ?>">
        </div>

        <div class="form-group">
            <label for="diagnosaawal">Diagnosa Awal</label>
            <input type="text" id="diagnosaawal" name="diagnosaawal" value="<?php echo $row['diagnosaawal']; ?>">

            <label for="kodeawal">ICD 10</label>
            <input type="varchar" id="kodeawal" name="kodeawal" value="<?php echo $row['kodeawal']; ?>">
        </div>

        <div class="form-group">
        <label for="diagnosautama">Diagnosa Utama</label>
            <input type="text" id="diagnosautama" name="diagnosautama" value="<?php echo $row['diagnosautama']; ?>">

            <label for="kodeutama">ICD 10</label>
            <input type="varchar" id="kodeutama" name="kodeutama" value="<?php echo $row['kodeutama']; ?>">
        </div>

        <div class="form-group">
            <label for="anamnesis">Anamnesis</label>
            <input type="text" id="anamnesis" name="anamnesis" value="<?php echo $row['anamnesis']; ?>">
        </div>
        <div class="form-group">
            <label for="pemeriksaanfisik">Pemeriksaan Fisik</label>
            <input type="varchar" id="pemeriksaanfisik" name="pemeriksaanfisik" value="<?php echo $row['pemeriksaanfisik']; ?>">
        </div>
        <div class="form-group">
            <label for="obat">Obat yang diresepkan</label>
            <input type="varchar" id="obat" name="obat" value="<?php echo $row['obat']; ?>">
        </div>
        <div class="form-group">
            <label for="tindakan">Pengobatan atau tindak lanjut</label>
            <input type="varchar" id="tindakan" name="tindakan" value="<?php echo $row['tindakan']; ?>">
        </div>
            <div class="form-group">
                <label for="statusrm">Status pengisian RM</label>
                <input type="text" id="statusrm" name="statusrm" value="<?php echo $row['statusrm']; ?>">
            </div>
        <div class="signature-section">
            <p>Tasikmalaya, <span class="date">29 Februari</span> 2025</p>
            <div class="signature"><img src="property/download-removebg-preview.png" alt="Signature" class="signature-image">
            <p>(dr. Jovan Sp. Assasin)</p>
        </div>
        <div class="form-buttons">
            <a href="index.php"><button style='font-size:20px' type="button">Batal <i class='fas fa-trash-alt'></i></button></a>
            <a href="index.php"><button style='font-size:20px'>Simpan  <i class='fas fa-save' ></i></button></a>
        </div>
        </div>
    </form>
</form>
</body>
</html>