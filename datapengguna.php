<!DOCTYPE html>
<html lang="en">
<script src="https://kit.fontawesome.com/c2dc05efdd.js" crossorigin="anonymous"></script><meta charset="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Pengguna</title>
    <link rel="stylesheet" href="css/datapengguna.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><img src="property/siklin.png"></li>
                <li><a href="page2.php"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="0 0 30 20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="header">Kelola Data Pengguna</div>
        <div class="search-container">
            <input type="text" placeholder="Pencarian">
        </div>
        <div class="form-container">
            <div class="form-group">
                <label for="nama-petugas">Nama Petugas</label>
                <input type="text" id="nama-petugas" value="(nama)">

                <label for="email">Email</label>
                <input type="text" id="Email" value="(email)">

                <label for="username">Username</label>
                <input type="text" id="username" value="(username)">

                <label for="password">Password</label>
                <input type="password" id="password" value="*******">

                <label for="ulangi-password">Ulangi Password</label>
                <input type="password" id="ulangi-password" value="*******">
            </div>
            <div class="form-group">
                <label for="no-hp">No. HP</label>
                <input type="text" id="no-hp" value="(12 digit no telfon)">

                <div class="radio-group">
                    <label>Status :</label>
                    <label><input type="radio" name="status" value="petugas" checked> Petugas</label>
                    <label><input type="radio" name="status" value="dokter"> Dokter</label>
                </div><br>
                <a href="login.php">
                    <button class="btn">Batal <i class='fas fa-trash-alt'></i></button>
                </a>
                <a href="datapengguna.php">
                     <button class="btn">Edit <i class='fas fa-edit'></i></button>
                </a>
                <a href="page2.php">
                    <button class="btn">Simpan <i class='fas fa-save'></i></button>
                </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
