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
$sqlout = 'SELECT * FROM animais';

//fazendo requisição e pegando resultado
$result = mysqli_query($conn, $sqlout);

//passando para array
$animais = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['action'])) {

    $especie = $_POST['especie'];
    $sexo = $_POST['sexo'];

    //escrevendo inserção ao banco
    $sqlin = "INSERT INTO animais(especie, sexo) VALUES ('$especie', '$sexo')";

    //fazendo inserção ao banco 
    if (mysqli_query($conn, $sqlin)) {
        //success
        header('location: animais.php');
    } else {
        //failure
        echo 'connection error: ' . mysqli_connect_error();
    }


    unset($especie);
    unset($sexo);
}

if (isset($_POST['delete'])) {

    $id_to_delete = $_POST['id_to_delete'];

    $sqldelete = "DELETE FROM animais WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sqldelete)) {
        //success
        header('location: animais.php');
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

</head>

<body>
    <nav class="navbar-fixed">
        <div class="nav-wrapper" style="background-color: #114720;">
            <ul class="right hide-on-med-and-down">
                <li><a class="waves-effect waves-light btn-large green accent-4 modal-trigger" href="#modal1" target="iframe">Adicionar novo animal</a></li>
            </ul>
        </div>
    </nav>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Adicionar animal</h4>
            <div class="row">
                <form class="col s12" method="POST">
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" type="text" class="" name="especie" required>
                                <label for="password">Espécie</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password1" type="text" class="" name="sexo" required>
                                <label for="password1">Sexo</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn waves-effect waves-light green accent-4" type="submit" name="action">Salvar
                            <i class="material-icons right">save</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <?php foreach ($animais as $animal) { ?>

            <div class="col s3 md3">
                <div class="card small">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="<?php if ($animal['especie'] == 'galinha') { ?> ../images/galinha_icon.png
                        <?php } else { ?> ../images/gado_icon.png <?php } ?>">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4"><?php echo ($animal['especie']); ?><i class="material-icons right">more_vert</i></span>
                        <p><a class="green-text text-accent-4"><?php echo "id: " . ($animal['id']) ?></a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4"><?php echo ($animal['especie']); ?><i class="material-icons right">close</i></span>
                        <p>
                        <h6>Este animal é:</h6> <?php echo ($animal['sexo']); ?></p>
                        <p>
                        <h6>Adicionado em:</h6> <?php echo ($animal['Aquisição']); ?></p>
                        <button class="btn waves-effect waves-light green accent-4 modal-trigger" href="#modal5">Excluir
                            <i class="material-icons right">delete</i>
                        </button>
                    </div>
                </div>
            </div>

        <?php }; ?>
    </div>


    <!-- Modal Structure -->
    <div id="modal5" class="modal">
        <div class="modal-content">
            <h5>Tem certeza que deseja excluir este animal?</h5>
            <div class="row">
                <form class="col s12" method="POST">
                    <div class="modal-footer">
                        <form action="" method="POST">
                            <input type="hidden" name="id_to_delete" value="<?php echo ($animal['id']); ?>">
                            <input type="submit" name="delete" value="Excluir" class="btn green accent-4">
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>


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