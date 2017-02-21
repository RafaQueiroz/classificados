<?php

class Imagem{
    private $cod;
    private $imagem;
    private $classificado;

    function __construct(){
        $this->classificado = new Classificado();
    }

    /**
     * @return mixed
     */
    public function getCod()
    {
        return $this->cod;
    }

    /**
     * @param mixed $cod
     */
    public function setCod($cod)
    {
        $this->cod = $cod;
    }

    /**
     * @return mixed
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * @param mixed $imagem
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    /**
     * @return Classificado
     */
    public function getClassificado()
    {
        return $this->classificado;
    }

    /**
     * @param Classificado $classificado
     */
    public function setClassificado($classificado)
    {
        $this->classificado = $classificado;
    }
}