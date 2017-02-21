$(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
    $('#nascimento').mask('00/00/0000');

    if(getCookie("msg") == 1){
        var retorno = "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso</div>";
        $('.pRetorno').html(retorno);
        delete_cookie("msg");
    } else{
        $('.pRetorno').html("");
    }

    $('input[name="salvar"]').on('click', function(event){

        var senha1 = $('#senha').val();
        var senha2 = $('#confirmaSenha').val();
        var cpf = $('#cpf').val();

        if(!validaCpf(cpf)){
            event.preventDefault();
            $('#cpf').parent().addClass('has-error');
        }

        if(!validaSenha(senha1, senha2)){
            event.preventDefault();
            $('#senha').parent().addClass('has-error');
            $('#confirmaSenha').parent().addClass('has-error');
        }
    });
});

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function delete_cookie(name) {
    document.cookie = name + '=0; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}


function validaSenha(senha1, senha2){

    if(!senha1.trim() || !senha2.trim())
        return false;

    if(senha1 == senha2)
        return true;

    return false
}

function validaCpf(cpf) {
    var newCpf = cpf.replace(/\./g, '').replace(/\-/g, '');
    alert(newCpf);

    if(newCpf.length == 11)
        return true;
    else
        return false;
}