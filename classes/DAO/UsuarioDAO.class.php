<?php

/**
 * <b>UsuarioDAO</b>
 * Classe que realiza a interligação entre o banco de dados na tabela Usuario
 * e a classe Usuario
 *
 * @author Marcos && João
 */
class UsuarioDAO extends Conexao {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function inserirUsuario($usuario) {
        $busca = "SELECT idUsuario FROM usuario WHERE emailUsuario = '" . $usuario->getEmailUsuario() . "'";
        $executa = mysqli_query($this->conexao->getCon(), $busca);
        if (mysqli_num_rows($executa) > 0) {
            echo "<script>alert('E-mail já cadastrado!')</script>";
        } else {
            $sql = "INSERT INTO usuario (nomeUsuario,emailUsuario,senhaUsuario,apelidoUsuario) values ('" . $usuario->getNomeUsuario() . "','" . $usuario->getEmailUsuario() . "',sha1('" . $usuario->getSenhaUsuario() . "'),'" . $usuario->getApelidoUsuario() . "')";
            mysqli_query($this->conexao->getCon(), $sql);
            echo "<script>alert('Usuario inserido com sucesso!');location.href = '../index.php' </script>";
        }
    }

    public function login($emailUsuario, $senhaUsuario) {
        $sql = "SELECT * FROM usuario WHERE emailUsuario = '$emailUsuario' and senhaUsuario = sha1('$senhaUsuario')";
        $executa = mysqli_query($this->conexao->getCon(), $sql);
        if (mysqli_num_rows($executa) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarUsuario($id) {
        $sql = "SELECT * FROM usuario WHERE idUsuario = '$id'";
        return mysqli_query($this->conexao->getCon(), $sql);
    }

    public function buscarIdUsuario($emailUsuario) {
        $sql = "SELECT idUsuario FROM usuario WHERE emailUsuario = '$emailUsuario'";
        $idUsuario = mysqli_fetch_assoc(mysqli_query($this->conexao->getCon(), $sql));
        return $idUsuario['idUsuario'];
    }

    public function inserirImagemUsuario($usuario) {
        $sql = "UPDATE usuario SET imagemUsuario = '" . $usuario->getImagemUsuario() . "' WHERE emailUsuario = '" . $usuario->getEmailUsuario() . "'";
        echo "<meta http-equiv='refresh' content='0'>";
        return mysqli_query($this->conexao->getCon(), $sql);
    }

    public function buscarTodos($idUsuario) {
        $sql = "SELECT * FROM usuario WHERE idUsuario <> '$idUsuario'";
        return mysqli_query($this->conexao->getCon(), $sql);
    }

    public function seguirAmigo($idUsuario, $idAmigo) {
        $sql = "INSERT INTO relacao(idUsuario, idAmigo) VALUES('$idUsuario','$idAmigo')";
        mysqli_query($this->conexao->getCon(), $sql);
        $sql = "INSERT INTO relacao(idUsuario, idAmigo) VALUES('$idAmigo','$idUsuario')";
        mysqli_query($this->conexao->getCon(), $sql);
        echo "<meta http-equiv='refresh' content='0'>";
    }

    public function buscarRelacao($idUsuario, $idAmigo) {
        $sql = "SELECT COUNT(idRelacao) AS 'contagem' FROM relacao WHERE idUsuario = '$idUsuario' AND idAmigo = '$idAmigo'";
        $contagem = mysqli_fetch_array(mysqli_query($this->conexao->getCon(), $sql));
        return $contagem['contagem'];
    }

    public function buscarAmigos($idUsuario) {
        $sql = "SELECT relacao.idUsuario, usuario.nomeUsuario FROM usuario INNER JOIN relacao ON usuario.idUsuario = relacao.idUsuario WHERE relacao.idAmigo = $idUsuario";
        return mysqli_query($this->conexao->getCon(), $sql);
    }

    public function pesquisarUsuario($pesquisa){
        $sql = "SELECT * FROM usuario WHERE nomeUsuario LIKE '{$pesquisa}%' OR apelidoUsuario LIKE '{$pesquisa}%'";
        return mysqli_query($this->conexao->getCon(), $sql);
    }
}
