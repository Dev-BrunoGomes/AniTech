<?php
session_start();
if ($_SESSION['logado'] != true) {

    $_SESSION['msg'] = "Você precisa estar logado para acessar essa página";
    header('location: login.php');
}
if (isset($_POST['logout'])) {
    $_SESSION['msg'] = "Deslogado com sucesso";
    header('location: login.php');
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">
    <title>AniTech-Home</title>
    <link rel="stylesheet" href="../styles/home.css">
</head>

<body>
    <div class="sidebar">
        <a href="../pages/dashboard.php" target="iframe">
            <img style="max-width: 100%; height: auto;" src="../images/logo.png" alt="Logo AniTech">
        </a>

        <a class="menu" href="../pages/animais.php" target="iframe">ANIMAIS</a>

        <a class="menu" href="../pages/ambiente.php" target="iframe">AMBIENTE</a>

        <a class="menu" href="../pages/equipamentos.php" target="iframe">EQUIPAMENTOS</a>

        <a class="menu" href="../pages/funcionarios.php" target="iframe">FUNCIONARIOS</a>

        <form action="" method="POST"><button id="logout" type="submit" class="menu" name="logout">LOGOUT</button></form>
    </div>
    <iframe class="container" src="dashboard.php" name="iframe" title="funcionalidades" frameborder="0"></iframe>
</body>

</html>