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
require_once '../classes/entidades/Usuario.class.php';
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
                            <?php
                            $usuarioDAO = new UsuarioDAO();
                            foreach ($usuarioDAO->buscarUsuario($usuarioDAO->buscarIdUsuario($emailUsuario)) as $row) {
                                ?>
                                <div class="col-md-5  offset-md-1">
                                    <img src="../uploads/<?= $row['imagemUsuario'] ?>" class="img-fluid img-thumbnail">
                                </div>
                                <div class="col-md-6">
                                    <h1 class="text-primary"><?= $row['nomeUsuario'] ?></h1>
                                    <p class="lead"><?= $row['apelidoUsuario'] ?></p>
                                    <p class="lead"><?= $row['emailUsuario'] ?></p>
                                </div>
                                <form enctype="multipart/form-data" method="POST">
                                    <br>
                                    <input type="hidden" name="MAX_FILE_SIZE"/>
                                    <input name="userfile" type="file"/>
                                    <button type="submit">Enviar imagem</button>
                                </form>
                            <?php } ?>
                        </div>
                        <br>
                        <hr>
                        <h1>Minhas Publicações</h1>
                        <br>
                        <?php
                        require_once '../classes/DAO/PublicacaoDAO.class.php';
                        $publicacaoDAO = new PublicacaoDAO();
                        $i = 0;
                        foreach ($publicacaoDAO->buscarPublicacao($usuarioDAO->buscarIdUsuario($emailUsuario)) as $row) {
                            ?>
                            <?php if ($i == 0) { ?>
                                <div class = "row">
                                    <div class = "col-md-6">
                                        <img src = "../uploads/<?= $row['imagemPublicacao']; ?>" style="max-height: 250px;" class="img-fluid"> </div>
                                    <div class = "col-md-6">
                                        <h1 class = "text-primary"><?= $row['apelidoUsuario']; ?></h1>
                                        <p class = "lead" style="overflow-wrap: break-word"><?= $row['textoPublicacao'] ?></p>
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <br>
                            <?php $i++; } else {
                                $i = 0;?>
                                <div class = "row">
                                    <div class = "col-md-6">
                                        <h1 class = "text-primary"><?= $row['apelidoUsuario']; ?></h1>
                                        <p class = "lead" style="overflow-wrap: break-word"><?= $row['textoPublicacao'] ?></p>
                                    </div>
                                    <div class = "col-md-6">
                                        <img src = "../uploads/<?= $row['imagemPublicacao']; ?>" style="max-height: 250px;" class="img-fluid"> </div>
                                </div>
                                <br>
                                <hr>
                                <br>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src = "https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>
    </body>

</html>

<?php
if (isset($_FILES['userfile'])) {
    date_default_timezone_set("Brazil/East");
    $ext = strtolower(substr($_FILES['userfile']['name'], -4));
    $new_name = date("Y.m.d-H:i:s") . $ext;
    $dir = '../uploads/';
    move_uploaded_file($_FILES['userfile']['tmp_name'], $dir . $new_name);
    $usuario = new Usuario();
    $usuario->setImagemUsuario($new_name);
    $usuario->setEmailUsuario($emailUsuario);
    $usuarioDAO->inserirImagemUsuario($usuario);
}
?>