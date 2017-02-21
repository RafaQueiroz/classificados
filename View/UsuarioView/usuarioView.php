<?php
require_once ('../Model/Usuario.php');
require_once ('../Controller/UsuarioController.php');
$resultado = '';
$resultadoBusca = '';
$listaUsuarios = [];

$usuarioController = new UsuarioController();

$nome = "";
$email = "";
$cpf = "";
$usr = "";
$nascimento = "";
$sexo = "";
$permissao = "1";
$status = "2";

if(filter_input(INPUT_POST, 'btnSalvar', FILTER_SANITIZE_STRING)){
    $usuario = new Usuario();


    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);

    $usuario->setNome(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
    $usuario->setEmail(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING));
    $usuario->setCpf(preg_replace('/[.-]/','',$cpf));
    $usuario->setUsuario(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $usuario->setSenha(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING));
    $usuario->setNascimento(filter_input(INPUT_POST, 'nascimento', FILTER_SANITIZE_STRING));
    $usuario->setSexo(filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING));
    $usuario->setStatus(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT));
    $usuario->setPermissao(filter_input(INPUT_POST, 'permissao', FILTER_SANITIZE_NUMBER_INT));

    if(!filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_NUMBER_INT)){ //Verifica se o id do usuário será passado na requisição
        if ($usuarioController->cadastrar($usuario)) {
?>
            <script type="text/javascript">

                document.cookie = "msg=1";
                document.location.href = "?pagina=usuario";
            </script>
<?php
        } else {
            $resultado = "<div class='alert alert-danger' role='alert'>Houve erro ao tentar cadastrar usuário</div>";
        }
    } else {
        $usuario->setCod($_POST['cod']);

        if($usuarioController->atualizar($usuario)){
            $resultado = "<div class='alert alert-success' role='alert'>Usuario Atualizado com sucesso</div>";
        } else {
            $resultado = "<div class='alert alert-danger' role='alert'>Erro ao Atualizado com sucesso</div>";
        }

    }
}

//Busca usuário
if(filter_input(INPUT_POST, 'btnBusca', FILTER_SANITIZE_STRING)){

    $termo = filter_input(INPUT_POST,'termo', FILTER_SANITIZE_STRING );
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT );



    $listaUsuarios = $usuarioController->busca($termo, $tipo);

    if(!empty($listaUsuarios)){
        $resultado = "foram encontrados: ".sizeof($listaUsuarios);
    } else {
        $resultadoBusca = "Nenhum usuário foi encontrado ";
    }
}

//Editar Usuario
if(filter_input(INPUT_GET, 'cod', FILTER_SANITIZE_NUMBER_INT)){

    $cod = $_GET['cod'];

    $usuario = $usuarioController->buscaUsuarioByCod($cod);

    if($usuario != null){
        $nome = $usuario->getNome() != null ? $usuario->getNome() : "";
        $email = $usuario->getEmail() != null ? $usuario->getEmail() : "";
        $cpf = $usuario->getCpf() != null ? $usuario->getCpf() : "";
        $usr = $usuario->getUsuario() != null ? $usuario->getUsuario() : "";
        $sexo = $usuario->getSexo() != null ? $usuario->getSexo() : "";
        $permissao = $usuario->getPermissao() != null ? $usuario->getPermissao() : "";
        $status = $usuario->getStatus() != null ? $usuario->getStatus() : "";
        $nascimento = $usuario->getNascimento() != null ? $usuario->getNascimento() : "";

        $data = new DateTime($nascimento);
        $nascimento = $data->format("d/m/Y");

    }

}


