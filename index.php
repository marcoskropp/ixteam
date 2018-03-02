<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.github.io/templates/blank/theme.css" type="text/css">
        <link rel="stylesheet" href="css/theme.css" type="text/css"> </head>
</head>

<body class="bg-inverse">
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid d-block w-50 h-75" src="imagens/logo.png"> </div>
                <div class="col-md-6">
                    <h1 style="text-align: center;">BEM-VINDO À IXTEAM!</h1>
                    <form method="post">
                        <div class="form-group"> <label>Email</label>
                            <input type="email" class="form-control" placeholder="Email" name="emailUsuario"> </div>
                        <div class="form-group"> <label>Senha</label>
                            <input type="password" class="form-control" placeholder="Senha" name="senhaUsuario"> </div>
                        <button type="submit" class="btn btn-info text-white btn-block" data-toggle="">Login</button>
                        <a href="view/register.php" class="btn btn-info text-white btn-block">Cadastro</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>
</body>

</html>

<?php
if ($_POST) {
    require_once './classes/Conexao.class.php';
    require_once './classes/entidades/Usuario.class.php';
    require_once './classes/DAO/UsuarioDAO.class.php';

    $usuario = new Usuario();
    $usuarioDAO = new UsuarioDAO();

    $usuario->setEmailUsuario($_POST['emailUsuario']);
    $usuario->setSenhaUsuario($_POST['senhaUsuario']);

    $retorno = $usuarioDAO->login($usuario->getEmailUsuario(), $usuario->getSenhaUsuario());
    if ($retorno == true) {
        session_start();
        $_SESSION['emailUsuario'] = $usuario->getEmailUsuario();
        $_SESSION['senhaUsuario'] = $usuario->getSenhaUsuario();
        header("location:view/home.php");
        exit;
    } else {
        header("location:index.php?erro=senha");
    }
}
?>

<?php
if ($_GET) {
    if (isset($_GET['erro'])) {
        echo "<script>alert('Login ou senha incorretos!')</script>";
    }
}
?>