$(function () {
    // Dispara o Autocomplete a partir do segundo caracter
    $("#cpf").autocomplete({

        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "/caixacontrato/modulos/consulta.php",
                dataType: "json",
                data: {
                    m: 'consulta',
                    t: 'ver',
                    acao: 'autocomplete',
                    parametro: $('#cpf').val(),
                    p: 'cpf'
                },
                success: function (data) {
                    response(data);
                    $("#inform").html(data).fadeIn();
                }
            });
        },
        select: function (event, ui) {
            $("#nome").val(ui.item.nome);
            $("#cpf").val(ui.item.CPF);
            $("#cnpj").val(ui.item.CNPJ);
            $("#cnpjb").val(ui.item.CNPJ);
            $("#nomeb").val(ui.item.nome);
            $("#idcliente").val(ui.item.id_cliente);
            $("#cpfb").val(ui.item.CPF);
            $("#encontrou").val('S');
            return false;
        }
    })
            .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
                .append("<a><b>Nome: </b>" + item.nome + " - <b> CPF: </b>" + item.CPF + "</a><br>")
                .appendTo(ul);
    };

    $("#cnpj").autocomplete({

        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: "/caixacontrato/modulos/consulta.php",
                dataType: "json",
                data: {
                    m: 'consulta',
                    t: 'ver',
                    acao: 'autocomplete',
                    parametro: $('#cnpj').val(),
                    p: 'cnpj'
                },
                success: function (data) {
                    response(data);
                    $("#inform").html(data).fadeIn();
                }
            });
        },
        select: function (event, ui) {
            $("#nome").val(ui.item.nome);
            $("#cnpj").val(ui.item.CNPJ);
            $("#cnpjb").val(ui.item.CNPJ);
            $("#nomeb").val(ui.item.nome);
            $("#idcliente").val(ui.item.id_cliente);
            $("#encontrou").val('S');
            return false;
        }
    })
            .autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
                .append("<a><b>Nome: </b>" + item.nome + " - <b> CNPJ: </b>" + item.CNPJ + "</a><br>")
                .appendTo(ul);
    };

});
$(function () {

    document.querySelector("#moratar-cpf").style.display = "none";
    document.querySelector("#mostrar-cnpj").style.display = "none";
    document.querySelector("#mostrarnum").style.display = "none";

});
function exibir_ocultar(val) {
    //var tipo_parametro = document.querySelector("tipo-escolha").value;
    if (val.value == 'cpf1') {
        document.querySelector("#moratar-cpf").style.display = "block";
        document.querySelector("#mostrar-cnpj").style.display = "none";
        document.querySelector("#mostrarnum").style.display = "none";
    } else {
        if (val.value == 'cnpj1') {

            document.querySelector("#moratar-cpf").style.display = "none";
            document.querySelector("#mostrar-cnpj").style.display = "block";
            document.querySelector("#mostrarnum").style.display = "none";
        } else {
            if (val.value == 'numero1') {
                document.querySelector("#moratar-cpf").style.display = "none";
                document.querySelector("#mostrar-cnpj").style.display = "none";
                document.querySelector("#mostrarnum").style.display = "block";
            } else {
                if (val.value == 'vazio') {
                    document.querySelector("#moratar-cpf").style.display = "none";
                    document.querySelector("#mostrar-cnpj").style.display = "none";
                    document.querySelector("#mostrarnum").style.display = "none";
                }
            }
        }
    }
}



