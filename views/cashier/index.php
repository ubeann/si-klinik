<?php
use function App\Helpers\asset;
use function App\Helpers\route;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Klinik</title>
    <link rel="stylesheet" href="<?= asset('css/cashier/index.css') ?>">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><img src="<?= asset('assets/logo-si-klin.png') ?>" alt="Klinik Logo"></li>
                <li>
                    <a href="<?= route('dashboard') ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="0 0 30 20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="header">
            <h1>Kasir Klinik</h1>
        </div>

        <div class="form-container">
            <a href="<?= route('cashier/form-register') ?>"><button>Buka Form</button></a>
            <div class="total">Total: 0</div>
            <input type="text" placeholder="Pencarian...">
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Kelamin</th>
                        <th>alamat</th>
                        <th>No. Hp</th>
                        <th>Antrian</th>
                        <th>Dokter</th>
                        <th>NIK</th>
                        <th>Penjamin</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Jumlah Bayar</th>
                        <th>Status Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>Jovan</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>15</td>
                        <td>dr. Tri Sulistiyo Sp.KK</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>rafi</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>16</td>
                        <td>dr. Tri Sulistiyo Sp.KK</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>bayu</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>17</td>
                        <td>dr. Tri Sulistiyo Sp.KK</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>004</td>
                        <td>cina</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>18</td>
                        <td>dr. Tri Sulistiyo Sp.KK</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>005</td>
                        <td>dika</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>19</td>
                        <td>dr. Tri Sulistiyo Sp.KK</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>006</td>
                        <td>Simanjutak</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>20</td>
                        <td>dr. Tri Sulistiyo Sp.KK</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <td>007</td>
                        <td>rio</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>21</td>
                        <td>drg. Ernawati Sp.Ort</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>008</td>
                        <td>cegar</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>22</td>
                        <td>drg. Ernawati Sp.Ort</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>009</td>
                        <td>topik</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>23</td>
                        <td>drg. Ernawati Sp.Ort</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>010</td>
                        <td>Bintang</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>24</td>
                        <td>drg. Ernawati Sp.Ort</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td>011</td>
                        <td>Nabila</td>
                        <td>Laki-laki</td>
                        <td>Perum GSP</td>
                        <td>(No hp)</td>
                        <td>25</td>
                        <td>dr. Sari Sp.D</td>
                        <td>12345678</td>
                        <td>Umum</td>
                        <td>08-09-2024</td>
                        <td>Rp.100.000</td>
                        <td>Lunas</td>
                    </tr>
                    <tr>
                        <td colspan="12" style="text-align: center;">No data available</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <span>&lt;</span>
            <span>1 - 15</span>
            <span>&gt;</span>
        </div>
    </div>
</body>

</html>