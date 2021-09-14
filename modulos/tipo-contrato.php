<?php
verificaLogin();
require_once(dirname(dirname(__FILE__)) . "/funcoes.php");
protegeArquivo(basename(__FILE__));

switch ($tela):
    case 'incluir':
        if (isset($_POST['cadastrar'])):
            $tipo = new tipocontrato(array(
                "tipo_contrato" => $_POST['tipo-caixa'],
               
            ));

            $tipo->inserir($tipo);

            if ($tipo->linhasafetadas == -1):
                
                $msg = "";
                echo '<script type="text/javascript"> '
                . 'alert("Adicionado com sucesso!!"); '
                . 'location.href="?LoadCaixa=listar";</script>';
                //printMSG('Dados inseridos com sucesso. <a href="' . ADMURL . '?m=caixa&t=listar">Exibir cadastros</a>');
                unset($_POST);
            endif;
        endif;
        
        break;
    case 'listar':
        ?>
        <fieldset >
            <legend>
                <h2>Listagem Tipo d Contratos <i class="fa fa-list"></i> </h2>
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

                    <th class="text-center">id</th>
                    <th class="text-center">Tipo de Contrato</th>
                    <th class="text-center">Ações</th>

                    </thead>
                    <tbody>
                        <?php
                        $tipocontrato = new tipocontrato();
                        $tipocontrato->selecionaTudo($tipocontrato);

                        while ($res = $tipocontrato->retornaDados()) {
                            echo '<tr>';

                            printf('<td class="text-center">%s</td>', $res->id_tipo_contrato);
                            printf('<td class="text-center">%s</td>', utf8_encode($res->tipo_contrato));
                            printf('<td class="text-center">                               
                                        <a class="btn  btn-success" href="?m=tipo-contrato&t=incluir" title="Cadastrar Tipo de Contrato"> 
                                        <i class="fa fa-sign-in fa-x2"></i></a>');
                            printf(' | <a class="btn  btn-primary" href="?m=tipo-contrato&t=editar&id=%s" title="Alterar informas Tipo de contrato">
                                        <i class="fa fa-edit"></i></a> | ', $res->id_tipo_contrato);
                            printf(' <a class="btn  btn-danger" href="?m=tipo-contrato&t=excluir&id=%s" title="Excluir Tipo de Contrato">
                                        <i class="fa fa-close"></i></a>', $res->id_tipo_contrato);
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
                <h2>Alterar Tipo de Contrato </h2>

            </legend>
        </fieldset>

        <?php
        if (isset($_POST['alterar'])):
            $tipocontrato = new tipocontrato(array(
                "tipo_contrato" => $_POST['tipocontrato']
            ));
            $tipocontrato->valorpk = $_POST['id'];
            $tipocontrato->atualizar($tipocontrato);
            printMSG('Dados alterados com sucesso. <a href="' . ADMURL . '?m=tipo-contrato&t=listar">Exibir lista Tipo de Contratos</a>');
            unset($_POST);

        endif;

        $tipocontrato = new tipocontrato();
        $tipocontrato->extras_select = "where id_tipo_contrato = " . $_GET['id'] . "";
        $tipocontrato->selecionaTudo($tipocontrato);

        while ($res = $tipocontrato->retornaDados()):
            ?>
            <form class="form-horizontal col-sm-offset-3" role="form" method="POST" name="cadestoque" id="cadestoque"> 
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Tipo de Contrato</label>
                    <div class="col-sm-4"> 
                        <input type="text"  class="form-control" id="tipocontrato" name="tipocontrato" value="<?php echo utf8_encode($res->tipo_contrato) ?>" placeholder="Digite o tipo de contrato" required>
                        <input type="hidden"  class="form-control" id="id" name="id" value="<?php echo $res->id_tipo_contrato ?>" >
                    </div>
                </div>

                <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-success" name="alterar" id="alterar" title="Altera informações Tipo de Contrato!" ><i class="fa fa-floppy-o fa-2x" ></i> Salvar</button>
                    </div>
                </div>
            </form>
            <?php
        endwhile;
        break;
endswitch;
?>