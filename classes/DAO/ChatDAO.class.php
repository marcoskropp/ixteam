<?php

/**
 * <b>ChatDAO</b>
 * Classe que realiza a interligação entre o banco de dados na tabela Chat
 * e a classe Chat
 * 
 * @author Marcos && João
 */
class ChatDAO extends Conexao {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function enviarMensagem($idUsuario, $idAmigo, $textoChat) {
        $sql = "INSERT INTO chat (idUsuario,idAmigo,textoChat) values ('$idUsuario','$idAmigo','$textoChat')";
        mysqli_query($this->conexao->getCon(), $sql);
        echo "<meta http-equiv='refresh' content='0'>";
    }

    public function buscarMensagens($idUsuario, $idAmigo) {
        $sql = "SELECT usuario.idUsuario,chat.textoChat, usuario.apelidoUsuario, usuario.imagemUsuario FROM chat INNER JOIN usuario on chat.idUsuario = usuario.idUsuario WHERE chat.idUsuario = '$idUsuario' AND chat.idAmigo = '$idAmigo' OR chat.idUsuario = '$idAmigo' AND chat.idAmigo = '$idUsuario'  ORDER BY chat.idChat DESC";
        return mysqli_query($this->conexao->getCon(), $sql);
    }

}
