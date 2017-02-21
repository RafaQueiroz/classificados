<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 1/2/17
 * Time: 1:59 PM
 */

require_once ("../DAL/UsuarioDAL.php");

class UsuarioController{

    private $usuarioDAL;

    public function __construct(){
        $this->usuarioDAL = new UsuarioDAL();
    }

    public function cadastrar(Usuario $usuario){
        if(strlen($usuario->getSenha()) < 5 ){
            return false;
        }

        if(strlen($usuario->getCpf()) != 11){
            return false;
        }

        return $this->usuarioDAL->cadastrar($usuario);
    }

    public function atualizar(Usuario $usuario){

        if($usuario->getNome() == null)
            return false;
        if($usuario->getUsuario() == null)
            return false;
        if($usuario->getCpf() == null)
            return false;

        return $this->usuarioDAL->atualizar($usuario);


    }

    public function busca(string $termo, int $tipo){

        if($tipo >= 1 && $tipo <= 4 && $termo != ""){
            return $this->usuarioDAL->busca($termo, $tipo);

        }

        return false;
    }

    public function buscaUsuarioByCod(int $cod){

        $usuario = new Usuario();

        if($cod != null && $cod != 0) {
            $usuario = $this->usuarioDAL->buscaUsuarioByCod($cod);
        } else {
            $usuario = null;
        }

        return $usuario;
    }

    public function autenticarUsuario(string $usr, string $senha){

        if($usr == null || str_replace(' ', '', $usr) == "")
            return false;

        if($senha == null || str_replace(' ', '', $senha) == "")
            return false;

        $hash = md5($senha);

        return $this->usuarioDAL->autenticarUsuario($usr, $hash);


    }
}