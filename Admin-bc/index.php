<?php
    session_start();
    require_once ("../Controller/UsuarioController.php");
    require_once ("../Model/Usuario.php");

    $resultado = "";


    if(isset($_SESSION['manter']) && $_SESSION["manter"])
        header("Location: painel.php");


    if(filter_input(INPUT_POST, "btnEntrar", FILTER_SANITIZE_STRING)){
        $usuarioController = new UsuarioController();

        $usr = filter_input(INPUT_POST, "usr", FILTER_SANITIZE_STRING);
        $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);

        if($usuario = $usuarioController->autenticarUsuario($usr, $senha)){

            if(filter_input(INPUT_POST, "ckManterLogado", FILTER_SANITIZE_STRING)){
                $_SESSION["manter"] = true;
            }

            $_SESSION["cod"] = $usuario->getCod();
            $_SESSION["nome"] = $usuario->getNome();
            $_SESSION["logado"] = true;
            header("Location: painel.php");
        } else {
            $resultado = "<div class='alert alert-danger' id='loginError' role='alert'>Usuario ou senha inválida</div>";
        }

    }
    else if($msg = filter_input(INPUT_GET, "msg", FILTER_SANITIZE_STRING)){
        if($msg == 1){
            $resultado = "<div class='alert alert-danger' id='loginError' role='alert'>Acesso negado!</div>";
        } else if($msg == 2) {
            $resultado = "<div class='alert alert-warning' id='loginError' role='alert'>Logout concluído com sucesso!</div>";
        }
    }

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Brasil Classificados | Login </title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
</head>
<body>
    <div id="dvLogin">
        <form method="post" id="loginForm">
            <div class="row">
                <div class="col-lg-12 alignCenter">
                    <img src="../img/logoFundoClaro.png" alt="Brasil Classificados | Login">
                </div>
                <div class="col-lg-12 alignCenter">
                    <div class="form-group">
                        <label for="usr" class="alignLeft">Usuário</label>
                        <input type="usr" class="form-control" id="usr" placeholder="exemplo" name="usr">
                    </div>

                    <div class="form-group" >
                        <label for="Senha" class="alignLeft">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="************">
                    </div>

                    <input type="submit" class="btn btn-success" value="Entrar" name="btnEntrar">
                    <p><a data-toggle="modal" data-target="#myModal" >Recuperar Senha</a></p>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="ckManterLogado"><input type="checkbox" name="ckManterLogado" id="ckManterLogado" value="true"> Manter-se conectado</label>
                    </div>
                </div>
                <div class="col-lg-12">
                    <?= isset($resultado) ? $resultado : "" ?>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Reperar Senha</h4>
                </div>
                <div class="modal-body">
                    <p>Entre em contato com o Administrador para recuperar sua senha</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
</body>
</html>