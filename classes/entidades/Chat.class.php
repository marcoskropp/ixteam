<?php

class Chat {

    private $textoChat;
    private $idUsuario;
    private $idAmigo;

    function getTextoChat() {
        return $this->textoChat;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getIdAmigo() {
        return $this->idAmigo;
    }

    function setTextoChat($textoChat) {
        $this->textoChat = $textoChat;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    function setIdAmigo($idAmigo) {
        $this->idAmigo = $idAmigo;
    }

}
