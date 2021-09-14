<?php
verificaLogin();

switch ($tela):
    case 'incluir':
        if (isset($_POST['cadastrar'])):
            $caixa = new caixa(array(
                "id_tipo_contrato" => $_POST['tipo'],
                //"data_cad" => date('Y-m-d H:i'),
                "status" => 'A',
                "situacao" => 'C',
            ));

            $caixa->inserir($caixa);
            echo "linhas afetadas" . $caixa->linhasafetadas;
            if ($caixa->linhasafetadas == -1):
                $msg = "";
                $msg = '<i class="fa fa-check fa-1x"></i> Caixa adicionada com sucesso !';
                echo '<script type="text/javascript"> '
                . 'alert("Adicionado com sucesso!!"); '
                . 'location.href="?LoadCaixa=listar";</script>';
                // printMSG('Dados inseridos com sucesso. <a href="' . ADMURL . '?m=caixa&t=listar">Exibir cadastros</a>');
                unset($_POST);
            endif;
        endif;
        ?>
        <!--<fieldset>
            <legend>
                <button type="button" class="btn btn-default" onclick="location.href = '?LoadCaixa=listar'" title="Rertonar para o painel principal!"><i class="fa fa-reply-all fa-2x" ></i> Voltar</button>
                <button type="button" class="btn btn-default" onclick="location.href = '?m=caixa&t=listar'" title="Retorna para listagem de CAIXAS!"><i class="fa fa-list fa-2x"></i> CAIXA CONTRATOS</button>
                <button type="button" class="btn btn-success" onclick="location.href = '?m=tipo-contrato&t=incluir'" title="Direciona p/ Tipo Contrato"><i class="fa fa-plus fa-2x"></i> Adicionar Tipo de Contrato</button>
                <h2>Adicionar uma nova CAIXA <i class="fa fa-archive"></i> </h2>
            </legend>
        </fieldset>        

        <form class="form-horizontal col-md-offset-3" role="form" method="POST" name="cadestoque" id="cadestoque">       
            <div class="form-group cadastro">
                <label for="tipo" class="col-sm-3 control-label">Tipo Contrato</label>
                <div class="col-sm-3">
                    <input name="operacao" type="text" class="form-control" id="operacao" placeholder="Operaзгo">
                    <select name="tipo" id="tipo" class="form-control form-inline" required="true" >
                        <option value="">Selecione a ação</option>
        <?php /*
          $tipocontrato = new tipocontrato();
          $tipocontrato->selecionaTudo($tipocontrato);

          while ($res = $tipocontrato->retornaDados()) {

          printf('<option value="%s">%s</option>', $res->id_tipo_contrato, $res->tipo_contrato);
          } */
        ?>                 
                    </select>
                </div>
            </div>

            <div class="form-group"> 
                <div class=" col-md-offset-3 col-sm-8">
                    <button type="submit" class="btn btn-success" name="cadastrar" id="cadastrar" data-toggle="modal" data-target="#myModal" title="Salva as informações da nova caixa!"><i class="fa fa-floppy-o fa-2x"></i> Salvar</button>
                </div>
            </div>
        </form>-->

        <?php
        break;
    case 'listar':
        echo '<fieldset><legend><h2 class="text-info">Caixas Contrato <i class="fa fa-archive fa-2x"></i> </h2></legend></fieldset>';
        ?>
        <script>
            $(function () {
                document.querySelector("#mostrar-caixa").style.display = "none";
                document.querySelector("#mostrar-addc").style.display = "none";
                document.querySelector("#mostrar-produto").style.display = "none";
            });
            function exibir_ocultar2(val) {
                //var tipo_parametro = document.querySelector("tipo-escolha").value;
                if (val.value == 'adicionarcaixa') {

                    document.querySelector("#mostrar-caixa").style.display = "block";
                    document.querySelector("#mostrar-addc").style.display = "none";
                    document.querySelector("#mostrar-produto").style.display = "none";
                }
                if (val.value == 'adicionartipocaixa') {
                    document.querySelector("#mostrar-addc").style.display = "block";
                    document.querySelector("#mostrar-caixa").style.display = "none";
                    document.querySelector("#mostrar-produto").style.display = "none";
                }

                if (val.value == 'adicionarproduto') {
                    document.querySelector("#mostrar-produto").style.display = "block";
                    document.querySelector("#mostrar-addc").style.display = "none";
                    document.querySelector("#mostrar-caixa").style.display = "none";
                }
                if (val.value == 'vazio') {
                    document.querySelector("#mostrar-caixa").style.display = "none";
                    document.querySelector("#mostrar-produto").style.display = "none";
                    document.querySelector("#mostrar-addc").style.display = "none";
                }


            }

        </script>
        <div class="panel panel-info">
            <div class="panel-heading">
                Para adicionar uma nova caixa, tipo de caixa ou produto, escolha um das opções e clique no botão <ins class="text-success"><i class="fa fa-plus-square fa-check"></i> Adicionar Caixa</ins>
            </div>
            <div class="panel-body">

                <form class="form-horizontal" role="form" method="POST" name="contratos" id="contratos">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email"> Escolha opção</label>
                        <div class="col-sm-3 ">
                            <select class="form-control border-input"  name="escolha1" onchange="exibir_ocultar2(this)" >
                                <option value="vazio">Selecionar..</option>
                                <option value="adicionarcaixa">CAIXA</option>
                                <?php
                                if (!isAdmin()):

                                else:
                                    ?>
                                    <option value="adicionartipocaixa">Tipo de CAIXA</option>
                                    <option value="adicionarproduto">Produto</option>
                                <?php
                                endif;
                                ?>

                                <!--  <option value="numcontrato">Nº CONTRATO</option>
                                  <option value="numcaixa">Nº CAIXA</option>-->
                            </select>
                        </div>
                    </div>
                </form>
                <div class="form-group" id="mostrar-caixa">
                    <form class="form-horizontal" role="form" method="POST" name="caixa" id="caixa" action="?m=caixa&t=incluir">
                        <label class="control-label col-sm-3" for="pwd">Caixa</label>
                        <div class="col-sm-3">
                            <!--<input name="operacao" type="text" class="form-control" id="operacao" placeholder="Operaзгo">-->
                            <select name="tipo" id="tipo" class="form-control form-inline" required="true" >
                                <option value="">Tipo de CAIXA</option>
                                <?php
                                $tipocontrato = new tipocontrato();
                                $tipocontrato->selecionaTudo($tipocontrato);

                                while ($res = $tipocontrato->retornaDados()) {

                                    printf('<option value="%s">%s</option>', $res->id_tipo_contrato, utf8_encode($res->tipo_contrato));
                                }
                                ?>                 
                            </select>
                        </div>               
                        <div class="col-sm-3" > 
                            <input type="submit" size="25" class="form-control" id="cadastrar" name="cadastrar" value="Adicionar">
                        </div>
                    </form>
                </div>

                <div class="form-group" id="mostrar-addc">
                    <form class="form-horizontal" action="?m=tipo-contrato&t=incluir" role="form" method="POST" name="tipo-caixa" id="tipo-caixa">
                        <label class="control-label col-sm-3" for="pwd">Tipo de caixa</label>
                        <div class="col-sm-3 " > 
                            <input type="text"  size="25" class="form-control" id="tipo-caixa" name="tipo-caixa" placeholder="Digite o tipo da caixa">
                        </div>
                        <div class="col-sm-3" > 
                            <input type="submit" size="25" class="form-control" id="cadastrar" name="cadastrar" value="Adicionar">
                        </div>
                    </form>
                </div>
                <div class="form-group" id="mostrar-produto">
                    <form class="form-horizontal" action="?m=produto&t=incluir" role="form" method="POST" name="produto" id="produto">
                        <label class="control-label col-sm-3" for="pwd">Produto</label>
                        <div class="col-sm-2 " > 
                            <input type="text"  size="25" class="form-control" id="codigop" name="codigop" placeholder="Codigo do produto">
                        </div>
                        <div class="col-sm-3 " > 
                            <input type="text"  size="25" class="form-control" id="produto" name="produto" placeholder="Digite descrição do produto">
                        </div>
                        <div class="col-sm-2" > 
                            <input type="submit"  class="form-control" id="cadastrar" name="cadastrar" value="Adicionar">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--<a class="btn  btn-default "  href="?m=painel" title="Reterona para o painel principal!">
            <i class="fa fa-reply fa-2x"></i> Voltar 
        </a>
        <a class="btn  btn-success "  href="?m=caixa&t=incluir" title="Adiciona uma nova caixa no sistema!">
            <i class="fa fa-plus fa-2x"></i> Adicionar CAIXA
        </a>-->

        <script>
            $(document).ready(function () {

                $("#lista").dataTable({
                    'sScrollY': "400px",
                    'bPaginate': true,
                    'aaSorting': [[0, 'asc']],
                    'searching': true,
                    "columnDefs": [
                        {"width": "30%", "targets": 0},
                        {"width": "30%", "targets": 1},
                        {"width": "25%", "targets": 3}
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
                <table cellspacing="0" cellpading="0" border="0" class="table table-striped  table-bordered" id="lista" >
                    <thead>

                    <th class="text-center b">Caixa Contrato </th>
                    <th class="text-center">Estado da Caixa</th>
                    <th class="text-center">Data de criação</th>
                    <th class="text-center">Ações</th>

                    </thead>
                    <tbody>
                        <?php
                        $caixa = new caixa();
                        $caixa->camposPersonalizadosCaixa();
                        $caixa->extras_select = "INNER JOIN tb_tipo_contrato tc on 
                        tc.id_tipo_contrato = cc.id_tipo_contrato
                        where cc.situacao = 'C' ORDER BY cc.id_caixa 
                        
                        ";

                        $caixa->selecionaCampos($caixa);

                        while ($res = $caixa->retornaDados()):
                            echo '<tr>';
                            printf('<td class="text-center">%s - Nº %s</td>', utf8_encode($res->tipo_contrato), $res->codigo_caixa);

                            if ($res->status == 'A'):
                                printf('<td class="text-center text-success"><i class="fa fa-folder-open fa-x2"></i> Caixa aberta</td>');
                            else:
                                if ($res->status == 'F'):
                                    printf('<td class="text-center text-danger"><i class="fa fa-folder fa-x2"></i> Caixa fechada</td>');
                                endif;
                            endif;
                            printf('<td class="text-center">%s</td>', $res->data_cad);
                            printf('<td class="text-center">
                                <form class="form-horizontal" role="form" method="POST" name="excluircontrat" id="excluircontrat">
                                
                                        <a class="btn  btn-success" href="?m=caixa&t=detalhar&id=%s&idTipo=%s&codigo=%s&acao=ver" title="Entrar na caixa"> 
                                        <i class="fa fa-sign-in fa-x2"></i></a>', $res->id_caixa, $res->id_tipo_contrato, $res->codigo_caixa);

                            printf(' | <a class="btn  btn-primary" href="?m=caixa&t=alterar&id=%s&codigo=%s" title="Alterar informas da Caixa">
                                        <i class="fa fa-edit"></i></a> | ', $res->id_caixa, $res->codigo_caixa);
                            printf(' <a class="btn  btn-warning" href="?m=caixa&t=imprimir&id=%s&codigo=%s" title="Imprimir etique da Caixa">
                                        <i class="fa fa-print"></i></a>', $res->id_caixa, $res->codigo_caixa);
                            
                            printf('
                                        <input type="text" size="25"  id="id" name="id" value="%s" hidden="" >                                        
                                        <input hidden="" type="text" size="50"  id="codigo" name="codigo" value="%s"   >                                   
                                        <button type="submit" name="deletar" class="btn  btn-danger"  title="Excluir Contrato" data-toggle="modal" data-target="#myDetail">
                                            <i class="fa fa-close fa-1x"></i>
                                        </button>
                                    </form>                                        
                                    ', $res->id_caixa, $res->codigo_caixa);
                            
                            echo '</td> ';
                            echo '</tr>';

                        endwhile;
                        ?>
                    </tbody>
                </table>

                <?php
                if (isset($_POST['deletar'])):
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#myDetail').modal('show')
                        }
                        );
                    </script>
                    <!--MODAL DE FINALIZACAO DA COMPRA-->
                    <form method="POST" action="?m=caixa&t=excluircaixa&id=<?php echo $_POST['id']; ?>&codigo=<?php echo $_POST['codigo']; ?>" name="formexcluir">
                        <div class="modal fade" id="myDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>
                                    <div class="modal-body">                                      

                                        <h5 class="alert alert-warning" role="alert" id="exampleModalCenterTitle">
                                            <i class="fa fa-exclamation-triangle fa-2x"></i>
                                            Tem certeza que deseja excluir a caixa? </h5>
                                        <input type="text" size="25"  id="id" name="id" value="<?php echo $_POST['id']; ?>" hidden=""  >
                                        <input type="text" size="25"  id="codigo" name="codigo" value="<?php echo $_POST['codigo']; ?>" hidden="" >
                                        
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                                        <button type="submit" class="btn btn-primary" name="confirmar">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                endif;
                ?>
            </div>
        </div>
        <?php
        break;

    case 'detalhar':
        $id = $_GET['id'];
        $idC = $_GET['idTipo'];
        $codigo = $_GET['codigo'];

        $caixa = new caixa();
        $caixa->camposPersonalizadosCaixa();
        $caixa->extras_select = "
        inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato 
        where cc.id_tipo_contrato = " . $idC . " and cc.codigo_caixa = " . $codigo . " ";

        $caixa->selecionaCampos($caixa);

        while ($res = $caixa->retornaDados()):
            echo '<fieldset><legend class="text-info"><h2>Caixa - nº ' . $res->codigo_caixa . ' <i class="fa fa-archive fa-2x"></i></h2>
                    <h4>Tipo: ' . utf8_encode($res->tipo_contrato) . ' | Cadastro em: ' . $res->data_cad . ' | Fechado em: ' . $res->data_fecha . '</h4></legend></fieldset>';
        endwhile;
        ?>



        <script>
            $(document).ready(function () {

                $("#produto").dataTable({
                    'sScrollY': "400px",
                    'bPaginate': true,
                    'aaSorting': [[0, 'asc']],
                    'searching': true,
                    "columnDefs": [
                        {"width": "20%", "targets": 0},
                        {"width": "12%", "targets": 1},
                        {"width": "9%", "targets": 2},
                        {"width": "9%", "targets": 3},
                        {"width": "15%", "targets": 5},
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
        <script type="text/javascript">
            document.excluircontrat.reset();
        </script>
        <div style="margin-bottom: 10px;">           
            <a class="btn  btn-default" href="?LoadCaixa=listar " title="Rertonar para listagem de CAIXAS!">
                <i class="fa fa-reply fa-2x" ></i> VOLTAR
            </a>
            <a class="btn  btn-danger "  href="?m=caixa&t=fechar&id=<?php echo $id ?>" title="Fecha a caixa!">
                <i class="fa fa-close fa-2x" ></i> Fechar CAIXA
            </a>
            <a class="btn  btn-success "  href="?m=contrato&t=incluir&id=<?php echo $id ?>&idTipo=<?php echo $idC ?>&codigo=<?php echo $codigo ?>" title="Cadastra um novo contrato!">
                <i class="fa fa-plus fa-2x" ></i> Adicionar Contrato
            </a>
        </div>
        <div class="widget stacked widget-table action-table">
            <div class="widget-header " style="padding-left: 10px;">
                <h4>Listagem de contratos</h4>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <table cellspacing="0" cellpading="0" border="0" class="table table-striped  table-bordered" id="produto" >
                    <thead>

                    <th class="text-center">Nome </th>
                    <th class="text-center">Nº Contrato</th>
                    <th class="text-center">Produto</th>
                    <th class="text-center">Vencimento</th>
                    <th class="text-center">CPF</th>
                    <th class="text-center">CNPJ</th>
                    <th class="text-center">Ações</th>

                    </thead>
                    <tbody>
                        <?php
                        $contrato = new contrato();
                        $contrato->camposPersonalizadosContrato();
                        $contrato->extras_select = "
                        inner join tb_caixa cc on cc.id_caixa = c.id_caixa
                        inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato
                        inner join tb_produto tp on tp.codigo_produto = c.codigo_produto
                        where c.id_caixa = " . $id . " and c.situacao = 'C' ";
                        $contrato->selecionaCampos($contrato);

                        while ($res = $contrato->retornaDados()):
                            echo '<tr>';
                            printf('<td class="text-center">%s</td>', utf8_encode($res->nome));
                            printf('<td class="text-center">%s</td>', $res->numero_contrato);
                            printf('<td class="text-center">%s</td>', $res->codigo_produto);
                            printf('<td class="text-center">%s</td>', $res->vencimento);
                            printf('<td class="text-center">%s</td>', $res->CPF);
                            printf('<td class="text-center">%s</td>', $res->CNPJ);
                            printf('<td class="text-center">');
                            printf(' <form class="form-horizontal" role="form" method="POST" name="excluircontrat" id="excluircontrat">                               
                              <a class="btn  btn-success "  href="?m=contrato&t=incluir&id=%s&idTipo=%s&codigo=%s" title="Cadastra um novo contrato!">
                              <i class="fa fa-plus " ></i></a> | ', $res->id_caixa, $res->id_tipo_contrato, $res->codigo_caixa);
                            printf('                               
                                        <a class="btn  btn-primary" href="?m=contrato&t=alterar&id=%s&idTipo=%s&codigo=%s&idC=%s" title="Alterar informações do Contrato"> 
                                        <i class="fa fa-sign-in fa-1x"></i></a> | ', $res->id_caixa, $res->id_tipo_contrato, $res->codigo_caixa, $res->id_contrato);
                            printf(' 
                                    
                                        <input type="text" size="25"  id="id" name="id" value="%s" hidden="" >
                                        <input type="text" size="25"  id="idT" name="idT" value="%s" hidden="">
                                        <input hidden="" type="text" size="50"  id="codigo" name="codigo" value="%s"   >
                                        <input hidden="" type="text" size="50"  id="idC" name="idC" value="%s"   >
                                        <button type="submit" name="deletar" class="btn  btn-danger"  title="Excluir Contrato" data-toggle="modal" data-target="#myDetail">
                                            <i class="fa fa-close fa-1x"></i>
                                        </button>
                                    </form>                                        
                                    ', $res->id_caixa, $res->id_tipo_contrato, $res->codigo_caixa, $res->id_contrato);
                            echo '</td> ';
                            echo '</tr>';
                        endwhile;
                        ?>
                    </tbody>
                </table>
                <?php
                if (isset($_POST['deletar'])):
                    ?>
                    <script>
                        $(document).ready(function () {
                            $('#myDetail').modal('show')
                        }
                        );
                    </script>
                    <!--MODAL DE FINALIZACAO DA COMPRA-->
                    <form method="POST" action="?m=caixa&t=excluir&id=<?php echo $_POST['id']; ?>&idTipo=<?php echo $_POST['idT']; ?>&codigo=<?php echo $_POST['codigo']; ?>&idC=<?php echo $_POST['idC']; ?>" name="excluircontrat">
                        <div class="modal fade" id="myDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                    </div>
                                    <div class="modal-body">                                      

                                        <h5 class="alert alert-warning" role="alert" id="exampleModalCenterTitle">
                                            <i class="fa fa-exclamation-triangle fa-2x"></i>
                                            Tem certeza que deseja excluir este contrato? </h5>
                                        <input type="text" size="25"  id="id" name="id" value="<?php echo $_POST['id']; ?>" hidden=""  >
                                        <input type="text" size="25"  id="codigo" name="codigo" value="<?php echo $_POST['codigo']; ?>" hidden="" >
                                        <input type="text" size="50"  id="idC" name="idC" value="<?php echo $_POST['idC']; ?>" hidden=""   >
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                                        <button type="submit" class="btn btn-primary" name="confirmar">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                endif;
                ?>
            </div>
        </div>
        <?php
        break;
    case 'alterar':
        $id = $_GET['id'];
        $codigo = $_GET['codigo'];

        echo '<h2>Alterar informações da caixa <i class="fa fa-file-text "></i></h2><hr>';
        if (isset($_POST['atualizar'])):
            $caixa = new caixa(array(
                "id_tipo_contrato" => $_POST['tipocaixa'],
                "status" => $_POST['status'],
                "situacao" => $_POST['situacao'],
            ));
            $caixa->valorpk = $id;
            $caixa->atualizar($caixa);
            $msg = "";
            $msg = '<i class="fa fa-check fa-1x"></i> Caixa adicionada com sucesso !';
            echo '<script type="text/javascript"> '
            . 'alert("Atualização realizada com sucesso!!"); '
            . 'location.href="?LoadCaixa=listar";</script>';
            unset($_POST);

        else:

        endif;
        ?>
        <script>
            $(function ($) {
                // Aqui fazemos uso do plugin MASKED INPUT
                $("#datav").mask("99/99/9999");
                $("#cpf1").mask("999.999.999-99");
                $("#cnpj1").mask("99.999.999/9999-99");
                //$("#cep").mask("99.999-999");
                // $("#telefone").mask("(99) 9999-9999");
                // $("#celular").mask("(99)99999-9999");
                // Aqui usamos fazemos uso do plugin MASK MONEY
                //$("#valor").maskMoney({thousands: '', decimal: ','});
            });
            // Dispara o Autocomplete a partir do segundo caracter
            // Dispara o Autocomplete a partir do segundo caracter


        </script>

        <form class="form-horizontal" role="form" method="POST" name="contratos" id="contratos">
            <input hidden="" type="text" size="50"  id="id" name="id" value="<?php echo $_GET['id']; ?>"   >
            <input hidden="" type="text" size="50"  id="codigo" name="codigo" value="<?php echo $_GET['codigo']; ?>"  >            

            <?php
            $codigoC = $_GET['codigo'];
            $idcaixa = $_GET['id'];

            $caixa = new caixa();
            $caixa->camposPersonalizadosCaixa();
            $caixa->extras_select = "             
                inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato                
                where cc.id_caixa = " . $idcaixa . " and cc.codigo_caixa = " . $codigoC . "";
            $caixa->selecionaCampos($caixa);

            while ($res = $caixa->retornaDados()):
                ?>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Status da caixa: 
                        <?php
                        $caixa1 = new caixa();
                        $caixa1->extras_select = "where id_caixa = " . $_GET['id'] . "";
                        $caixa1->selecionaTudo($caixa1);
                        while ($res = $caixa1->retornaDados()) {
                            $stat = $res->status;
                        }
                        if ($stat == "A"):
                            printf('<span class="text-success">Caixa Aberta</span>');
                        else:
                            printf('<span class="text-danger">Caixa Fechada</span>');
                        endif;
                        ?>
                    </label>
                    <div class="col-sm-3"> 
                        <select name="status" id="status" class="form-control form-inline" required="true" >
                            <option value="">Selecione uma opção..</option>
                            <option value="A">Aberta</option>
                            <option value="F">Fechada</option>                           
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Situação : 
                        <?php
                        $caixa = new caixa();
                        $caixa->extras_select = "where id_caixa = " . $_GET['id'] . "";
                        $caixa->selecionaTudo($caixa);
                        while ($res = $caixa->retornaDados()) {
                            $situacao = $res->situacao;
                        }
                        if ($situacao == "C"):
                            printf('<span class="text-success">Caixa Cadastrada</span>');
                        else:
                            printf('<span class="text-danger">Caixa Excluida</span>');
                        endif;
                        ?>       
                    </label>
                    <div class="col-sm-3"> 
                        <select name="situacao" id="situacao" class="form-control form-inline" required="true" >
                            <option value="">Selecione uma opção..</option>
                            <option value="A">Atualizada</option>
                            <option value="C">Cadastrada</option>
                            <option value="E">Excluida</option>
                        </select>
                    </div>
                </div>
                <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default" onclick="location.href = '?LoadCaixa=listar'" title ="Retorna para CAIXA DE CONTRATOS"><i class="fa fa-reply fa-2x"></i> Voltar</button>
                        <button type="submit" class="btn btn-default" name="atualizar" id="atualizar"  title="Confirma alteração dos dados!"><i class="fa fa-edit fa-2x"></i> Alterar </button>
                    </div>
                </div>
            </form>
            <?php
        endwhile;

        break;

    case 'excluir':
        //echo $_GET['idC'];
        // $_GET['codigo'];      
        if (isset($_POST['confirmar'])):

            $contrato = new contrato(array(
                'situacao' => 'E',
            ));
            $contrato->valorpk = $_GET['idC'];
            $contrato->extras_select = "whre id_contrato = " . $_GET['idC'] . "";
            $contrato->atualizar($contrato);


            echo '<script type="text/javascript"> '
            . 'alert("Contrato excluido com sucesso!!"); '
            . 'location.href="painel.php?m=caixa&t=detalhar&id=' . $_GET['id'] . '&idTipo=' . $_GET['idTipo'] . '&codigo=' . $_GET['codigo'] . '";</script>';


        endif;

        break;

    case 'excluircaixa':

        $id = $_GET['id'];
        $codigo = $_GET['codigo'];

        $caixa = new caixa(array(
            'situacao' => 'E'
        ));

        $caixa->valorpk = $id;
        $caixa->extras_select = "whre id_caixa = " . $id . "";
        $caixa->atualizar($caixa);
        echo '<script type="text/javascript"> '
        . 'alert("Caixa excluido com sucesso!!"); '
        . 'location.href="painel.php?LoadCaixa=listar";</script>';

        break;
    case 'fechar':

        $id = $_GET['id'];

        $caixa = new caixa(array(
            'status' => 'F',
                //'data_fechamento' => date('Y-m-d H:i')
        ));

        $caixa->valorpk = $id;
        $caixa->extras_select = "whre id_caixa = " . $id . "";
        $caixa->atualizar($caixa);
        echo '<script type="text/javascript"> '
        . 'alert("Caixa foi fechada com sucesso!!"); '
        . 'location.href="painel.php?LoadCaixa=listar";</script>';

        break;

    case 'imprimir':
        $idcaixa = $_GET['id'];
        $codigo = $_GET['codigo'];
        $caixa = new caixa();
        $caixa->camposPersonalizadosCaixa();
        $caixa->extras_select = "             
                inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato                
                where cc.id_caixa = " . $idcaixa . " and cc.codigo_caixa = " . $codigo . "";
        $caixa->selecionaCampos($caixa);
        while ($res = $caixa->retornaDados()) {
            ?>
            <script>
                window.onload = function () {
                    var imprimir = document.querySelector("#imprimir");
                    imprimir.onclick = function () {
                        imprimir.style.display = 'none';
                        window.print();

                        var time = window.setTimeout(function () {
                            imprimir.style.display = 'block';
                        }, 1000);
                    }
                }
            </script>
            <div class="container" style="background:linear-gradient(#ffffff, #F3F3F3); border:2px solid #CCCCCC; width: 500px; height:200px; margin-top:50px;">
                <div class="row"><!--primeira linha-->
                    <fieldset style="mar"><legend><h1 style="margin-left: 15px;" align="center">CAIXA - Nº <?php echo $res->codigo_caixa ?></h1></legend></fieldset>
                </div><!--Fim Segunda linha-->
                <div class="row"><!--primeira linha-->
                    <h3 style="margin-left: 15px;" align="center">Tipo de Caixa - <?php echo utf8_encode($res->tipo_contrato) ?></h3>
                    <h4 style="margin-left: 15px;" align="center">Data de Cadastro: <?php echo $res->data_cad ?></h4>
                </div><!--Fim Segunda linha-->
            </div>
            <br>
            <center>

                <button type="button" class="btn btn-default" onclick="location.href = '?LoadCaixa=listar'" title ="Retorna para CAIXA DE CONTRATOS"><i class="fa fa-reply fa-2x"></i> Voltar</button>

                <button type="button" class="btn btn-default" onclick="window.print()" title ="Retorna para CAIXA DE CONTRATOS"><i class="fa fa-print fa-2x"></i> Imprimir</button>
            </center>
            <?php
        }
        break;
    default:
        echo 'Tela Padrao do estoque!';
endswitch;
?>
