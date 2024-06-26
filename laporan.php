<?php
include 'config.php';

if (isset($_GET['month'])) {
    $month = $_GET['month'];
    $start_date = date("Y-m-26", strtotime($month . " -1 month"));
    $end_date = date("Y-m-25", strtotime($month));

    $sql = "SELECT * FROM absensi WHERE tgl BETWEEN '$start_date' AND '$end_date'";
    $result = $conn->query($sql);
}
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
    <h1>Laporan Absensi</h1>

    <?php
    if (isset($result) && $result->num_rows > 0) {
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
        echo "Tidak ada data untuk periode ini.";
    }

    $conn->close();
    ?>
</body>
</html>
