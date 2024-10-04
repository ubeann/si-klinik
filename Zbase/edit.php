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
    $id = $_POST['id'];
    $nomerRM = $_POST['nomerRM'];
    $tglDaftar = $_POST['tglDaftar'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $tglLahir = $_POST['tglLahir'];
    $penjamin = $_POST['penjamin'];
    $telpon = $_POST['telpon'];
    $agama = $_POST['agama'];
    $pekerjaan = $_POST['pekerjaan'];
    $pendidikan = $_POST['pendidikan'];
    $statuspernikahan = $_POST['statuspernikahan'];

    $sql = "UPDATE pendaftaran SET 
            nomerRM = '$nomerRM', 
            tglDaftar = '$tglDaftar', 
            nik = '$nik', 
            nama = '$nama', 
            alamat = '$alamat', 
            jeniskelamin = '$jeniskelamin', 
            tglLahir = '$tglLahir', 
            penjamin = '$penjamin', 
            telpon = '$telpon', 
            agama = '$agama', 
            pekerjaan = '$pekerjaan', 
            pendidikan = '$pendidikan', 
            statuspernikahan = '$statuspernikahan'
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
    <link rel="stylesheet" href="css/pendaftaran.css">
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
            
            <label for="tglDaftar">Tgl. Daftar</label>
            <input type="date" id="tglDaftar" name="tglDaftar" value="<?php echo $row['tglDaftar']; ?>">
            
            <label for="nik">NIK</label>
            <input type="text" id="nik" name="nik" value="<?php echo $row['nik']; ?>">
        </div>
        
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" class="long" value="<?php echo $row['nama']; ?>">
        </div>
        
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="varchar" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>">
        </div>
        
        <div class="form-group">
            <label for="jeniskelamin">Jenis Kelamin</label>
            <input type="radio" id="jeniskelaminL" name="jeniskelamin" value="L">
            <label for="jeniskelamin">L</label>
            <input type="radio" id="jeniskelaminP" name="jeniskelamin" value="P">
            <label for="jeniskelamin">P</label>
            
            <label for="tglLahir">Tgl. Lahir</label>
            <input type="date" id="tglLahir" name="tglLahir" value="<?php echo $row['tglLahir']; ?>">
        </div>
        
        <div class="form-group">
            <label for="penjamin">Penjamin</label>
            <input type="text" id="penjamin" name="penjamin" value="<?php echo $row['penjamin']; ?>">
            
            <label for="telpon">Telephone</label>
            <input type="text" id="telpon" name="telpon" value="<?php echo $row['telpon']; ?>">
        </div>
        
        <div class="form-group">
            <label for="agama">Agama</label>
            <input type="text" id="agama" name="agama" value="<?php echo $row['agama']; ?>">
            
            <label for="pekerjaan">Pekerjaan</label>
            <input type="text" id="pekerjaan" name="pekerjaan" value="<?php echo $row['pekerjaan']; ?>">
        </div>
        
        <div>
            <div class="form-group">
                <label for="pendidikan">Pendidikan</label>
                <input type="text" id="pendidikan" name="pendidikan" value="<?php echo $row['pendidikan']; ?>">
                
                <label for="statuspernikahan">Status Nikah</label>
                <input type="text" id="statuspernikahan" name="statuspernikahan" value="<?php echo $row['statuspernikahan']; ?>">

                <label for="statusrm">Status Rekam Medis</label>
                <input type="text" id="statusrm" name="statusrm">
            </div>
        <div class="form-buttons">
            <button style='font-size:20px' type="button">Batal <i class='fas fa-trash-alt'></i></button></a>
            <a href="pencarian.html"><button style='font-size:20px'>Simpan  <i class='fas fa-save' ></i></button></a>
        </div>
        </div>
    </form>
</form>
</body>
</html>