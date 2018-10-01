<?php
require_once '../classes/Conexao.class.php';
require_once "../classes/DAO/PublicacaoDAO.class.php";
require_once '../classes/DAO/UsuarioDAO.class.php';
require_once "../classes/entidades/Publicacao.class.php";


session_start();
if (!(isset($_SESSION['emailUsuario']))) {
    header('Location: ../index.php');
}
if (isset($_GET['sair'])) {
    session_destroy();
    header('Location: ../index.php');
}

$emailUsuario = $_SESSION['emailUsuario'];
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Home</title>
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
                        <form enctype="multipart/form-data" method="POST">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group w-100"> <label>Publique sua ideia</label>
                                            <textarea class="form-control" id="exampleInputEmail1" placeholder="Max: 255"
                                                      type="text" max="255" maxlength="255" name="publicacao" style=" height: 140px; resize: none;"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-info">Publicar</button>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="hidden" name="MAX_FILE_SIZE"/>
                                        <label>Adicione uma Imagem</label>
                                        <input name="userfile" type="file"  />
                                        <img src = "../uploads/padrao-publicacao.png" style="max-height: 200px;" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        $publicacaoDAO = new PublicacaoDAO();
                        $usuarioDAO = new UsuarioDAO();
                        $i = 0;
                        $armazenaIdPublicacao = 0;
                        foreach ($publicacaoDAO->buscarPublicacoes($usuarioDAO->buscarIdUsuario($emailUsuario)) as $row) {
                            if ($row['idPublicacao'] == $armazenaIdPublicacao) {
                                
                            } else {
                                ?>
                                <div class="py-5  section">
                                    <div class="container">
                                        <?php if ($i == 0) { ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <img src="../uploads/<?= $row['imagemPublicacao']; ?>" style="max-height: 250px;" class="img-fluid"> </div>
                                                <div class="col-md-6">
                                                    <h1 class="text-primary"><?= $row['apelidoUsuario']; ?></h1>
                                                    <p class="lead" style="overflow-wrap: break-word"><?= $row['textoPublicacao'] ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php $i ++;
                                        } else {
                                            $i = 0;
                                            ?>
                                            <div class="row">
                                                <div class="col-md-5 offset-md-1" >
                                                    <h1 class="text-primary"><?= $row['apelidoUsuario']; ?></h1>
                                                    <p class="lead" style="overflow-wrap: break-word"><?= $row['textoPublicacao']; ?></p>
                                                </div>
                                                <div class="col-md-5">
                                                    <img src="../uploads/<?= $row['imagemPublicacao']; ?>" style="max-height: 250px;" class="img-fluid"> </div>
                                            </div>
                                            <hr>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            $armazenaIdPublicacao = $row['idPublicacao']
                            ?>
                            <?php
                        }
                        ?>
                    </div>
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
if (isset($_FILES['userfile'])) {
    if ($_FILES['userfile'] == 'Array') {
        
    } else {
        date_default_timezone_set("Brazil/East");
        $ext = strtolower(substr($_FILES['userfile']['name'], -4));
        $new_name = date("Y.m.d-H:i:s") . $ext;
        $dir = '../uploads/';
        move_uploaded_file($_FILES['userfile']['tmp_name'], $dir . $new_name);
    }
    $publicacao = new Publicacao();
    $publicacao->setImagemPublicacao($new_name);
    $publicacao->setTextoPublicacao(addslashes($_POST['publicacao']));
    $usuarioDAO->buscarIdUsuario($emailUsuario);
    $publicacaoDAO->inserirPublicacao($publicacao, $usuarioDAO->buscarIdUsuario($emailUsuario));
}
?>
