/**
 * Created by rafael on 1/31/17.
 */

function validaNumero(numero) {
    if(numero == null || numero.length < 0)
        return false;

    return true;
}

$(document).ready(function () {

    $('#cep').blur(function () {
        var cep = $('#cep').val().replace(/\-/g, '');

        $.ajax({
            'url' : 'https://viacep.com.br/ws/'+cep+'/json/',
            'dataType' : 'json',
            'cache' : false,
            'success' : function (data) {
               $('#rua').val(data.logradouro);
               $('#bairro').val(data.bairro);
               $('#cidade').val(data.localidade);
               $('#estado').val(data.uf);
            }
        });
    });


    $('#cep').mask('00000-000');

    $('#btnSalvar').click(function (event) {
        var numero = $("#numero").val();

        if(!validaNumero(numero)){
            $('#numero').parent().addClass('has-error');
            event.preventDefault();
            event.preventBubble();
        }


    });



});