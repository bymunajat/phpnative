<?php
include 'config.php';

// Inisialisasi variabel bulan dengan nilai default atau dari input pengguna
$default_month = '2022-01'; // Nilai default bulan Januari 2022
$month = isset($_GET['month']) ? $_GET['month'] : $default_month;

// Hitung tanggal awal dan akhir bulan berdasarkan bulan yang dipilih
$start_date = date("Y-m-01", strtotime($month));
$end_date = date("Y-m-t", strtotime($month));

// Query untuk mengambil data absensi berdasarkan rentang tanggal
$sql = "SELECT * FROM absensi WHERE tgl BETWEEN '$start_date' AND '$end_date'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .M { background-color: red; }
        .P1 { background-color: orange; }
        .TK { background-color: brown; }
        .HM { background-color: yellow; }
    </style>
</head>
<body>
    <h1>Pilih Periode Laporan Absensi</h1>
    <form method="GET" action="">
        <label for="month">Pilih Bulan:</label>
        <input type="month" id="month" name="month" value="<?php echo $month; ?>" required>
        <input type="submit" value="Tampilkan Laporan">
    </form>

    <h1>Laporan Absensi</h1>

    <?php
    if ($result === false) {
        // Query error
        echo "Error: " . $conn->error;
    } elseif ($result->num_rows > 0) {
        // Data ditemukan, tampilkan tabel
        echo "<table><tr><th>Tanggal</th><th>Kode Absen</th><th>Karyawan</th><th>HKE</th></tr>";
        while($row = $result->fetch_assoc()) {
            $hke = in_array($row['kodeabsen'], ['KJA', 'KJI']) ? 'Ya' : 'Tidak';
            $color_class = '';
            switch ($row['kodeabsen']) {
                case 'M':
                    $color_class = 'M';
                    break;
                case 'P1':
                    $color_class = 'P1';
                    break;
                case 'TK':
                    $color_class = 'TK';
                    break;
                case 'HM':
                    $color_class = 'HM';
                    break;
                default:
                    $color_class = '';
                    break;
            }
            echo "<tr class='$color_class'><td>" . $row['tgl'] . "</td><td>" . $row['kodeabsen'] . "</td><td>" . $row['karyawan'] . "</td><td>" . $hke . "</td></tr>";
        }
        echo "</table>";
    } else {
        // Tidak ada data yang ditemukan untuk bulan yang dipilih
        echo "<p>Tidak ada data untuk bulan $month.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
