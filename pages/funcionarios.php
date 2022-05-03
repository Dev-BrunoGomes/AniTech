<?php
include "../config/dbclass.php";
session_start();
if ($_SESSION['logado'] != true) {

    $_SESSION['msg'] = "Você precisa estar logado para acessar essa página";
    header('location: login.php');
}
$obj = new Dbc();
$conn = $obj->connect();

$role = 1;
//escrevendo requisição ao banco
$sqlout = "SELECT * FROM usuarios WHERE funcionario = $role";

//fazendo requisição e pegando resultado
$resulta = mysqli_query($conn, $sqlout);

//passando para array
$funcionarios = mysqli_fetch_all($resulta, MYSQLI_ASSOC);
if (isset($_POST['action'])) {

    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $sobrenome = mysqli_real_escape_string($conn, trim($_POST['sobrenome']));
    $nascimento = mysqli_real_escape_string($conn, trim($_POST['nascimento']));
    $cpf = mysqli_real_escape_string($conn, trim($_POST['cpf']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $user = mysqli_real_escape_string($conn, trim($_POST['user']));
    $pass = mysqli_real_escape_string($conn, trim($_POST['pass']));
    $func = mysqli_real_escape_string($conn, trim($_POST['func']));

    //escrevendo inserção ao banco
    $sql = "SELECT COUNT(*) AS total FROM usuarios WHERE usuario = '$user'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['total'] == 1) {
        echo "<script type='text/javascript'>alert('Usuário ou email cadastrado ja exite.');window.location.href='funcionarios.php';</script>";
    } else {

        $sqlin = "INSERT INTO usuarios(nome, sobrenome, nascimento, cpf, email, usuario, senha, funcionario) VALUES ('$nome', '$sobrenome', '$nascimento', '$cpf', '$email', '$user', '$pass', '$func')";

        //fazendo inserção ao banco 
        if (mysqli_query($conn, $sqlin)) {
            //success
            header('location: funcionarios.php');
        } else {
            //failure
            echo 'connection error: ' . mysqli_error($conn);
        }
    }


    unset($nome);
    unset($sobrenome);
    unset($nascimento);
    unset($email);
    unset($user);
    unset($pass);
    unset($func);
}

if (isset($_POST['edit'])) {
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $sobrenome = mysqli_real_escape_string($conn, trim($_POST['sobrenome']));
    $nascimento = mysqli_real_escape_string($conn, trim($_POST['nascimento']));
    $cpf = mysqli_real_escape_string($conn, trim($_POST['cpf']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $user = mysqli_real_escape_string($conn, trim($_POST['user']));
    $pass = mysqli_real_escape_string($conn, trim($_POST['pass']));
    $func = mysqli_real_escape_string($conn, trim($_POST['func']));

    $id_to_edit = $_POST['id_to_edit'];

    $sqledit = "UPDATE usuarios SET nome = '$nome', sobrenome = '$sobrenome', nascimento = '$nascimento', cpf = '$cpf', email = '$email', usuario = '$user', senha = '$pass', funcionario = '$func' WHERE id = $id_to_edit";

    if (mysqli_query($conn, $sqledit)) {
        //success
        header('location: funcionarios.php');
    } else {
        //failure
        echo 'connection error: ' . mysqli_connect_error();
    }
}

if (isset($_POST['delete'])) {

    $id_to_delete = $_POST['id_to_delete'];

    $sqldelete = "DELETE FROM usuarios WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sqldelete)) {
        //success
        header('location: funcionarios.php');
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
                <li><a class="waves-effect waves-light btn-large green accent-4 modal-trigger" href="#modal1" target="iframe">Adicionar novo Funcionário</a></li>
            </ul>
        </div>
    </nav>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Adicionar Funcionário</h4>
            <div class="row">
                <form class="col s12" method="POST">
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="nome" name="nome" required>
                                <label for="nome">Nome</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="sobrenome" name="sobrenome" required>
                                <label for="sobrenome">Sobrenome</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="nascimento" name="nascimento" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                                <label for="nascimento">Data de nascimento</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="number" id="cpf" name="cpf" required>
                                <label for="cpf">CPF</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="email" id="email" name="email" required>
                                <label for="email">E-mail</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="usuario" name="user" required>
                                <label for="usuario">Usuário</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="password" name="pass" id="senha" required>
                                <label for="senha">Senha</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="password" name="pass2" id="senhaC" required>
                                <label for="senhaC">Confirme senha</label>
                            </div>
                        </div>
                        <input type="hidden" name="func" value="1" required>
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
        <?php foreach ($funcionarios as $funcionario) { ?>

            <div class="col s3 md3">
                <div class="card small">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator" src="../images/funcionario.png">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4"><?php echo ($funcionario['nome']); ?><i class="material-icons right">more_vert</i></span>
                        <p><a class="green-text text-accent-4"><?php echo "id: " . ($funcionario['id']) ?></a></p>
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4"><?php echo ($funcionario['nome'] . ' ' . $funcionario['sobrenome']); ?><i class="material-icons right">close</i></span>
                        <p>
                        <h6>Seu usuario é:</h6> <?php echo ($funcionario['usuario']); ?></p>
                        <p>
                        <h6>Sua senha é:</h6> <?php echo ($funcionario['senha']); ?></p>
                        <p>
                        <h6>Seu email é:</h6> <?php echo ($funcionario['email']); ?></p>
                        <p>
                        <h6>Nasceu em:</h6> <?php echo ($funcionario['nascimento']); ?></p>
                        <p>
                        <h6>Nasceu em:</h6> <?php echo ($funcionario['cpf']); ?></p>
                        <p>
                        <h6>Adicionado em:</h6> <?php echo ($funcionario['data']); ?></p>
                        <button class="btn waves-effect waves-light green accent-4 modal-trigger" href="#modal4">Editar
                            <i class="material-icons right">edit</i>
                        </button><br><br>
                        <button class="btn waves-effect waves-light green accent-4 modal-trigger" href="#modal5">Excluir
                            <i class="material-icons right">delete</i>
                        </button>
                    </div>
                </div>
            </div>

        <?php }; ?>
    </div>

    <!-- Modal Structure Edit-->
    <div id="modal4" class="modal">
        <div class="modal-content">
            <h4>Adicionar Funcionário</h4>
            <div class="row">
                <form class="col s12" method="POST">
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="nome" name="nome" value="<?php echo $funcionario['nome']; ?>" required>
                                <label for="nome">Nome</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="sobrenome" name="sobrenome" value="<?php echo $funcionario['sobrenome']; ?>" required>
                                <label for="sobrenome">Sobrenome</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="nascimento" name="nascimento" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $funcionario['nascimento']; ?>" required>
                                <label for="nascimento">Data de nascimento</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="number" id="cpf" name="cpf" value="<?php echo $funcionario['cpf']; ?>" required>
                                <label for="cpf">CPF</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="email" id="email" name="email" value="<?php echo $funcionario['email']; ?>" required>
                                <label for="email">E-mail</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="usuario" name="user" value="<?php echo $funcionario['usuario']; ?>" required>
                                <label for="usuario">Usuário</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="password" name="pass" id="senha" value="<?php echo $funcionario['senha']; ?>" required>
                                <label for="senha">Senha</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="password" name="pass2" id="senhaC" value="<?php echo $funcionario['senha']; ?>" required>
                                <label for="senhaC">Confirme senha</label>
                            </div>
                        </div>
                        <input type="hidden" name="func" value="1" required>
                        <input type="hidden" name="id_to_edit" value="<?php echo ($funcionario['id']); ?>">
                    </div>
                    <div class="modal-footer">
                        <button class="btn waves-effect waves-light green accent-4" type="submit" name="edit">Salvar
                            <i class="material-icons right">save</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Structure Delete-->
    <div id="modal5" class="modal">
        <div class="modal-content">
            <h5>Tem certeza que deseja excluir este funcionario?</h5>
            <div class="row">
                <form class="col s12" method="POST">
                    <div class="modal-footer">
                        <form action="" method="POST">
                            <input type="hidden" name="id_to_delete" value="<?php echo ($funcionario['id']); ?>">
                            <input type="submit" name="delete" value="Excluir" class="btn green accent-4">
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>

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