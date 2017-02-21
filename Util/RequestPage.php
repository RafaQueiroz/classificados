<?php

$pagina = filter_input(INPUT_GET, "pagina", FILTER_SANITIZE_STRING);

$arrayPaginas = array(
    "usuario" => "../View/UsuarioView/usuarioView.php",
    "endereco" => "../View/UsuarioView/enderecoView.php",
    "telefone" => "../View/UsuarioView/telefoneView.php",
    "classificado" => "../View/ClassificadoView/classificadoView.php",
    "categoria" => "../View/CategoriaView/categoriaView.php",
    "contato" => "../View/ContatoView/contatoView.php",
);

if ($pagina) {
    $encontrou = false;

    foreach ($arrayPaginas as $page => $key) {
        if ($pagina == $page) {
            $encontrou = true;
            require_once($key);
        }
    }

    if (!$encontrou) {
        require_once("painel.php");
    }
} else {
    require_once("painel.php");
}
?>