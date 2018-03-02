<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.github.io/templates/blank/theme.css" type="text/css">
        <link rel="stylesheet" href="../css/theme.css" type="text/css">
    </head>
    <body class="bg-inverse">
        <div class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post">
                            <div class="form-group"> <label>Nome</label>
                                <input type="text" class="form-control" placeholder="Nome" name="nomeUsuario"> </div>
                            <div class="form-group"> <label>E-mail</label>
                                <input type="email" class="form-control" placeholder="E-mail" name="emailUsuario"> </div>
                            <div class="form-group"> <label>Senha</label>
                                <input type="password" class="form-control" placeholder="Senha" name="senhaUsuario"> </div>
                            <div class="form-group"> <label>Repetir senha</label>
                                <input type="password" class="form-control" placeholder="Repetir senha" name="repeteSenha"> </div>
                            <div class="form-group"> <label>Apelido</label>
                                <input type="text" class="form-control" placeholder="Apelido" name="apelidoUsuario"> </div>
                            <div class="form-group"> <input type="checkbox" name="termos" value="aceito">
                                <a href="termos.php" class="card-link"><label>Li e concordo com os termos</label></a></div>
                            <button type="submit" class="btn btn-info w-25" name="cadastrar">Cadastrar</button>
                            <a href="../index.php"><button type="button" class="btn btn-info w-25">Voltar</button></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST['cadastrar'])) {
            require_once '../classes/Conexao.class.php';
            require_once '../classes/entidades/Usuario.class.php';
            require_once '../classes/DAO/UsuarioDAO.class.php';

            $usuario = new Usuario();
            $usuarioDAO = new UsuarioDAO();

            if (empty($_POST['nomeUsuario']) || empty($_POST['emailUsuario']) || empty($_POST['senhaUsuario']) || empty($_POST['repeteSenha']) || empty($_POST['apelidoUsuario'])) {
                echo '<script>alert("Algum campo está vazio!");</script>';
            } else {
                if (($_POST['repeteSenha']) == ($_POST['senhaUsuario'])) {
                    if ($_POST['termos'] != 'aceito') {
                        echo '<script>alert("Você precisa aceitar os termos para continuar!");</script>';
                    } else {
                        $usuario->setNomeUsuario($_POST['nomeUsuario']);
                        $usuario->setEmailUsuario($_POST['emailUsuario']);
                        $usuario->setSenhaUsuario($_POST['senhaUsuario']);
                        $usuario->setApelidoUsuario($_POST['apelidoUsuario']);
                        $usuarioDAO->inserirUsuario($usuario);
                    }
                } else {
                    echo '<script>alert("Senhas não conferem!");</script>';
                }
            }
        }
        ?>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>
    </body>

</html>