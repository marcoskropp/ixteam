<?php
session_start();
if (!(isset($_SESSION['emailUsuario']))) {
    header('Location: ../index.php');
}
if (isset($_GET['sair'])) {
    session_destroy();
    header('Location: ../index.php');
}
$idAmigo = $_GET['idAmigo'] ?? null;
$emailUsuario = $_SESSION['emailUsuario'];
$mailUsuario = $emailUsuario;
require_once '../classes/Conexao.class.php';
require_once '../classes/DAO/UsuarioDAO.class.php';
require_once '../classes/DAO/ChatDAO.class.php';
require_once '../classes/entidades/Chat.class.php';
$usuarioDAO = new UsuarioDAO();
$chatDAO = new ChatDAO();
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="https://pingendo.github.io/templates/blank/theme.css" type="text/css"> 
        <link rel="stylesheet" href="../css/theme.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

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
                            $buscarAmigos = $usuarioDAO->buscarAmigos($usuarioDAO->buscarIdUsuario($emailUsuario));
                            foreach ($buscarAmigos as $row) {
                                ?>
                                <a class="list-group-item" href="chat.php?idAmigo=<?= $row['idUsuario'] ?>"><?= $row['nomeUsuario']; ?></a>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12" style="overflow-y: scroll; height: 368px;" >
                            <div id="tabela">
                                <?php require_once "mensagem.php"; ?>
                            </div>
                        </div>
                        <form class="" method="POST">
                            <div class="form-group">
                                <textarea class="form-control" id="exampleInputEmail1" placeholder="Max: 255" type="text" max="255" maxlength="255" name="mensagemChat" style=" height: 100px; resize: none;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-info">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </body>
    <script>
        var int = $('#tabela').load('mensagem.php?idAmigo=<?= $idAmigo ?>&emailUsuario=<?= $mailUsuario ?>');
        var intervalo = setInterval(function () {
            $('#tabela').load('mensagem.php?idAmigo=<?= $idAmigo ?>&emailUsuario=<?= $mailUsuario ?>');
        }, 2000);
    </script>
</html>
<?php
if (isset($_POST['mensagemChat'])) {
    $mensagemChat = addslashes($_POST['mensagemChat'] ?? null);
    $chatDAO->enviarMensagem($usuarioDAO->buscarIdUsuario($mailUsuario), $idAmigo, $mensagemChat);
}
?>
