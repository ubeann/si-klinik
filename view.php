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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Details</title>
    <link rel="stylesheet" href="pendaftaran.css">
</head>
<body>
    <h1>Patient Details</h1>
    <div class="patient-details">
        <p><strong>Nomer RM:</strong> <?php echo $row['nomerRM']; ?></p>
        <p><strong>Tgl. Daftar:</strong> <?php echo $row['tglDaftar']; ?></p>
        <p><strong>NIK:</strong> <?php echo $row['nik']; ?></p>
        <p><strong>Nama:</strong> <?php echo $row['nama']; ?></p>
        <p><strong>Alamat:</strong> <?php echo $row['alamat']; ?></p>
        <p><strong>Jenis Kelamin:</strong> <?php echo $row['jeniskelamin']; ?></p>
        <p><strong>Tgl. Lahir:</strong> <?php echo $row['tglLahir']; ?></p>
        <p><strong>Penjamin:</strong> <?php echo $row['penjamin']; ?></p>
        <p><strong>Telephone:</strong> <?php echo $row['telpon']; ?></p>
        <p><strong>Agama:</strong> <?php echo $row['agama']; ?></p>
        <p><strong>Pekerjaan:</strong> <?php echo $row['pekerjaan']; ?></p>
        <p><strong>Pendidikan:</strong> <?php echo $row['pendidikan']; ?></p>
        <p><strong>Status Nikah:</strong> <?php echo $row['statuspernikahan']; ?></p>
    </div>
    <button>asda<a href="index.php">Back to List</a></button>
    
</body>
</html>