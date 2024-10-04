<?php
include 'config.php';

$sql = "SELECT * FROM pendaftaran";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Nomer RM</th>
                <th>Alamat</th>
                <th>Tgl Lahir</th>
                <th>Telpon</th>
                <th>Actions</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['nik']}</td>
                <td>{$row['nomerRM']}</td>
                <td>{$row['alamat']}</td>
                <td>{$row['tglLahir']}</td>
                <td>{$row['telpon']}</td>
                <td>
                    <a href='update.php?id={$row['id']}'>Edit</a> | 
                    <a href='delete.php?id={$row['id']}'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}
$conn->close();
?>
