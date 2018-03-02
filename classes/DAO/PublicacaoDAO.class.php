<?php

/**
 * <b>PublicacaoDAO</b>
 * Classe que realiza a interligação entre o banco de dados na tabela Publicacao
 * e a classe Publicacao
 *
 * @author Marcos && João
 */
class PublicacaoDAO extends Conexao {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function inserirPublicacao($publicacao, $idUsuario) {
        if (strlen($publicacao->getImagemPublicacao()) <= 19) {
            $sql = "INSERT INTO publicacao (textoPublicacao,imagemPublicacao, idUsuario) values ('" . $publicacao->getTextoPublicacao() . "','padrao-publicacao.png','" . $idUsuario . "')";
            mysqli_query($this->conexao->getCon(), $sql);
        } else {
            $sql = "INSERT INTO publicacao (textoPublicacao,imagemPublicacao, idUsuario) values ('" . $publicacao->getTextoPublicacao() . "','" . $publicacao->getImagemPublicacao() . "','" . $idUsuario . "')";
            mysqli_query($this->conexao->getCon(), $sql);
        }
        echo "<meta http-equiv='refresh' content='0'>";
    }

    public function buscarPublicacoes($idUsuario) {
        $sql = "SELECT publicacao.idPublicacao, usuario.apelidoUsuario, publicacao.textoPublicacao, publicacao.imagemPublicacao FROM publicacao INNER JOIN usuario on publicacao.idUsuario = usuario.idUsuario INNER JOIN relacao on usuario.idUsuario = relacao.idUsuario WHERE relacao.idAmigo = $idUsuario OR publicacao.idUsuario = $idUsuario ORDER BY publicacao.idPublicacao DESC";
        return mysqli_query($this->conexao->getCon(), $sql);
    }

    public function buscarPublicacao($idUsuario) {
        $sql = "SELECT usuario.apelidoUsuario, publicacao.textoPublicacao, publicacao.imagemPublicacao FROM publicacao INNER JOIN usuario on publicacao.idUsuario = usuario.idUsuario WHERE usuario.idUsuario = '$idUsuario'";
        return mysqli_query($this->conexao->getCon(), $sql);
    }

}
