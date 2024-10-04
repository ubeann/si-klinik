<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pendaftaran WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tglLahir = $_POST['tglLahir'];
    $telpon = $_POST['telpon'];

    $sql = "UPDATE pendaftaran SET nama='$nama', alamat='$alamat', tglLahir='$tglLahir', telpon='$telpon' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    Nama: <input type="text" name="nama" value="<?php echo $row['nama']; ?>"><br>
    Alamat: <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>"><br>
    Tgl Lahir: <input type="date" name="tglLahir" value="<?php echo $row['tglLahir']; ?>"><br>
    Telpon: <input type="text" name="telpon" value="<?php echo $row['telpon']; ?>"><br>
    <input type="submit" value="Update">
</form>
