<?php
session_start();

if(!isset($_SESSION['logado']) || !$_SESSION['logado'])
    header("Location: index.php?msg=1");
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../img/favicon.ico">
    <title>Brasil Classificados | Painel</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.mask.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
    <div id="dvPainel" class="centralizada">
        <div class="row" id="dvTopo">

            <div class="col-lg-12 alignCenter">
                <div id="dvLogoTopo" class="alignCenter">
                    <img src="../img/logoFundoClaro.png" alt="Brasil Classificados">
                </div>

                <div id="devMenuTopo" class="alignCenter">
                    <ul id="ulMenu">
                        <li><a href="painel.php">Inicio</a></li>
                        <li><a href="?pagina=usuario">Usuário</a></li>
                        <li><a href="?pagina=classificado">Classificados</a></li>
                        <li><a href="?pagina=categoria">Categoria</a></li>
                        <li><a href="?pagina=contato">Contato</a></li>
                        <li><a href="logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="dvConteudo">
                <?php require_once("../Util/RequestPage.php"); ?>
            </div>

        </div>

    </div>
    <div id="dvRodape" class="col-lg-12">
        <div class="centralizada">
            <div class="col-lg-6 col-xs-12">
                <p>&copy; Brasil Classificados  - Todos os direitos reservados</p>
            </div>
            <div class="col-lg-6 col-xs-12">
                <ul id="ulRedeSociais">
                    <li><a href="">Facebook</a></li>
                    <li><a href="">Twitter</a></li>
                    <li><a href="">LinkedIn</a></li>
                    <li><a href="">Youtube</a></li>
                </ul>
            </div

        </div>
    </div>
</body>
</html>