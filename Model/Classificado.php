<?php

class Classificado{
    private $cod;
    private $nome;
    private $descricao;
    private $tipo;
    private $valor;
    private $status;
    private $peril;
    private $categoria;
    private $usuario;


    function __construct(){
        $this->categoria = new Categoria();
        $this->usuario = new Usuario();
    }

    /**
     * @return mixed
     */
    public function getCod()
    {
        return $this->cod;
    }/**
     * @param mixed $cod
     */
    public function setCod($cod)
    {
        $this->cod = $cod;
    }/**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }/**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }/**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }/**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }/**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }/**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }/**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }/**
     * @param mixed $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }/**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }/**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }/**
     * @return mixed
     */
    public function getPeril()
    {
        return $this->peril;
    }/**
     * @param mixed $peril
     */
    public function setPeril($peril)
    {
        $this->peril = $peril;
    }/**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }/**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }/**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }/**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
}