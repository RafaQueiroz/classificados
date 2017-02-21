<?php


require_once ("Banco.php");
class UsuarioDAL{

    private $pdo;
    private $debugg;
    public function __construct(){
        $this->pdo = new Banco();
        $this->debugg = true;
    }

    public function busca(string $termo, int $tipo){

        try{
            switch ($tipo){
                case 1:
                    $sql = 'select * from usuario where nome like :termo  and status = true and status = true order by nome ASC ';
                    break;
                case 2:
                    $sql = 'select * from usuario where email like :termo and status = true order by nome ASC ';
                    break;
                case 3:
                    $sql = ' select * from usuario where cpf like :termo and status = true order by nome ASC ';
                    break;
                case 4:
                    $sql = 'select * from usuario where usuario like :termo and status = true order by nome ASC ';
                    break;
                default;
                    return null;
            }
            $param = array(
                ':termo' => $termo
            );

            $resultado = $this->pdo->ExecuteQuery($sql, $param);
            $listaUsuario = [];

            foreach ($resultado as $linha ){
                $usuario = new Usuario();
                $usuario->setCod($linha['cod']);
                $usuario->setNome($linha['nome']);
                $usuario->setEmail($linha['email']);
                $usuario->setCpf($linha['cpf']);
                $usuario->getNascimento($linha['nascimento']);
                $usuario->setUsuario($linha['usuario']);

                $listaUsuario[] = $usuario;
            }

            return $listaUsuario;

        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function buscaUsuarioByCod(int $cod){
        $sql = "select cod, nome, email, cpf, usuario, nascimento, sexo, status, permissao from usuario where cod = :cod and status = true";

        $param =array(
            ':cod' => $cod
        );

        $dt = $this->pdo->ExecuteQueryOneRow($sql, $param);

        $usuario = new Usuario();
        if($dt != null ){
            $usuario->setCod($dt['cod']);
            $usuario->setNome($dt['nome']);
            $usuario->setEmail($dt['email']);
            $usuario->setCpf($dt['cpf']);
            $usuario->setUsuario($dt['usuario']);
            $usuario->setNascimento($dt['nascimento']);
            $usuario->setSexo($dt['sexo']);
            $usuario->setPermissao($dt['permissao']);
            $usuario->setStatus($dt['status']);
        } else {
            return null;
        }

        return $usuario;
    }

    public function cadastrar(Usuario $usuario) {

        try {
            $sql = ''
                . 'insert into usuario( '
                . 'nome , email, cpf, usuario, senha, nascimento, sexo, status, permissao, ip '
                . ') '
                . 'values( '
                . ':nome , :email, :cpf, :usuario, :senha, STR_TO_DATE(:nascimento, "%d/%m/%Y"), :sexo, :status, :permissao, :ip '
                . ') ';

            $senhaUsuario = md5($usuario->getSenha());

            $param = array(
                ':nome' => $usuario->getNome(),
                ':email' => $usuario->getEmail(),
                ':cpf' => $usuario->getCpf(),
                ':usuario' => $usuario->getUsuario(),
                ':senha' => $senhaUsuario,
                ':nascimento' => $usuario->getNascimento(),
                ':sexo' => $usuario->getSexo(),
                ':status' => $usuario->getStatus(),
                ':permissao' => $usuario->getPermissao(),
                ':ip' => $_SERVER['REMOTE_ADDR']
            );
            return $this->pdo->ExecuteNonQuery($sql, $param);

        } catch (PDOException $e){

            if($this->debugg){
                echo "ERROR: {$e->getMessage()} \n LINE: {$e->getLine()}";
            }

        }
    }

    public function atualizar(Usuario $usuario){
        try{
            $sql = "update usuario set "
                ."nome = :nome, "
                ."email = :email, "
                ."cpf = :cpf,"
                ."usuario = :usuario, "
                ."nascimento = STR_TO_DATE(:nascimento, '%d/%m/%Y'), "
                ."sexo = :sexo, "
                ."status = :status, "
                ."permissao = :permissao, "
                ."ip = :ip "
                ." where cod = :cod";

            $param = array(
                ':cod' => $usuario->getCod(),
                ':nome' => $usuario->getNome(),
                ':email' => $usuario->getEmail(),
                ':cpf' => $usuario->getCpf(),
                ':usuario' => $usuario->getUsuario(),
                ':nascimento' => $usuario->getNascimento(),
                ':sexo' => $usuario->getSexo(),
                ':status' => $usuario->getStatus(),
                ':permissao' => $usuario->getPermissao(),
                ':ip' => $_SERVER['REMOTE_ADDR']
            );

            return $this->pdo->ExecuteNonQuery($sql, $param);

        } catch(PDOException $e){
            echo "ERRO: {$e->getMessage()} \n LINHA: {$e->getLine()}";
        }
    }

    public function autenticarUsuario(string $usr, string $senha){
        try{
            $sql = "select cod, nome, permissao from usuario where status = true and usuario = :usuario and senha = :senha ";

            $param = array(
                ':usuario' => $usr,
                ':senha' =>$senha
            );

            $resultado = $this->pdo->ExecuteQueryOneRow($sql, $param);

            if($resultado == null )
                return null;

            $usuario = new Usuario();
            $usuario->setCod($resultado['cod']);
            $usuario->setNome($resultado['nome']);
            $usuario->setPermissao($resultado['permissao']);

            return $usuario;
        } catch (Exception $e){
            echo "ERRO: {$e->getMessage()} \n LINHA: {$e->getLine()}";
        }
    }

}