?>
<div id="dvUsuarioView" class="container">
    <h1>Usuários</h1>

    <div class="panel panel-default">
        <div class="panel-body">
            <a href="?pagina=usuario"><img src="../Admin-bc/img/icones/png/user-1.png" alt="Cadastrar" class="icon"></a>
            <a href="?pagina=usuario&consulta=s"><img src="../Admin-bc/img/icones/png/zoom-in.png" alt="Buscar" class="icon"></a>
        </div>
    </div>


    <!-- CADASTRO -->
    <?php
    if(!filter_input(INPUT_GET, 'consulta', FILTER_SANITIZE_STRING)){
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">Cadastro</div>
            <div class="panel-body">
                <form id="cadastroUsuario" method="post">

                    <input type="hidden" name="cod" id="cod" value="<?= $cod?>">
                    
                    <div class="row">
                        <div class="col-lg-6 colxs-12">
                            <div class="form-group">
                                <label for="nome" class="alignLeft">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome" name="nome" value="<?= $nome ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="usuario" class="alignLeft">Usuário</label>
                                <input type="text" class="form-control" id="usuario" placeholder="Usuário"
                                       name="usuario" value="<?= $usr ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="email" class="alignLeft">E-mail</label>
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?= $email ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="cpf" class="alignLeft">cpf</label>
                                <input type="text" class="form-control" id="cpf" placeholder="cpf" name="cpf" value="<?= $cpf ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="senha" class="alignLeft">Senha</label>
                                <input type="password" class="form-control" id="senha" placeholder="*********"
                                       name="senha" <?= isset($cod) && $cod != null ? "disabled" : ""?> >
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="confirmaSenha" class="alignLeft">Confirma Senha</label>
                                <input type="password" class="form-control" id="confirmaSenha" placeholder="**********"
                                       name="confirmaSenha" <?= isset($cod) && $cod != null ? "disabled" : ""?> >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="nascimento" class="alignLeft">Data de Nascimento</label>
                                <input type="text" class="form-control" id="nascimento" placeholder="12/12/1994"
                                       name="nascimento" value="<?= $nascimento ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="email" class="alignLeft">Sexo</label>
                                <select name="sexo" id="sexo" class="form-control">
                                    <option value="m" value="<?= $sexo == 'm' ? 'selected' : '' ?>>">Masculino</option>
                                    <option value="f" <?= $sexo == 'f' ? 'selected' : '' ?>>Feminino</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="Status" class="alignLeft">Status</label>
                                <select name="status" id="permissao" class="form-control">
                                    <option value="1" <?= $permissao == "1" ? "selected" : "" ?>>Ativo</option>
                                    <option value="2" <?= $permissao == "2" ? "selected" : "" ?>>Desativado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="email" class="alignLeft">Sexo</label>
                                <select name="permissao" id="permissao" class="form-control">
                                    <option value="1" <?= $status == "1" ? "selected" : "" ?>>Administrador</option>
                                    <option value="2" <?= $status == "2" ? "selected" : "" ?>>Comum</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <p class="pRetorno"><?= $resultado ?></p>
                        </div>
                    </div>
                    <input type="submit" name="btnSalvar" class="btn btn-primary" value="Salvar">
                    <input type="submit" name="btnCancelar" class="btn btn-default" value="Cancelar">
                </form>
            </div>
        </div>
        <?php
    } else {

        ?>
        <div class="panel panel-default">
            <div class="panel-heading">Busca</div>
            <div class="panel-body">
                <form id="cadastroUsuario" method="post">
                    <div class="row">
                        <div class="col-lg-8 colxs-12">
                            <div class="form-group">
                                <label for="termo" class="alignLeft">Busca</label>
                                <input type="text" class="form-control" id="termo" placeholder="Ex: Alguma coisa" name="termo">
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <div class="form-group">
                                <label for="usuario" class="alignLeft">Usuário</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="1">Nome</option>
                                    <option value="2">E-mail</option>
                                    <option value="3">CPF</option>
                                    <option value="4">Usuário</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="submit" name="btnBusca" class="btn btn-primary" value="Buscar">
                </form>
            </div>
        </div>

        <table class="table table-responsive table-bordered" name="tabelaUsuarios">
            <tr>
                <td></td>
                <td>Nome</td>
                <td>E-mail</td>
                <td>Cpf</td>
                <td>Usuário</td>
            </tr>
            <?php
            if($listaUsuarios != null )
                foreach($listaUsuarios as $usuario) {
                    ?>
                    <tr>
                        <td></td>
                        <td><?= $usuario->getNome() ?></td>
                        <td><?= $usuario->getEmail() ?></td>
                        <td><?= $usuario->getCpf() ?></td>
                        <td><?= $usuario->getUsuario() ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Opções
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><a href="?pagina=usuario&cod=<?= $usuario->getCod()?>">Editar</a></li>
                                    <li><a href="">Deletar</a></li>
                                    <li><a href="?pagina=endereco&usrCod=<?= $usuario->getCod()?>">Gerenciar Endereco</a></li>
                                    <li><a href="?pagina=telefone&usrCod=<?= $usuario->getCod()?>">Gerenciar Telefone</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </table>
        <?php
    }
    ?>

</div>
<script type="text/javascript" src="../js/usuarioView.js"></script>