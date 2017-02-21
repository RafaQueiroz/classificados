<?php
require_once ('../Model/Endereco.php');
require_once ('../Controller/EnderecoController.php');
require_once ('../Controller/UsuarioController.php');

$resultado = '';

$enderecoController = new EnderecoController();
$usuarioController = new UsuarioController();


$usuarioCod = filter_input(INPUT_GET, 'usrCod', FILTER_SANITIZE_NUMBER_INT);
$rua = "";
$numero = "";
$bairro = "";
$complemento = "";
$cidade = "";
$estado = "";
$cep = "";
$status = "";



if(filter_input(INPUT_POST, 'btnSalvar', FILTER_SANITIZE_STRING)){

    $usuario= $usuarioController->buscaUsuarioByCod($usuarioCod);

    if(!$usuario)
        throw new Exception('Usuário não foi encontrado!');

    $endereco = new Endereco();

    $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);

    $endereco->setRua(filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_STRING));
    $endereco->setNumero(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $endereco->setBairro(filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING));
    $endereco->setCep(preg_replace('/[.-]/','',$cep));
    $endereco->setCidade(filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING));
    $endereco->setEstado(filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING));
    $endereco->setComplemento(filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING));
    $endereco->setUsuario($usuario);

    if(filter_input(INPUT_GET, 'usrCod', FILTER_SANITIZE_NUMBER_INT)){ //Verifica se o id do usuário será passado na requisição
        if ($enderecoController->cadastrar($endereco)) {
            ?>
            <script type="text/javascript">

                document.cookie = "msg=1";
                document.location.href = "?pagina=usuario";
            </script>
            <?php
        } else {
            $resultado = "<div class='alert alert-danger' role='alert'>Houve erro ao tentar cadastrar o Endereco</div>";
        }
    } else {
        $endereco->setCod($usuarioCod);

        if($enderecoController->atualizar($endereco)){
            $resultado = "<div class='alert alert-success' role='alert'>Endereco Atualizado com sucesso</div>";
        } else {
            $resultado = "<div class='alert alert-danger' role='alert'>Erro ao atualizar Endereço</div>";
        }

    }
}

////Editar Usuario
if($cod = filter_input(INPUT_GET, 'usrCod', FILTER_SANITIZE_NUMBER_INT)){

    $endereco = $enderecoController->buscaByUsuarioCod($cod);

    if($endereco != null){
        $rua = $endereco->getRua() != null ? $endereco->getRua() : "";
        $numero = $endereco->getNumero() != null ? $endereco->getNumero() : "";
        $cep = $endereco->getCep() != null ? $endereco->getCep() : "";
        $bairro = $endereco->getBairro() != null ? $endereco->getBairro() : "";
        $cidade = $endereco->getCidade() != null ? $endereco->getcidade() : "";
        $estado = $endereco->getEstado() != null ? $endereco->getEstado() : "";
        $complemento = $endereco->getComplemento() != null ? $endereco->getComplemento() : "";
    }

}


