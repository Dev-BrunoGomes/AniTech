<?php
session_start();
include "../config/dbclass.php";
$obj = new Dbc();
$conn = $obj->connect();

if (isset($_POST["submit"])) {

    $usuario = mysqli_real_escape_string($conn, $_POST['user']);
    $senha = mysqli_real_escape_string($conn, $_POST['pass']);


    $sqlout = "SELECT funcionario FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha}'";
    $resulta = mysqli_query($conn, $sqlout);
    $role = mysqli_fetch_all($resulta, MYSQLI_ASSOC);


    $query = "SELECT usuario FROM usuarios WHERE usuario = '{$usuario}' AND senha = '{$senha}'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_num_rows($result);

    if ($row == 1) {

        $_SESSION['logado'] = true;

        if ($role['0']['funcionario']) {
            header('location: homeFuncionario.php');
        } else {
            header('location: home.php');
        }
    } else {
        echo "<script type='text/javascript'>alert('Usuário ou senha não reconhecido.');window.location.href='login.php';</script>";
    };
};

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">
    <title>AniTech-Login</title>
    <link rel="stylesheet" href="../styles/login.css">
</head>

<body>
    <form action="" method="POST">
        <div class="login">
            <a class="logo" href="../index.php">
                <img src="../images/logo.png" alt="Anitech">
            </a>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                session_destroy();
            }

            ?>
            <div class="inputs">
                <input type="text" placeholder="Usuário" class="input" name="user" required>
                <input type="password" placeholder="Senha" class="input" name="pass" required>
            </div>
            <a class="cadastro" href="../pages/cadastro.php">Esqueceu a senha?</a><br><br>

            <button type="submit" name="submit" class="btn">Login</button><br><br><br>
            <a class="cadastro" href="../pages/cadastro.php">Não possui login? Cadastre-se</a>
        </div>
    </form>

</body>

</html>