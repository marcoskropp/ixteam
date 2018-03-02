<?php
session_start();
if (!(isset($_SESSION['emailUsuario']))) {
    header('Location: ../index.php');
}
if (isset($_GET['sair'])) {
    session_destroy();
    header('Location: ../index.php');
}

$emailUsuario = $_SESSION['emailUsuario'];

require_once '../classes/Conexao.class.php';
require_once '../classes/DAO/UsuarioDAO.class.php';
require_once '../classes/DAO/UsuarioDAO.class.php';
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.github.io/templates/blank/theme.css" type="text/css">
        <link rel="stylesheet" href="../css/theme.css" type="text/css">
    </head>
    <body style="background-color: #faf9fd;">
        <?php require "../templates/header.php"; ?>
        <div class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="list-group">
                            <li class="list-group-item"><i class="fa fa-user fa-fw"></i>Amigos</li>
                            <?php
                            $usuarioDAO = new UsuarioDAO();
                            $buscarAmigos = $usuarioDAO->buscarAmigos($usuarioDAO->buscarIdUsuario($emailUsuario));
                            foreach ($buscarAmigos as $row) {
                                ?>
                                <a class="list-group-item" href="chat.php?idAmigo=<?= $row['idUsuario'] ?>"><?= $row['nomeUsuario']; ?></a>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <form method="POST" class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit" name="buscarTodos">Todos</button>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Buscar por..." name="pesquisa">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit" name="buscar">Buscar</button>
                                        </span>
                                    </form>
                                </div><!-- /input-group -->
                                <br>
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
                        <div class="row">
                            <?php
                            $usuarioDAO = new UsuarioDAO();
                            $idUsuario = $usuarioDAO->buscarIdUsuario($emailUsuario);

                            if (isset($_POST['buscar'])) {
                                $pesquisa = $_POST['pesquisa'];
                                $retorno = $usuarioDAO->pesquisarUsuario($pesquisa);
                                foreach ($retorno as $row) {
                                    ?>
                                    <div class="col-md-5  offset-md-1">
                                        <img src="../uploads/<?= $row['imagemUsuario'] ?>" class="img-fluid img-thumbnail">
                                        <br><br>
                                    </div>
                                    <div class="col-md-6">
                                        <h1 class="text-primary"><?= $row['nomeUsuario'] ?></h1>
                                        <p class="lead"><?= $row['apelidoUsuario'] ?></p>
                                        <p class="lead"><?= $row['emailUsuario'] ?></p>
                                        <form method="GET" action="profile.php">
                                            <input name="idAmigo" type="hidden" value="<?= $row['idUsuario'] ?>"/>
                                            <button type="submit" class="btn btn-info">Visitar</button>
                                        </form>
                                    </div>
                                    <?php
                                }
                            } else {

                                foreach ($usuarioDAO->buscarTodos($usuarioDAO->buscarIdUsuario($emailUsuario)) as $row) {
                                    ?>
                                    <div class="col-md-5  offset-md-1">


                                        <img src="../uploads/<?= $row['imagemUsuario'] ?>" class="img-fluid img-thumbnail">
                                        <br><br>
                                    </div>
                                    <div class="col-md-6">
                                        <h1 class="text-primary"><?= $row['nomeUsuario'] ?></h1>
                                        <p class="lead"><?= $row['apelidoUsuario'] ?></p>
                                        <p class="lead"><?= $row['emailUsuario'] ?></p>
                                        <form method="GET" action="profile.php">
                                            <input name="idAmigo" type="hidden" value="<?= $row['idUsuario'] ?>"/>
                                            <button type="submit" class="btn btn-info">Visitar</button>
                                        </form>
                                    </div>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-5  section">
            <div class="container"> </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>
    </body>

</html>