?>
<div id="dvUsuarioView" class="container">
    <h1>Endereço</h1>
        <div class="panel panel-default">
            <div class="panel-heading">Cadastro</div>
            <div class="panel-body">
                <form id="cadastroUsuario" method="post">

                    <input type="hidden" name="cod" id="cod" value="<?= $cod?>">
                    <input type="hidden" name="usuarioCod" id="cod" value="<?= $usuarioCod?>">

                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="cep" class="alignLeft">CEP</label>
                                <input type="text" class="form-control" id="cep" placeholder="CEP"
                                       name="cep" value="<?= $cep ?>" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="estado" class="alignLeft">Estado</label>
                                <select name="estado" id="estado" class="form-control" >
                                    <option value="" <?= $estado == "" ? "selected" : "" ?>>Estados</option>
                                    <option value="AC" <?= $estado == "AC" ? "selected" : ""?>>Acre</option>
                                    <option value="AL" <?= $estado == "AL" ? "selected" : ""?>>Alagoas</option>
                                    <option value="AP" <?= $estado == "AP" ? "selected" : ""?>>Amapá</option>
                                    <option value="AM" <?= $estado == "AM" ? "selected" : ""?>>Amazonas</option>
                                    <option value="BA" <?= $estado == "BA" ? "selected" : ""?>>Bahia</option>
                                    <option value="CE" <?= $estado == "CE" ? "selected" : ""?>>Ceará</option>
                                    <option value="DF" <?= $estado == "DF" ? "selected" : ""?>>Distrito Federal</option>
                                    <option value="ES" <?= $estado == "ES" ? "selected" : ""?>>Espírito Santo</option>
                                    <option value="GO" <?= $estado == "GO" ? "selected" : ""?>>Goiás</option>
                                    <option value="MA" <?= $estado == "MA" ? "selected" : ""?>>Maranhão</option>
                                    <option value="MT" <?= $estado == "MT" ? "selected" : ""?>>Mato Grosso</option>
                                    <option value="MS" <?= $estado == "MS" ? "selected" : ""?>>Mato Grosso do Sul</option>
                                    <option value="MG" <?= $estado == "MG" ? "selected" : ""?>>Minas Gerais</option>
                                    <option value="PA" <?= $estado == "PA" ? "selected" : ""?>>Pará</option>
                                    <option value="PB" <?= $estado == "PB" ? "selected" : ""?>>Paraíba</option>
                                    <option value="PR" <?= $estado == "PR" ? "selected" : ""?>>Paraná</option>
                                    <option value="PE" <?= $estado == "PE" ? "selected" : ""?>>Pernambuco</option>
                                    <option value="PI" <?= $estado == "PI" ? "selected" : ""?>>Piauí</option>
                                    <option value="RJ" <?= $estado == "RJ" ? "selected" : ""?>>Rio de Janeiro</option>
                                    <option value="RN" <?= $estado == "RN" ? "selected" : ""?>>Rio Grande do Norte</option>
                                    <option value="RS" <?= $estado == "RS" ? "selected" : ""?>>Rio Grande do Sul</option>
                                    <option value="RO" <?= $estado == "RO" ? "selected" : ""?>>Rondônia</option>
                                    <option value="RR" <?= $estado == "RR" ? "selected" : ""?>>Roraima</option>
                                    <option value="SC" <?= $estado == "SC" ? "selected" : ""?>>Santa Catarina</option>
                                    <option value="SP" <?= $estado == "SP" ? "selected" : ""?>>São Paulo</option>
                                    <option value="SE" <?= $estado == "SE" ? "selected" : ""?>>Sergipe</option>
                                    <option value="TO" <?= $estado == "TO" ? "selected" : ""?>>Tocantins</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 colxs-12">
                            <div class="form-group">
                                <label for="rua" class="alignLeft">Rua</label>
                                <input type="text" class="form-control" id="rua" placeholder="Rua" name="rua" value="<?= $rua ?>" >
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for="numero" class="alignLeft">Número</label>
                                <input type="text" class="form-control" id="numero" placeholder="numero"
                                       name="usuario" value="<?= $numero ?>" >
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-12">
                            <div class="form-group">
                                <label for="bairro" class="alignLeft">Bairro</label>
                                <input type="text" class="form-control" id="bairro" placeholder="Bairro" name="bairro" value="<?= $bairro ?>" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="complemento" class="alignLeft">Complemento</label>
                                <input type="text" class="form-control" id="complemento" placeholder="Complemento" name="complemento" value="<?= $complemento ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label for="cidade" class="alignLeft">Cidade</label>
                                <input type="text" class="form-control" id="cidade" placeholder="Cidade"
                                       name="cidade" value="<?= $cidade ?>" >
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
</div>
<script type="text/javascript" src="../js/enderecoView.js"></script>