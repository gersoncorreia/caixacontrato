<?php
require_once('funcoes.php');
//verificaLogin();
protegeArquivo(basename(__FILE__));


if (isset($_GET['m'])):
    $modulo = $_GET['m'];
else:
    $modulo = null;
endif;
if (isset($_GET['t'])):
    $tela = $_GET['t'];
else:
    $tela = null;
endif;
if (isset($_GET['acao'])):
    $acao = $_GET['acao'];
else:
    $acao = null;
endif;
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
    <head>
        <title>Painel Administrativo</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="Painel de controle"/>
        <link href="/caixacontrato/css/bootstrap.css" rel="stylesheet"/>
        <link href="/caixacontrato/css/style.css" rel="stylesheet"/>
        <link href="/caixacontrato/css/jquery.dataTables.css" rel="stylesheet" >  
        <link href="/caixacontrato/css/screen.css" rel="stylesheet">
        <link href="/caixacontrato/css/bootstrap.min.css" rel="stylesheet">
        <link href="/caixacontrato/css/jquery-ui.css" rel="stylesheet">
        <link href="/caixacontrato/css/jquery-ui.min.css" rel="stylesheet">
        <link href="/caixacontrato/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">


        <script src="/caixacontrato/js/jquery.min.js"></script>        
        <script src="/caixacontrato/js/bootstrap.min.js"></script> 
        <script src="/caixacontrato/js/jquery.dataTables.js"></script>
        <script src="/caixacontrato/js/jquery.dataTables.js"></script>
        <script src="/caixacontrato/js/jquery.js"></script>
        <script src="/caixacontrato/js/jquery.validate.js"></script>
        



