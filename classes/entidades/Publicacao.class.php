<?php
class Publicacao {
    private $textoPublicacao;
    private $imagemPublicacao;
    
    function getTextoPublicacao() {
        return $this->textoPublicacao;
    }

    function getImagemPublicacao() {
        return $this->imagemPublicacao;
    }

    function setTextoPublicacao($textoPublicacao) {
        $this->textoPublicacao = $textoPublicacao;
    }

    function setImagemPublicacao($imagemPublicacao) {
        $this->imagemPublicacao = $imagemPublicacao;
    }


}
