<?php
require_once("Banco.php");
class EnderecoDAL{

    private $banco;

    public function __construct(){
        $this->banco = New Banco();
    }

    public function buscaByUsuarioCod(int $cod){
        $sql = "select * from endereco where usuario_cod = :cod";

        $parametros = array(
            ':cod' => $cod
        );

        $resultado = $this->banco->ExecuteQueryOneRow($sql, $parametros);

        if($resultado == null)
            return null;

        $endereco = new Endereco();

        $endereco->setRua($resultado['rua']);
        $endereco->setNumero($resultado['numero']);
        $endereco->setBairro($resultado['bairro']);
        $endereco->setCep($resultado['cep']);
        $endereco->setCidade($resultado['cidade']);
        $endereco->setEstado($resultado['estado']);
        $endereco->setComplemento($resultado['complemento']);

        return $endereco;
    }

    public function cadastrar(Endereco $endereco){

        try{
          $sql = "insert into endereco(rua, numero, bairro, cep, cidade, estado, complemento, usuario_cod) values (:rua, :numero, :bairro, :cep, :cidade, :estado, :complemento, :usuarioCod)";

          $parametros = array(
              ':rua' => $endereco->getRua(),
              ':numero' => $endereco->getNumero(),
              ':bairro' => $endereco->getBairro(),
              ':cep' => $endereco->getCep(),
              ':cidade' => $endereco->getCidade(),
              ':estado' => $endereco->getEstado(),
              ':complemento' => $endereco->getComplemento(),
              ':usuarioCod' => $endereco->getUsuario()->getCod()
          );

          return $this->banco->ExecuteNonQuery($sql, $parametros);

        } catch (PDOException $e){
            echo $e->getMessage();
            return null;
        }
    }


}