
var ajax = null;
if (window.XMLHttpRequest) {
    ajax = new XMLHttpRequest();
} else {
    if (window.ActiveXOject) {
        ajax = new ActiveXObject('Msxml2.XMLHTTP');
    }
}
function loading_show() {
    $('#loading').html("<img src='img/loading.gif'/>").fadeIn('fast');
}

//Aqui desativa a imagem de loading
function loading_hide() {
    $('#loading').fadeOut('fast');
}

function load_dados(valores, page, div)
{
    $.ajax
            ({
                type: 'POST',
                dataType: 'html',
                url: page,
                beforeSend: function () {//Chama o loading antes do carregamento
                    loading_show();
                },
                data: valores,
                success: function (msg)
                {
                    loading_hide();
                    var data = msg;
                    $(div).html(data).fadeIn();
                }
            });
}
//load_dados(null, 'vaidar.txt', '#MostraPesq');

$('#cpf').keyup(function () {

    var valores = $('#form-pesquisa').serialize()//o serialize retorna uma string pronta para ser enviada

    //pegando o valor do campo #pesquisaCliente
    var $parametro = $(this).val();
    console.log($parametro);
    if ($parametro.length >= 0)
    {

        load_dados(valores, '/caixacontrato/modulos/consulta-externa.php', '#MostraPesq');

    } else
    {
        load_dados(null, '/caixacontrato/modulos/consulta-externa.php', '#MostraPesq');
        $('#cpf').reset();
    }
});
$('#cnpj').keyup(function () {

    var valores = $('#form-pesquisa').serialize()//o serialize retorna uma string pronta para ser enviada

    //pegando o valor do campo #pesquisaCliente
    var $parametro = $(this).val();
    console.log($parametro);
    if ($parametro.length >= 1)
    {

        load_dados(valores, '/caixacontrato/modulos/consulta.php', '#MostraPesq');
    } else
    {

        load_dados(null, '/caixacontrato/modulos/consulta.php', '#MostraPesq');
    }
});
$('#num-contrato').keyup(function () {

    var valores = $('#form-pesquisa').serialize()//o serialize retorna uma string pronta para ser enviada

    //pegando o valor do campo #pesquisaCliente
    var $parametro = $(this).val();
    console.log($parametro);
    if ($parametro.length >= 1)
    {

        load_dados(valores, '/caixacontrato/modulos/consulta.php', '#MostraPesq');
    } else
    {

        load_dados(null, '/caixacontrato/modulos/consulta.php', '#MostraPesq');
    }
});
$('#numcaixa').keyup(function () {

    var valores = $('#form-pesquisa').serialize()//o serialize retorna uma string pronta para ser enviada

    //pegando o valor do campo #pesquisaCliente
    var $parametro = $(this).val();
    console.log($parametro);
    if ($parametro.length >= 1)
    {

        load_dados(valores, 'consulta.php', '#MostraPesq');
    } else
    {

        load_dados(null, 'consulta.php', '#MostraPesq');
        $('#form-pesquisa').reset();
    }
});

function exibir_ocultar(val) {
    //var tipo_parametro = document.querySelector("tipo-escolha").value;
    if (val.value == 'cpf') {
        document.querySelector("#moratar-cpf").style.display = "block";
        document.querySelector("#mostrar-cnpj").style.display = "none";
       // document.querySelector("#mostar-num-caixa").style.display = "none";
       // document.querySelector("#mostrar-num-contrato").style.display = "none";
    } else {
        if (val.value == 'cnpj') {
            document.querySelector("#moratar-cpf").style.display = "none";
            document.querySelector("#mostrar-cnpj").style.display = "inline";
          //  document.querySelector("#mostar-num-caixa").style.display = "none";
           // document.querySelector("#mostrar-num-contrato").style.display = "none";
        } else {
            if (val.value == 'numcontrato') {
                document.querySelector("#moratar-cpf").style.display = "none";
                document.querySelector("#mostrar-cnpj").style.display = "none";
              //  document.querySelector("#mostar-num-caixa").style.display = "none";
               // document.querySelector("#mostrar-num-contrato").style.display = "inline";
            } else {
                if (val.value == 'numcaixa') {
                    document.querySelector("#moratar-cpf").style.display = "none";
                    document.querySelector("#mostrar-cnpj").style.display = "none";
                   // document.querySelector("#mostar-num-caixa").style.display = "inline";
                   // document.querySelector("#mostrar-num-contrato").style.display = "none";
                } else {
                    if (val.value == 'vazio') {
                        document.querySelector("#moratar-cpf").style.display = "none";
                        document.querySelector("#mostrar-cnpj").style.display = "none";
                       // document.querySelector("#mostar-num-caixa").style.display = "none";
                       // document.querySelector("#mostrar-num-contrato").style.display = "none";
                    }
                }
            }
        }
    }
}
document.querySelector("#moratar-cpf").style.display = "none";
document.querySelector("#mostrar-cnpj").style.display = "none";
//document.querySelector("#mostar-num-caixa").style.display = "none";
//document.querySelector("#mostrar-num-contrato").style.display = "none";


