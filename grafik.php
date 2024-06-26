<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Summary Durasi Inputan LKM PT Kepo Februari 2023</title>
<!-- Load Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div style="width: 80%; margin: auto;">
    <h2 style="text-align: center;">Laporan Summary Durasi Inputan LKM PT Kepo Februari 2023</h2>
    <canvas id="attendanceChart"></canvas>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var durationData = {
        '1-5 Hari': 132,
        '6-10 Hari': 105,
        '11-15 Hari': 31,
        '16-20 Hari': 21,
        '21-25 Hari': 19,
        '26-30 Hari': 19
    };

    var labels = Object.keys(durationData);

    var chartData = {
        labels: labels,
        datasets: [{
            label: 'QTY ORANG',
            backgroundColor: '#3498db',
            borderColor: '#2980b9',
            borderWidth: 1,
            data: labels.map(function(label) {
                return durationData[label];
            })
        }]
    };

    var chartOptions = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        title: {
            display: true,
            text: 'Grafik Summary Durasi Inputan',
            fontSize: 18, 
            fontColor: '#333', 
            fontStyle: 'normal', 
            padding: 20 
        }
    };

    var ctx = document.getElementById('attendanceChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: chartOptions
    });

});
</script>

</body>
</html>
