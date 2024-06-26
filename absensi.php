<?php
include 'config.php';

$default_month = '2022-01'; 
$month = isset($_GET['month']) ? $_GET['month'] : $default_month;

$start_date = date("Y-m-01", strtotime($month));
$end_date = date("Y-m-t", strtotime($month));

$sql = "SELECT * FROM absensi WHERE tgl BETWEEN '$start_date' AND '$end_date'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
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
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
        }
        nav {
            text-align: center;
            margin-bottom: 20px;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Laporan Absensi</h1>

    <nav>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="grafik.php">Grafik</a></li>
        </ul>
    </nav>
    </header>


    <h1>Pilih Periode</h1>
    <form method="GET" action="">
        <label for="month">Pilih Bulan:</label>
        <input type="month" id="month" name="month" value="<?php echo htmlspecialchars($month); ?>" required>
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
        echo "<p>Tidak ada data untuk bulan $month.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
