<?php
require_once("../Model/Endereco.php");
require_once ("../DAL/EnderecoDAL.php");
class EnderecoController{

    private $enderecoDAO;

    public function __construct(){
        $this->enderecoDAO = new EnderecoDAL();
    }

    public function buscaByUsuarioCod(int $cod){

        if($cod == null)
            return null;

        return $this->enderecoDAO->buscaByUsuarioCod($cod);

    }

    public function cadastrar(Endereco $endereco){

        if(!$endereco->getRua()){
            return null;
        }

        if(!$endereco->getNumero())
            return null;

        if(!$endereco->getBairro())
            return null;

        return $this->enderecoDAO->cadastrar($endereco);
    }

    public function atualizar(Endereco $endereco){

        if($endereco->getRua() == null)
            throw new Exception('O campo rua não pode ser nulo!');
            

        return $this->enderecoDAO->atualizar($endereco);
    }

}

?>