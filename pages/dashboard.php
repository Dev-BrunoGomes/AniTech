<?php
include "../config/dbclass.php";
session_start();
if ($_SESSION['logado'] != true) {

    $_SESSION['msg'] = "Você precisa estar logado para acessar essa página";
    header('location: login.php');
}
$obj = new Dbc();
$conn = $obj->connect();

//escrevendo requisição ao banco
$sqlgalinha = "SELECT COUNT(*) AS total FROM animais WHERE especie = 'galinha'";

$result = mysqli_query($conn, $sqlgalinha);
$row = mysqli_fetch_assoc($result);
$galinhas = $row['total'];

$sqlvaca = "SELECT COUNT(*) AS total FROM animais WHERE especie = 'vaca'";

$result = mysqli_query($conn, $sqlvaca);
$row = mysqli_fetch_assoc($result);
$vacas = $row['total'];

?>
<!DOCTYPE html>
<html>

<head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load Charts and the corechart package.
        google.charts.load('current', {
            'packages': ['corechart']
        });

        // Draw the pie chart for Sarah's pizza when Charts is loaded.
        google.charts.setOnLoadCallback(drawSarahChart);

        // Callback that draws the pie chart for Sarah's pizza.
        function drawSarahChart() {

            // Create the data table for Sarah's pizza.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['Vacas', <?php echo $vacas ?>],
                ['Galinhas', <?php echo $galinhas ?>]
            ]);

            // Set options for Sarah's pie chart.
            var options = {

                title: 'Animais cadastrados',
                titleTextStyle: {
                    fontSize: 25
                },
                width: 650,
                height: 450,
                chartArea: {
                    left: '20%',
                    top: '20%',
                    width: '90%',
                    height: '90%'
                }
            };

            // Instantiate and draw the chart for Sarah's pizza.
            var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
            chart.draw(data, options);
        }
    </script>
    <style>
        .center {
            left: 100px;
        }

        h2 {
            font-family: Helvetica, sans-serif;
            color: #fefefe;
            text-shadow: 2px 2px 8px #000000;
        }
    </style>
</head>

<body>

    <h2 class="center">Bem vindo ao AniTech</h2><br><br>
    <!--Table and divs that hold the pie charts-->
    <div class="container">
        <div class="center" id="piechart_div" style="left: 100px;"></div>
    </div>
</body>

</html>