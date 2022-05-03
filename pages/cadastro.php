<?php
include "../config/dbclass.php";
$obj = new Dbc();
$conn = $obj->connect();

if (isset($_POST['submit'])) {

    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $sobrenome = mysqli_real_escape_string($conn, trim($_POST['sobrenome']));
    $nascimento = mysqli_real_escape_string($conn, trim($_POST['nascimento']));
    $cpf = mysqli_real_escape_string($conn, trim($_POST['cpf']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $user = mysqli_real_escape_string($conn, trim($_POST['user']));
    $pass = mysqli_real_escape_string($conn, trim($_POST['pass']));

    echo "até aqui ok2";
    //escrevendo inserção ao banco
    $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE usuario = '$user' AND email ='$email'";
    echo "até aqui ok 3";
    $result = mysqli_query($conn, $sql);
    echo "até aqui ok 4";
    $row = mysqli_fetch_assoc($result);
    echo "até aqui ok 5";

    if ($row['total'] == 1) {
        echo "<script type='text/javascript'>alert('Usuário ou email cadastrado ja exite.');window.location.href='cadastro.php';</script>";
    } else {

        $sqlin = "INSERT INTO usuarios(nome, sobrenome, nascimento, cpf, email, usuario, senha) VALUES ('$nome', '$sobrenome', '$nascimento', '$cpf', '$email', '$user', '$pass')";

        //fazendo inserção ao banco 
        if (mysqli_query($conn, $sqlin)) {
            //success
            header('location: login.php');
        } else {
            //failure
            echo 'connection error: ' . mysqli_connect_error();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/icon.png">
    <title>AniTech-Cadastro</title>
    <link rel="stylesheet" href="../styles/cadastro.css">
</head>

<body>
    <form action="" method="POST">
        <div class="login">
            <a href="../index.php">
                <img class="logo" src="../images/logo.png" alt="Anitech">
            </a>
            <div class="inputs">
                <input type="text" placeholder="Nome" class="input" name="nome" required>
                <input type="text" placeholder="Sobrenome" class="input" name="sobrenome" required>
                <input placeholder="Data de nascimento" class="input" name="nascimento" type="text"
                    onfocus="(this.type='date')" onblur="(this.type='text')" required>
                <input type="number" placeholder="CPF" class="input" name="cpf" required>
                <input type="email" placeholder="E-mail" class="input" name="email" required>
                <input type="text" placeholder="Nome de usuario" class="input" name="user" required>
                <input type="password" placeholder="Senha" class="input" name="pass" id="senha" required>
                <input type="password" placeholder="Confirme a senha" class="input" name="pass2" id="senhaC"
                    required><br><br>
            </div>

            <button type="submit" name="submit" class="btn">Cadastrar</button><br>
        </div>
    </form>
    <script>
    let senha = document.getElementById('senha');
    let senhaC = document.getElementById('senhaC');

    function validarSenha() {
        if (senha.value != senhaC.value) {
            senhaC.setCustomValidity("Senhas diferentes!");
            senhaC.reportValidity();
            return false;
        } else {
            senhaC.setCustomValidity("");
            return true;
        }
    }

    // verificar também quando o campo for modificado, para que a mensagem suma quando as senhas forem iguais
    senhaC.addEventListener('input', validarSenha);
    </script>
</body>

</html>