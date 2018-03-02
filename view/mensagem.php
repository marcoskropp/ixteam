<?php

require_once '../classes/Conexao.class.php';
require_once '../classes/DAO/UsuarioDAO.class.php';
require_once '../classes/DAO/ChatDAO.class.php';
require_once '../classes/entidades/Chat.class.php';
$usuarioDAO = new UsuarioDAO();
$chatDAO = new ChatDAO();
$emailUsuario = $_GET['emailUsuario'] ?? NULL;
$idAmigo = $_GET['idAmigo'] ?? NULL;

$buscarMensagens = $chatDAO->buscarMensagens($usuarioDAO->buscarIdUsuario($emailUsuario), $idAmigo);

foreach ($buscarMensagens as $row) {
    if ($row['idUsuario'] == $usuarioDAO->buscarIdUsuario($emailUsuario)) {
        
        ?>
        <br>
        
        <h5 style="float: right; color: #00b0eb; overflow-wrap: break-word; background: white; width: 100%; padding: 10px; border-color: #000; border-radius: 2px; box-shadow: 1px 1px 2px black;">
            <img src = "../uploads/<?= $row['imagemUsuario'] ?>" style="max-height: 20px;" class="img-fluid">
            <?= $row['apelidoUsuario'] ?>:
            <?= $row['textoChat'] ?>
        </h5><br>
    <?php } elseif ($row['idUsuario'] == $idAmigo) { ?>
        <br>
        <h5 style="float: right; color: #00b0eb; overflow-wrap: break-word; background: white; width: 100%; padding: 10px; border-color: #000; border-radius: 2px; box-shadow: 1px 1px 2px black;">
            <img src = "../uploads/<?= $row['imagemUsuario'] ?>" style="max-height: 20px;" class="img-fluid">
            <?= $row['apelidoUsuario'] ?>:
            <?= $row['textoChat'] ?>
        </h5><br>
        <?php
    }
}
?>