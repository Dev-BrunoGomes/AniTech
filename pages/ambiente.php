<?php
include "../config/dbclass.php";
session_start();
if ($_SESSION['logado'] != true) {

    $_SESSION['msg'] = "Você precisa estar logado para acessar essa página";
    header('location: login.php');
}
$obj = new Dbc();
$conn = $obj->connect();

$sqlout = "SELECT * FROM ambiente ORDER BY id DESC LIMIT 1";

//fazendo requisição e pegando resultado
$resulta = mysqli_query($conn, $sqlout);

//passando para array
$temperatures = mysqli_fetch_all($resulta, MYSQLI_ASSOC);

if (isset($_POST['edit'])) {

    $temp = $_POST['temp'];

    $sqlin = "INSERT INTO ambiente(temperature) VALUES ('$temp')";

    if (mysqli_query($conn, $sqlin)) {
        //success
        header('location: ambiente.php');
    } else {
        //failure
        echo 'connection error: ' . mysqli_connect_error();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        #slidecontainer {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #myRange {
            height: 25px;
            background-color: #fefefe;
            border-radius: 20px;
        }

        #slider {
            -webkit-appearance: none;
            width: 0;
            height: 100px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
            box-shadow: 1px 1px 15px 0px #000000;
            border-radius: 20px;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            background: #04AA6D;
            cursor: pointer;
            border-radius: 50%;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            background: #04AA6D;
            cursor: pointer;

        }

        h1 {
            color: #fefefe;
            font-size: 100px;
            text-shadow: 2px 2px 8px #000000;
        }

        h2 {
            color: #fefefe;
            text-shadow: 2px 2px 8px #000000;
        }
    </style>
</head>

<body>


    <div id="slidecontainer">
        <h2>TEMPERATURA</h2>
        <h1><span id="demo"></span></h1><br>
        <form method="POST">
            <div id="teste">
                <input type="range" min="16" max="30" id="myRange" name="temp" value="<?php foreach ($temperatures as $temperature) {
                                                                                            echo $temperature['temperature'];
                                                                                        } ?>">
            </div>
            <button type="submit" name="edit" class="btn waves-effect waves-light green accent-4">Salvar
                <i class="material-icons right">save</i>
            </button>
        </form>
    </div>

    <script>
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value + '°';

        slider.oninput = function() {
            output.innerHTML = this.value + '°';
        }
    </script>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.modal').modal();
        });
    </script>
</body>

</html>