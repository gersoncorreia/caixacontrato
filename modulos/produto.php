<?php
require_once(dirname(dirname(__FILE__)) . "/funcoes.php");
protegeArquivo(basename(__FILE__));
verificaLogin();

switch ($tela):
    case 'incluir':

        if (isset($_POST['cadastrar'])):
            $prod = new produto(array(
                "descricao" => $_POST['produto'],
                "codigo_produto" => $_POST['codigop'],
            ));

            $prod->inserir($prod);
            $msg = "";
            $msg = '<i class="fa fa-check fa-1x"></i> Caixa adicionada com sucesso !';
            echo '<script type="text/javascript"> '
            . 'alert("Adicionado com sucesso!!"); '
            . 'location.href="?LoadCaixa=listar";</script>';

            // printMSG('Dados inseridos com sucesso. <a href="' . ADMURL . '?m=painel">Exibir cadastros</a>');
            unset($_POST);
           /* if ($prod->linhasafetadas == 1):

                $msg = "";
                $msg = '<i class="fa fa-check fa-1x"></i> Caixa adicionada com sucesso !';
                echo '<script type="text/javascript"> '
                . 'alert("Adicionado com sucesso!!"); '
                . 'location.href="?LoadCaixa=listar";</script>';

                // printMSG('Dados inseridos com sucesso. <a href="' . ADMURL . '?m=painel">Exibir cadastros</a>');
                unset($_POST);
            endif;*/
        endif;

        break;
    case 'listar':
        ?>
        <fieldset >
            <legend>
                <h2>Listagem de Produtos <i class="fa fa-list"></i> </h2>
                <button type="button" class="btn btn-default" onclick="location.href = '?m=painel'" title="Rertonar para o painel principal!"><i class="fa fa-reply-all fa-2x" ></i> Voltar</button>
                <button type="button" class="btn btn-default" onclick="location.href = '?m=caixa&t=listar'" title="Rertonar para listagem de CAIXAS!"><i class="fa fa-list fa-2x" title="Rertonar para listagem de CAIXAS!"></i> CAIXAS</button>

            </legend>
        </fieldset>
        <script>
            $(document).ready(function () {

                $("#produto").dataTable({
                    'sScrollY': "400px",
                    'bPaginate': true,
                    'aaSorting': [[0, 'asc']],
                    'searching': true,
                    "columnDefs": [
                        {"width": "5%", "targets": 0},
                        {"width": "15%", "targets": 1},
                        {"width": "10%", "targets": 2}
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
        <div class="widget stacked widget-table action-table" style="margin-top: 10px;">
            <div class="widget-header">
                <i class="icon-th-list"></i>

            </div> <!-- /widget-header -->
            <div class="widget-content">
                <table cellspacing="0" cellpading="0" border="0" class="table table-striped  table-bordered" id="produto" >
                    <thead>

                    <th class="text-center">Codigo Produto </th>
                    <th class="text-center">Descrição</th>
                    <th class="text-center">Ações</th>

                    </thead>
                    <tbody>
                        <?php
                        $prod = new produto();
                        $prod->selecionaTudo($prod);

                        while ($res = $prod->retornaDados()) {
                            echo '<tr>';

                            printf('<td class="text-center">%s</td>', $res->codigo_produto);
                            printf('<td class="text-center">%s</td>', $res->descricao);
                            printf('<td class="text-center">                               
                                        <a class="btn  btn-success" href="?m=produto&t=incluir" title="Cadastrar produto"> 
                                        <i class="fa fa-sign-in fa-x2"></i></a>');
                            printf(' | <a class="btn  btn-primary" href="?m=produto&t=editar&id=%s" title="Alterar informas do PRODUTO">
                                        <i class="fa fa-edit"></i></a> | ', $res->id_produto);
                            printf(' <a class="btn  btn-danger" href="?m=produto&t=excluir&id=%s" title="Excluir PRODUTO">
                                        <i class="fa fa-close"></i></a>', $res->id_produto);
                            echo '</td> ';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        break;
    case 'editar':
        ?>
        <fieldset >
            <legend>
                <h2>Alterar Produto </h2>

            </legend>
        </fieldset>

        <?php
        if (isset($_POST['alterar'])):
            $prod = new produto(array(
                "descricao" => $_POST['descricao'],
                "codigo_produto" => $_POST['codigo'],
            ));
            $prod->valorpk = $_POST['id'];
            $prod->atualizar($prod);
            printMSG('Dados alterados com sucesso. <a href="' . ADMURL . '?m=produto&t=listar">Exibir lista de produtos</a>');
            unset($_POST);

        endif;

        $prod = new produto();
        $prod->extras_select = "where id_produto = " . $_GET['id'] . "";
        $prod->selecionaTudo($prod);

        while ($res = $prod->retornaDados()):
            ?>


            <form class="form-horizontal col-sm-offset-3" role="form" method="POST" name="cadestoque" id="cadestoque"> 

                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Descrição</label>
                    <div class="col-sm-4"> 
                        <input type="text"  class="form-control" id="descricao" name="descricao" value="<?php echo $res->descricao ?>" placeholder="Digite a descrição do produto" required>
                        <input type="hidden"  class="form-control" id="id" name="id" value="<?php echo $res->id_produto ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Codigo</label>
                    <div class="col-sm-4"> 
                        <input type="text"  class="form-control" id="codigo" name="codigo" value="<?php echo $res->codigo_produto ?>" placeholder="Digite codigo do produto" required>
                    </div>
                </div>
                <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-success" name="alterar" id="alterar" title="Altera informações do produto!" ><i class="fa fa-floppy-o fa-2x" ></i> Salvar</button>
                    </div>
                </div>
            </form>
            <?php
        endwhile;
        break;
endswitch;
