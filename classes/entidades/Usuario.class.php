<?php
class Usuario {
    private $nomeUsuario;
    private $emailUsuario;
    private $senhaUsuario;
    private $apelidoUsuario;
    private $imagemUsuario;
    
    function getNomeUsuario() {
        return $this->nomeUsuario;
    }

    function getEmailUsuario() {
        return $this->emailUsuario;
    }

    function getSenhaUsuario() {
        return $this->senhaUsuario;
    }

    function getApelidoUsuario() {
        return $this->apelidoUsuario;
    }

    function getImagemUsuario() {
        return $this->imagemUsuario;
    }

    function setNomeUsuario($nomeUsuario) {
        $this->nomeUsuario = $nomeUsuario;
    }

    function setEmailUsuario($emailUsuario) {
        $this->emailUsuario = $emailUsuario;
    }

    function setSenhaUsuario($senhaUsuario) {
        $this->senhaUsuario = $senhaUsuario;
    }

    function setApelidoUsuario($apelidoUsuario) {
        $this->apelidoUsuario = $apelidoUsuario;
    }

    function setImagemUsuario($imagemUsuario) {
        $this->imagemUsuario = $imagemUsuario;
    }


}