<!--<script src="geral.js"></script>-->
        <!--$('#myModal').modal('show'),-->


    </head>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><p >CAIXA CONTRATO</p></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
               <!-- <li><a href="?m=pesquisas&t=ver"><i class="fa fa-search fa-2x"></i> Pesquisar</a></li>-->

                <li class="dropdown">
                    <a href="?m=usuarios&t=login"><i class="fa fa-user-circle-o fa-2x"></i> Fazer login</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>

    <div class="col-md-10 content col-md-offset-1">
        <div class="well">
            <?php //include('navbar.php');  ?>
            <?php
            if ($modulo != null and $tela != null):
                loadmodulo($modulo, $tela);
            else:
                echo '<fieldset><legend><p><h3>Página principal <i class="fa fa-desktop fa-2x"></i></h3></p></legend></fieldset>';
                ?>
                <script>
                    $(function ($) {
                        // Aqui fazemos uso do plugin MASKED INPUT
                        //$("#datav").mask("99/99/9999");
                        $("#cpf").mask("999.999.999-99");
                        $("#cnpj").mask("99.999.999/9999-99");
                        //$("#cep").mask("99.999-999");
                        // $("#telefone").mask("(99) 9999-9999");
                        // $("#celular").mask("(99)99999-9999");
                        // Aqui usamos fazemos uso do plugin MASK MONEY
                        //$("#valor").maskMoney({thousands: '', decimal: ','});
                    });
                    // Dispara o Autocomplete a partir do segundo caracter
                    // Dispara o Autocomplete a partir do segundo caracter


                </script>
                <script>
                    $(function () {
                        document.querySelector("#pesqcpf").style.display = "none";
                        document.querySelector("#pesqcnpj").style.display = "none";
                        document.querySelector("#numcontrat").style.display = "none";
                    });
                    function exibir_ocultar3(val) {
                        //var tipo_parametro = document.querySelector("tipo-escolha").value;
                        if (val.value == 'pesquisacpf') {

                            document.querySelector("#pesqcpf").style.display = "block";
                            document.querySelector("#pesqcnpj").style.display = "none";
                            document.querySelector("#numcontrat").style.display = "none";
                        }
                        if (val.value == 'pesquisacnpj') {
                            document.querySelector("#pesqcpf").style.display = "none";
                            document.querySelector("#pesqcnpj").style.display = "block";
                            document.querySelector("#numcontrat").style.display = "none";
                        }

                        if (val.value == 'pesquisanumcontrato') {
                            document.querySelector("#pesqcpf").style.display = "none";
                            document.querySelector("#pesqcnpj").style.display = "none";
                            document.querySelector("#numcontrat").style.display = "block";
                        }
                        if (val.value == 'vazio') {
                            document.querySelector("#pesqcpf").style.display = "none";
                            document.querySelector("#pesqcnpj").style.display = "none";
                            document.querySelector("#numcontrat").style.display = "none";
                        }


                    }

                </script>
                <script>
                    $(document).ready(function () {

                        $("#produto1").dataTable({
                            'sScrollY': "400px",
                            'bPaginate': true,
                            'aaSorting': [[0, 'asc']],
                            'searching': true,
                            "columnDefs": [
                                {"width": "20%", "targets": 0},
                                {"width": "12%", "targets": 1},
                                {"width": "9%", "targets": 2},
                                {"width": "9%", "targets": 3},
                            ],

                            "language": {
                                "sEmptyTable": "Nenhum registro encontrado",
                                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                                "sInfoPostFix": "",
                                "sInfoThousands": ".",
                                "sLengthMenu": "_MENU_ resultados por página",
                                "sLoadingRecords": "Carregando...",
                                "sProcessing": "Processando...",
                                "sZeroRecords": "Nenhum registro encontrado",
                                "sSearch": "Pesquisar",
                                "oPaginate": {
                                    "sNext": "Próximo",
                                    "sPrevious": "Anterior",
                                    "sFirst": "Primeiro",
                                    "sLast": "Último"
                                },
                                "oAria": {
                                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                                    "sSortDescending": ": Ordenar colunas de forma descendente"
                                }
                            }

                        });
                    });
                </script>


                <div class="panel panel-info">
                    <div class="panel-heading">
                        Para fazer uma pesquisa de CPF, CNPJ ou Nº de contrato, escolha um das opções e clique no botão <ins class="text-success"><i class="fa fa-search"></i> Pesquisar</ins>
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" name="contratos" id="contratos">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="email"> Escolha opção</label>
                                <div class="col-sm-3 ">
                                    <select class="form-control border-input"  name="escolha2" onchange="exibir_ocultar3(this)">
                                        <option value="vazio">Selecionar..</option>
                                        <option value="pesquisacpf">CPF</option>
                                        <option value="pesquisacnpj">CNPJ</option>
                                        <option value="pesquisanumcontrato">Nº CONTRATO</option>
                                        <!--  <option value="numcontrato">Nº CONTRATO</option>
                                          <option value="numcaixa">Nº CAIXA</option>-->
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="form-group" id="pesqcpf">
                            <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisa">
                                <label class="control-label col-sm-3" for="pwd">CPF</label>
                                <div class="col-sm-3">
                                    <input type="text"  size="25" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF">
                                </div>               
                                <div class="col-sm-3" > 
                                    <input type="submit" size="25" class="form-control" id="cadastrar" name="cadastrar" value="Pesquisar">
                                </div>
                            </form>
                        </div>
                        <div class="form-group" id="pesqcnpj">
                            <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisacnpj">
                                <label class="control-label col-sm-3" for="pwd">CNPJ</label>
                                <div class="col-sm-3 " > 
                                    <input type="text"  size="25" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o tipo da caixa">
                                </div>
                                <div class="col-sm-3" > 
                                    <input type="submit" size="25" class="form-control" id="incluir" name="incluir" value="Pesquisar">
                                </div>
                            </form>
                        </div>
                        <div class="form-group" id="numcontrat">
                            <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisacontrato">
                                <label class="control-label col-sm-3" for="pwd">Nº Contrato</label>
                                <div class="col-sm-3 " > 
                                    <input type="text"  size="25" class="form-control" id="numerocontrato" name="numerocontrato" placeholder="Digite o nº de contrato">
                                </div>
                                <div class="col-sm-3" > 
                                    <input type="submit"  class="form-control" id="incluir" name="incluir" value="Pesquisar">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="widget stacked widget-table action-table">

                    <div class="widget-header " style="padding-left: 10px; margin-top: 10px;">
                        <h4>Listagem de contratos</h4>         
                    </div> <!-- /widget-header -->

                    <div class="widget-content">

                        <table cellspacing="0" cellpading="0" border="0" class="table table-striped  table-bordered" id="produto1" >
                            <thead>

                            <th class="text-center">Nome </th>
                            <th class="text-center">Nº Contrato</th>
                            <th class="text-center">Produto</th>
                            <th class="text-center">Vencimento</th>
                            <th class="text-center">CPF</th>
                            <th class="text-center">CNPJ</th>
                            <th class="text-center">NOME DA CAIXA</th>
                            <th class="text-center">Nº DA CAIXA</th>

                            </thead>
                            <tbody>
                                <?php
                                $contrato = new contrato();
                                $contrato->camposPersonalizadosContrato();
                                $contrato->extras_select = "
                        inner join tb_caixa cc on cc.id_caixa = c.id_caixa
                        inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato
                        inner join tb_produto tp on tp.codigo_produto = c.codigo_produto
                       ";
                                $contrato->selecionaCampos($contrato);

                                while ($res = $contrato->retornaDados()):
                                    echo '<tr>';
                                    printf('<td class="text-center">%s</td>', utf8_encode($res->nome));
                                    printf('<td class="text-center">%s</td>', $res->numero_contrato);
                                    printf('<td class="text-center">%s</td>', $res->codigo_produto);
                                    printf('<td class="text-center">%s</td>', $res->vencimento);
                                    printf('<td class="text-center">%s</td>', $res->CPF);
                                    printf('<td class="text-center">%s</td>', $res->CNPJ);
                                    printf('<td class="text-center">%s</td>', utf8_encode($res->tipo_contrato));
                                    printf('<td class="text-center">%s</td>', $res->codigo_caixa);

                                    echo '</tr>';
                                endwhile;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            endif;
            ?>
            <?php
            switch ($tela):
                case 'pesquisa';
                    ?>
                    
                    <script>
                        $(function () {
                            $("#cpf").mask("999.999.999-99");
                            $("#cnpj").mask("99.999.999/9999-99");
                            document.querySelector("#pesqcpf").style.display = "none";
                            document.querySelector("#pesqcnpj").style.display = "none";
                            document.querySelector("#numcontrat").style.display = "none";
                        });
                        function exibir_ocultar3(val) {
                            //var tipo_parametro = document.querySelector("tipo-escolha").value;
                            if (val.value == 'pesquisacpf') {

                                document.querySelector("#pesqcpf").style.display = "block";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "none";
                            }
                            if (val.value == 'pesquisacnpj') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "block";
                                document.querySelector("#numcontrat").style.display = "none";
                            }

                            if (val.value == 'pesquisanumcontrato') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "block";
                            }
                            if (val.value == 'vazio') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "none";
                            }


                        }

                    </script>
                    <script>
                        $(document).ready(function () {

                            $("#produto").dataTable({
                                'sScrollY': "400px",
                                'bPaginate': true,
                                'aaSorting': [[0, 'asc']],
                                'searching': true,
                                "columnDefs": [
                                    {"width": "15%", "targets": 0},
                                    {"width": "15%", "targets": 1},
                                    {"width": "25%", "targets": 2},
                                    {"width": "25%", "targets": 3},
                                ],

                                "language": {
                                    "sEmptyTable": "Nenhum registro encontrado",
                                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                                    "sInfoPostFix": "",
                                    "sInfoThousands": ".",
                                    "sLengthMenu": "_MENU_ resultados por página",
                                    "sLoadingRecords": "Carregando...",
                                    "sProcessing": "Processando...",
                                    "sZeroRecords": "Nenhum registro encontrado",
                                    "sSearch": "Pesquisar",
                                    "oPaginate": {
                                        "sNext": "Próximo",
                                        "sPrevious": "Anterior",
                                        "sFirst": "Primeiro",
                                        "sLast": "Último"
                                    },
                                    "oAria": {
                                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                                        "sSortDescending": ": Ordenar colunas de forma descendente"
                                    }
                                }

                            });
                        });
                    </script>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Para fazer uma pesquisa de CPF, CNPJ ou Nº de contrato, escolha um das opções e clique no botão <ins class="text-success"><i class="fa fa-search"></i> Pesquisar</ins>
                        </div>
                        <div class="panel-body">

                            <form class="form-horizontal" role="form" method="POST" name="contratos" id="contratos">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email"> Escolha opção</label>
                                    <div class="col-sm-3 ">
                                        <select class="form-control border-input"  name="escolha2" onchange="exibir_ocultar3(this)">
                                            <option value="vazio">Selecionar..</option>
                                            <option value="pesquisacpf">CPF</option>
                                            <option value="pesquisacnpj">CNPJ</option>
                                            <option value="pesquisanumcontrato">Nº CONTRATO</option>
                                            <!--  <option value="numcontrato">Nº CONTRATO</option>
                                              <option value="numcaixa">Nº CAIXA</option>-->
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group" id="pesqcpf">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisa">
                                    <label class="control-label col-sm-3" for="pwd">CPF</label>
                                    <div class="col-sm-3">
                                        <input type="text"  size="25" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF">
                                    </div>               
                                    <div class="col-sm-3" > 
                                        <input type="submit" size="25" class="form-control" id="cadastrar" name="cadastrar" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                            <div class="form-group" id="pesqcnpj">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisacnpj">
                                    <label class="control-label col-sm-3" for="pwd">CNPJ</label>
                                    <div class="col-sm-3 " > 
                                        <input type="text"  size="25" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o tipo da caixa">
                                    </div>
                                    <div class="col-sm-3" > 
                                        <input type="submit" size="25" class="form-control" id="incluir" name="incluir" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                            <div class="form-group" id="numcontrat">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisacontrato">
                                    <label class="control-label col-sm-3" for="pwd">Nº Contrato</label>
                                    <div class="col-sm-3 " > 
                                        <input type="text"  size="25" class="form-control" id="numerocontrato" name="numerocontrato" placeholder="Digite o nº de contrato">
                                    </div>
                                    <div class="col-sm-3" > 
                                        <input type="submit"  class="form-control" id="incluir" name="incluir" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    $cpf = $_POST['cpf'];
                    if (isset($cpf)):
                        if ($cpf != ""):

                            $cliente = new cliente();
                            $cliente->extras_select = " where CPF = '" . $cpf . "'  order by nome";
                            $cliente->selecionaTudo($cliente);
                            while ($res = $cliente->retornaDados()):
                                if (isset($res)):
                                    printMSG('Dados encontrados com sucesso. '
                                            . '<a href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                                            . 'Clique aqui para voltar à pagina principal</a>');
                                    $cliente = new cliente();
                                    $cliente->extras_select = " where CPF = '" . $cpf . "'  order by nome";
                                    $cliente->selecionaTudo($cliente);
                                    while ($res = $cliente->retornaDados()):
                                        ?>
                                        <div class="panel panel-primary">
                                            <!-- Default panel contents -->
                                            <div class="panel-heading">
                                                <h2 class="panel-title">
                                                    Resultado da pesquisa por CPF 
                                                </h2>
                                            </div>
                                            <div class="panel-body">
                                                <h3>
                                                    <?php echo utf8_encode($res->nome); ?> - CPF Nº <?php echo $res->CPF; ?>
                                                </h3>

                                            </div>
                                            <?php
                                        endwhile;
                                        $contrato = new contrato();
                                        $contrato->camposPersonalizadosContrato();
                                        $contrato->extras_select = "
                                        inner join tb_caixa cc on cc.id_caixa = c.id_caixa
                                        inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato
                                        inner join tb_produto tp on tp.codigo_produto = c.codigo_produto
                                        where c.CPF = '" . $cpf . "' order by nome";
                                        $contrato->selecionaCampos($contrato);
                                        ?>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <table class="table table-hover table-bordered" id="produto">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nº Contrato</th>
                                                            <th class="text-center">Nº Caixa</th>
                                                            <th class="text-center">Tipo da Caixa</th>
                                                            <th class="text-center">Produto</th>
                                                            <th class="text-center">Data Vencimento</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        while ($res = $contrato->retornaDados()):

                                                            echo '<tr>';
                                                            printf('<td class="text-center">%s</td>', $res->numero_contrato);
                                                            printf('<td class="text-center">%s</td>', $res->codigo_caixa);
                                                            printf('<td class="text-center">%s</td>', utf8_encode($res->tipo_contrato));
                                                            printf('<td class="text-center">%s</td>', $res->descricao);
                                                            printf('<td class="text-center">%s</td>', $res->vencimento);
                                                            echo '</td> ';
                                                            echo '</tr>';
                                                        endwhile;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                else:
                                    echo "CPF INVÁLIDO, POR FAVOR INFORMA CPF CORRETO!";
                                    printMSG('<a href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                                            . 'Clique aqui para voltar à pagina principal</a>');
                                endif;
                            endwhile;
                        else:
                            echo '<div class="alert alert-danger" role="alert">DADOS NÃO FORAM ENCONTRADOS. POR FAVOR INFORMAR CPF CORRETAMENTE! <a href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                            . 'Clique aqui para voltar à pagina principal</a></div>';
                        endif;
                    else:
                        echo "Dados não foram encontrados";
                    endif;
                    break;
                case 'pesquisacnpj';
                    ?>

                    <script>
                        $(function () {
                            $("#cpf").mask("999.999.999-99");
                            $("#cnpj").mask("99.999.999/9999-99");
                            document.querySelector("#pesqcpf").style.display = "none";
                            document.querySelector("#pesqcnpj").style.display = "none";
                            document.querySelector("#numcontrat").style.display = "none";
                        });
                        function exibir_ocultar3(val) {
                            //var tipo_parametro = document.querySelector("tipo-escolha").value;
                            if (val.value == 'pesquisacpf') {

                                document.querySelector("#pesqcpf").style.display = "block";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "none";
                            }
                            if (val.value == 'pesquisacnpj') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "block";
                                document.querySelector("#numcontrat").style.display = "none";
                            }

                            if (val.value == 'pesquisanumcontrato') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "block";
                            }
                            if (val.value == 'vazio') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "none";
                            }


                        }

                    </script>
                    <script>
                        $(document).ready(function () {

                            $("#produto").dataTable({
                                'sScrollY': "400px",
                                'bPaginate': true,
                                'aaSorting': [[0, 'asc']],
                                'searching': true,
                                "columnDefs": [
                                    {"width": "15%", "targets": 0},
                                    {"width": "15%", "targets": 1},
                                    {"width": "25%", "targets": 2},
                                    {"width": "25%", "targets": 3},
                                ],

                                "language": {
                                    "sEmptyTable": "Nenhum registro encontrado",
                                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                                    "sInfoPostFix": "",
                                    "sInfoThousands": ".",
                                    "sLengthMenu": "_MENU_ resultados por página",
                                    "sLoadingRecords": "Carregando...",
                                    "sProcessing": "Processando...",
                                    "sZeroRecords": "Nenhum registro encontrado",
                                    "sSearch": "Pesquisar",
                                    "oPaginate": {
                                        "sNext": "Próximo",
                                        "sPrevious": "Anterior",
                                        "sFirst": "Primeiro",
                                        "sLast": "Último"
                                    },
                                    "oAria": {
                                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                                        "sSortDescending": ": Ordenar colunas de forma descendente"
                                    }
                                }

                            });
                        });
                    </script>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Para fazer uma pesquisa de CPF, CNPJ ou Nº de contrato, escolha um das opções e clique no botão <ins class="text-success"><i class="fa fa-search"></i> Pesquisar</ins>
                        </div>
                        <div class="panel-body">

                            <form class="form-horizontal" role="form" method="POST" name="contratos" id="contratos">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email"> Escolha opção</label>
                                    <div class="col-sm-3 ">
                                        <select class="form-control border-input"  name="escolha2" onchange="exibir_ocultar3(this)">
                                            <option value="vazio">Selecionar..</option>
                                            <option value="pesquisacpf">CPF</option>
                                            <option value="pesquisacnpj">CNPJ</option>
                                            <option value="pesquisanumcontrato">Nº CONTRATO</option>
                                            <!--  <option value="numcontrato">Nº CONTRATO</option>
                                              <option value="numcaixa">Nº CAIXA</option>-->
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group" id="pesqcpf">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisa">
                                    <label class="control-label col-sm-3" for="pwd">CPF</label>
                                    <div class="col-sm-3">
                                        <input type="text"  size="25" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF">
                                    </div>               
                                    <div class="col-sm-3" > 
                                        <input type="submit" size="25" class="form-control" id="cadastrar" name="cadastrar" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                            <div class="form-group" id="pesqcnpj">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisacnpj">
                                    <label class="control-label col-sm-3" for="pwd">CNPJ</label>
                                    <div class="col-sm-3 " > 
                                        <input type="text"  size="25" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o tipo da caixa">
                                    </div>
                                    <div class="col-sm-3" > 
                                        <input type="submit" size="25" class="form-control" id="incluir" name="incluir" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                            <div class="form-group" id="numcontrat">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisacontrato">
                                    <label class="control-label col-sm-3" for="pwd">Nº Contrato</label>
                                    <div class="col-sm-3 " > 
                                        <input type="text"  size="25" class="form-control" id="numerocontrato" name="numerocontrato" placeholder="Digite o nº de contrato">
                                    </div>
                                    <div class="col-sm-3" > 
                                        <input type="submit"  class="form-control" id="incluir" name="incluir" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    $cnpj = $_POST['cnpj'];
                    if (isset($cnpj)):

                        if ($cnpj != ""):
                            $cliente = new cliente();
                            $cliente->extras_select = " where CNPJ = '" . $cnpj . "'  order by nome";
                            $cliente->selecionaTudo($cliente);
                            while ($res = $cliente->retornaDados()):
                                if (isset($res)):
                                    printMSG('Dados encontrados com sucesso. '
                                            . '<a href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                                            . 'Clique aqui para voltar à pagina principal</a>');
                                    $cliente = new cliente();
                                    $cliente->extras_select = " where CNPJ = '" . $cnpj . "'  order by nome";
                                    $cliente->selecionaTudo($cliente);
                                    while ($res = $cliente->retornaDados()):
                                        ?>
                                        <div class="panel panel-primary">
                                            <!-- Default panel contents -->
                                            <div class="panel-heading">
                                                <h2 class="panel-title">
                                                    Resultado da pesquisa por CNPJ 
                                                </h2>
                                            </div>
                                            <div class="panel-body">
                                                <h3>
                                                    <?php echo utf8_encode($res->nome); ?> - CNPJ Nº <?php echo $res->CNPJ; ?>
                                                </h3>

                                            </div>
                                            <?php
                                        endwhile;
                                        $contrato = new contrato();
                                        $contrato->camposPersonalizadosContrato();
                                        $contrato->extras_select = "
                                        inner join tb_caixa cc on cc.id_caixa = c.id_caixa
                                        inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato
                                        inner join tb_produto tp on tp.codigo_produto = c.codigo_produto
                                        where c.CNPJ = '" . $cnpj . "' order by nome";
                                        $contrato->selecionaCampos($contrato);
                                        ?>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <table class="table table-hover table-bordered" id="produto">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nº Contrato</th>
                                                            <th class="text-center">Nº Caixa</th>
                                                            <th class="text-center">Tipo da Caixa</th>
                                                            <th class="text-center">Produto</th>
                                                            <th class="text-center">Data Vencimento</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        while ($res = $contrato->retornaDados()):

                                                            echo '<tr>';
                                                            printf('<td class="text-center">%s</td>', $res->numero_contrato);
                                                            printf('<td class="text-center">%s</td>', $res->codigo_caixa);
                                                            printf('<td class="text-center">%s</td>', utf8_encode($res->tipo_contrato));
                                                            printf('<td class="text-center">%s</td>', $res->descricao);
                                                            printf('<td class="text-center">%s</td>', $res->vencimento);
                                                            echo '</td> ';
                                                            echo '</tr>';
                                                        endwhile;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                else:
                                    echo "CNPJ INVÁLIDO, POR FAVOR INFORMA CNPJ CORRENTO!";
                                endif;
                            endwhile;
                        else:
                            echo '<div class="alert alert-danger" role="alert">DADOS NÃO FORAM ENCONTRADOS. POR FAVOR INFORMAR CNPJ CORRETAMENTE! <a href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                            . 'Clique aqui para voltar à pagina principal</a></div>';
                        endif;
                    else:
                        echo "Dados não foram encontrados";
                        printMSG('Dados encontrados com sucesso. '
                                . '<a href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                                . 'Voltar para pagina principal</a>');
                    endif;
                    break;
                case 'pesquisacontrato';
                    ?>

                    <script>
                        $(function () {
                            document.querySelector("#pesqcpf").style.display = "none";
                            document.querySelector("#pesqcnpj").style.display = "none";
                            document.querySelector("#numcontrat").style.display = "none";
                        });
                        function exibir_ocultar3(val) {
                            //var tipo_parametro = document.querySelector("tipo-escolha").value;
                            if (val.value == 'pesquisacpf') {

                                document.querySelector("#pesqcpf").style.display = "block";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "none";
                            }
                            if (val.value == 'pesquisacnpj') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "block";
                                document.querySelector("#numcontrat").style.display = "none";
                            }

                            if (val.value == 'pesquisanumcontrato') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "block";
                            }
                            if (val.value == 'vazio') {
                                document.querySelector("#pesqcpf").style.display = "none";
                                document.querySelector("#pesqcnpj").style.display = "none";
                                document.querySelector("#numcontrat").style.display = "none";
                            }


                        }

                    </script>
                    <script>
                        $(document).ready(function () {

                            $("#produto").dataTable({
                                'sScrollY': "400px",
                                'bPaginate': true,
                                'aaSorting': [[0, 'asc']],
                                'searching': true,
                                "columnDefs": [
                                    {"width": "15%", "targets": 0},
                                    {"width": "15%", "targets": 1},
                                    {"width": "25%", "targets": 2},
                                    {"width": "25%", "targets": 3},
                                ],

                                "language": {
                                    "sEmptyTable": "Nenhum registro encontrado",
                                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                                    "sInfoPostFix": "",
                                    "sInfoThousands": ".",
                                    "sLengthMenu": "_MENU_ resultados por página",
                                    "sLoadingRecords": "Carregando...",
                                    "sProcessing": "Processando...",
                                    "sZeroRecords": "Nenhum registro encontrado",
                                    "sSearch": "Pesquisar",
                                    "oPaginate": {
                                        "sNext": "Próximo",
                                        "sPrevious": "Anterior",
                                        "sFirst": "Primeiro",
                                        "sLast": "Último"
                                    },
                                    "oAria": {
                                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                                        "sSortDescending": ": Ordenar colunas de forma descendente"
                                    }
                                }

                            });
                        });
                    </script>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Para fazer uma pesquisa de CPF, CNPJ ou Nº de contrato, escolha um das opções e clique no botão <ins class="text-success"><i class="fa fa-search"></i> Pesquisar</ins>
                        </div>
                        <div class="panel-body">

                            <form class="form-horizontal" role="form" method="POST" name="contratos" id="contratos">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email"> Escolha opção</label>
                                    <div class="col-sm-3 ">
                                        <select class="form-control border-input"  name="escolha2" onchange="exibir_ocultar3(this)">
                                            <option value="vazio">Selecionar..</option>
                                            <option value="pesquisacpf">CPF</option>
                                            <option value="pesquisacnpj">CNPJ</option>
                                            <option value="pesquisanumcontrato">Nº CONTRATO</option>
                                            <!--  <option value="numcontrato">Nº CONTRATO</option>
                                              <option value="numcaixa">Nº CAIXA</option>-->
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group" id="pesqcpf">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisa">
                                    <label class="control-label col-sm-3" for="pwd">CPF</label>
                                    <div class="col-sm-3">
                                        <input type="text"  size="25" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF">
                                    </div>               
                                    <div class="col-sm-3" > 
                                        <input type="submit" size="25" class="form-control" id="cadastrar" name="cadastrar" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                            <div class="form-group" id="pesqcnpj">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisacnpj">
                                    <label class="control-label col-sm-3" for="pwd">CNPJ</label>
                                    <div class="col-sm-3 " > 
                                        <input type="text"  size="25" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o tipo da caixa">
                                    </div>
                                    <div class="col-sm-3" > 
                                        <input type="submit" size="25" class="form-control" id="incluir" name="incluir" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                            <div class="form-group" id="numcontrat">
                                <form class="form-horizontal" role="form" method="POST" name="pesquisar" id="pesquisar" action="?m=usuario-externo&t=pesquisacontrato">
                                    <label class="control-label col-sm-3" for="pwd">Nº Contrato</label>
                                    <div class="col-sm-3 " > 
                                        <input type="text"  size="25" class="form-control" id="numerocontrato" name="numerocontrato" placeholder="Digite o nº de contrato">
                                    </div>
                                    <div class="col-sm-3" > 
                                        <input type="submit"  class="form-control" id="incluir" name="incluir" value="Pesquisar">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                    $numero = $_POST['numerocontrato'];
                    if (isset($numero)):
                        if ($numero != ""):
                            ?>
                            <div class="panel panel-primary">
                                <!-- Default panel contents -->
                                <div class="panel-heading">
                                    <h2 class="panel-title">
                                        Resultado da pesquisa para o contrato Nº : <?php echo $_POST['numerocontrato']; ?>
                                    </h2>
                                </div>
                                <div class="panel-body">

                                </div>
                                <?php
                                $contrato = new contrato();
                                $contrato->extras_select = " where numero_contrato = " . $numero . "";
                                $contrato->selecionaTudo($contrato);
                                while ($res = $contrato->retornaDados()):
                                    if (isset($res)):
                                        printMSG('Dados encontrados com sucesso. '
                                                . '<a href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                                                . 'Clique aqui para voltar à pagina principal</a>');
                                        $contrato = new contrato();
                                        $contrato->camposPersonalizadosContrato();
                                        $contrato->extras_select = "
                                        inner join tb_caixa cc on cc.id_caixa = c.id_caixa
                                        inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato
                                        inner join tb_produto tp on tp.codigo_produto = c.codigo_produto
                                        where c.numero_contrato = " . $numero . "";
                                        $contrato->selecionaCampos($contrato);
                                        ?>
                                        <ul class="list-group">

                                            <li class="list-group-item">

                                                <table class="table table-hover table-bordered" id="produto">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nome cliente</th>
                                                            <th class="text-center">Nº Caixa</th>
                                                            <th class="text-center">Tipo da Caixa</th>
                                                            <th class="text-center">Produto</th>
                                                            <th class="text-center">Data Vencimento</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($res = $contrato->retornaDados()):

                                                            echo '<tr>';
                                                            printf('<td class="text-center">%s</td>', utf8_encode($res->nome));
                                                            printf('<td class="text-center">%s</td>', $res->codigo_caixa);
                                                            printf('<td class="text-center">%s</td>', utf8_encode($res->tipo_contrato));
                                                            printf('<td class="text-center">%s</td>', $res->descricao);
                                                            printf('<td class="text-center">%s</td>', $res->vencimento);
                                                            echo '</td> ';
                                                            echo '</tr>';
                                                        endwhile;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                else:
                                    echo "Nº DE CONTRATO INVÁLIDO, POR FAVOR INFORMA Nº DE CONTRATO CORRENTO!";
                                endif;
                            endwhile;
                        else:
                            echo '<div class="alert alert-danger" role="alert">DADOS NÃO FORAM ENCONTRADOS. POR FAVOR INFORMAR Nº DE CONTRATO CORRETAMENTE! <a href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                            . 'Clique aqui para voltar à pagina principal</a></div>';
                        endif;
                    else:
                        printMSG('Dados não encontrados. '
                                . '<a class="text-danger" href="' . ADMURL . '?m=usuario-externo&t=pesquisa">'
                                . 'Voltar para pagina principal</a>');
                    endif;
                    break;
            endswitch;
            ?>
        </div>
        <br>
        <br>
        <br>

    </div>