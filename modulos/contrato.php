<?php
verificaLogin();
require_once(dirname(dirname(__FILE__)) . "/funcoes.php");
protegeArquivo(basename(__FILE__));

if (isset($_GET['id'])):
    $id = $_GET['id'];
else:
    $id = null;
endif;

if (isset($_GET['acao']) == 'add'):
    $acao = $_GET['acao'];
else:
    $acao = null;
endif;

if (isset($_GET['acao']) == 'update'):
    $acao = $_GET['acao'];
else:
    $acao = null;
endif;

if (isset($_GET['acao']) == 'delete'):
    $acao = $_GET['acao'];
else:
    $acao = null;
endif;


//$cart = new cart();

switch ($tela):
    case 'incluir':
        echo '<fieldset><legend><h2>Cadastrar Contrato <i class="fa fa-file-text fa-1x"></i> </h2></legend></fieldset> ';

        if (isset($_POST['cadastrar'])):
            $idC = $_POST['idTipo'];
            $nome = $_POST['nome'];
            $nomeb = $_POST['nomeb']; //campo com o nome original do vem do banco de dados da tabela cliente
            $idcliente = $_POST['idcliente']; //campo com o nome original do vem do banco de dados da tabela cliente
            $cpf = $_POST['cpf'];
            $cpfb = $_POST['cpfb'];
            $cnpj = $_POST['cnpj'];
            $cnpjb = $_POST['cnpjb'];
            //$dataI = date('Y-m-d H:i');
            $encontrou = $_POST['encontrou'];
            $numcontrato = "";

            $contrato = new contrato();
            $contrato->extras_select = "where numero_contrato= " . $_POST['ncont'];
            $contrato->selecionaTudo($contrato);
            while ($res = $contrato->retornaDados()):
                $numcontrato = $res->numero_contrato;
                $codigoproduto = $res->codigo_produto;
            endwhile;



            if ($numcontrato == $_POST['ncont'] && $numcontrato != "" && $codigoproduto == $_POST['codproduto']):
                echo '<div class="alert alert-warning" role="alert"><i class="fa fa-exclamation-triangle fa-2x"></i> Foi verificado que o codigo de produto <ins>' . $_POST['codproduto'] .
                '</ins> já encontra-se vinculado ao numero de contrato: <ins>Nº ' . $_POST['ncont'] . '</ins>,'
                . ' informações já registradas no sistema!<br> Por favor informar outro tipo de produto para o mesmo nº de contrato!</div>';
            else:
                $contrato = new contrato(array(
                    "id_caixa" => $_POST['id'],
                    "codigo_caixa" => $_POST['codigo'],
                    "codigo_produto" => $_POST['codproduto'],
                    "nome" => $_POST['nome'],
                    "numero_contrato" => $_POST['ncont'],
                    "vencimento" => $_POST['datav'],
                    //"data_inclusao" => date('Y-m-d H:i'),
                    "CPF" => $cpf,
                    "CNPJ" => $cnpj,
                    "situacao" => "C"
                ));

                //Limpar mascaras do CPF e CNPJ
                // $chars = array(".", "/", "-");
                //$cnpj = str_replace($chars, "", $_POST['cnpj']); 


                $contrato->inserir($contrato);


                if ($contrato->linhasafetadas == 1):

                    printMSG('Dados inseridos com sucesso. '
                            . '<a href="' . ADMURL . '?m=caixa&t=detalhar&id=' . $_POST['id'] . '&idTipo=' . $idC . '&codigo=' . $_POST['codigo'] . '">'
                            . 'Exibir cadastros</a>');
                    unset($_POST);
                endif;
            endif;

            $cliente = new cliente(array(
                "nome" => $nome,
                "CPF" => $cpf,
                "CNPJ" => $cnpj,
                    //"data_inclusao" => $dataI
            ));

            if ($encontrou != 'S'):
                if ($cpfb != $cpf || $cnpjb != $cnpj):
                    $cliente->inserir($cliente);

                    if ($cliente->linhasafetadas == 1):

                        unset($_POST);
                    endif;
                endif;

            endif;


            if ($nomeb != $nome && $cpfb == $cpf && $nomeb != "" && $cpfb != ""):
                $cliente = new cliente(array(
                    'nome' => $nome,
                ));
                $cliente->valorpk = $idcliente;
                //$cliente->extras_select = " where CPF = '".$cpf."' ";
                $cliente->atualizar($cliente);

            else:

            endif;

            if ($nomeb != $nome && $cnpjb == $cnpj && $cnpjb != "" && $nomeb != ""):
                $cliente = new cliente(array(
                    'nome' => $nome,
                ));
                $cliente->valorpk = $idcliente;
                $cliente->extras_select = " where CNPJ = '" . $cnpj . "' ";
                $cliente->atualizar($cliente);

            else:

            endif;

        endif;
        ?>
        <script>
            $(function ($) {
                // Aqui fazemos uso do plugin MASKED INPUT
                $("#datav").mask("99/99/9999");
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



        <form class="form-horizontal" role="form" method="POST" name="contratos" id="contratos">
            <input hidden="" type="text" size="50"  id="id" name="id" value="<?php echo $_GET['id']; ?>"   >
            <input hidden="" type="text" size="50"  id="idTipo" name="idTipo" value="<?php echo $_GET['idTipo']; ?>"  >            
            <input hidden="" type="text" size="50"  id="codigo" name="codigo" value="<?php echo $_GET['codigo']; ?>"  >            
            <div class="form-group">
                <label class="control-label col-sm-3" for="email"> Tipo Documento</label>
                <div class="col-sm-3 ">
                    <select class="form-control border-input"  name="escolha" onchange="exibir_ocultar(this)">
                        <option value="vazio">Selecionar..</option>
                        <option value="cpf1">CPF</option>
                        <option value="cnpj1">CNPJ</option>
                        <!--  <option value="numcontrato">Nº CONTRATO</option>
                          <option value="numcaixa">Nº CAIXA</option>-->
                    </select>
                </div>
            </div>
            <div class="form-group" id="moratar-cpf">
                <label class="control-label col-sm-3" for="pwd">CPF </label>
                <div class="col-sm-3" > 
                    <input type="text" size="25" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" >
                </div>
            </div>
            <div class="form-group" id="mostrar-cnpj">
                <label class="control-label col-sm-3" for="pwd">CNPJ</label>
                <div class="col-sm-3 " > 
                    <input type="text"  size="25" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o CNPJ">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="nome">Nome</label>
                <div class="col-sm-5">
                    <input type="text" size="50" class="form-control" id="nome" name="nome"  placeholder="Digite o nome do cliente" required>
                    <input type="hidden" size="50" class="form-control" id="nomeb" name="nomeb"  >
                    <input type="hidden" size="50" class="form-control" id="idcliente" name="idcliente"  >
                    <input type="hidden" size="50" class="form-control" id="cpfb" name="cpfb"  >
                    <input type="hidden" size="50" class="form-control" id="cnpjb" name="cnpjb"  >
                    <input type="hidden" size="50" class="form-control" id="encontrou" name="encontrou"  >

                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Nº do contrato</label>
                <div class="col-sm-3"> 
                    <input type="text" size="12" class="form-control" id="ncont" name="ncont" placeholder="Digite nº contrato" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Data de vencimento</label>
                <div class="col-sm-3"> 
                    <input type="text" size="35" class="form-control" id="datav" name="datav" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="precv">Tipo de Produto</label>
                <div class="col-sm-3"> 
                    <select name="codproduto" id="codproduto" class="form-control form-inline" required="true" required>
                        <option value="">Selecione um produto..</option>
                        <?php
                        $tipoproduto = new produto();
                        $tipoproduto->selecionaTudo($tipoproduto);

                        while ($res = $tipoproduto->retornaDados()) {

                            printf('<option value="%s"> %s</option>', $res->codigo_produto, $res->descricao);
                        }
                        ?>            
                    </select>
                </div>
            </div>

            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="location.href = '?m=caixa&t=detalhar&id=<?php echo $_GET['id'] ?>&idTipo=<?php echo $_GET['idTipo'] ?>&codigo=<?php echo $_GET['codigo'] ?>'"><i class="fa fa-close fa-2x"></i> Cancelar</button>
                    <button type="submit" class="btn btn-default" name="cadastrar" id="cadastrar"><i class="fa fa-floppy-o fa-2x"></i> Cadastrar</button>

                </div>
            </div>
        </form>

        <?php
        break;
    case 'alterar':
        echo '<h2>Alterar Contrato <i class="fa fa-file-text "></i></h2><hr>';

        if (isset($_POST['ok'])):
            $contrato = new contrato(array(
                "codigo_produto" => $_POST['cproduto'],
                "numero_contrato" => $_POST['ncontrato']
            ));
            $contrato->valorpk = $_POST['id'];
            $contrato->atualizar($contrato);
            printMSG('Dados atualizados com sucesso. '
                    . '<a href="' . ADMURL . '?m=caixa&t=detalhar&id=' . $_GET['id'] . '&idTipo=' . $_GET['idTipo'] . '&codigo=' . $_POST['codigo'] . '">'
                    . 'voltar para CAIXA DE CONTRATOS</a>');
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
            <input hidden="" type="text" size="50"  id="id" name="id" value="<?php echo $_GET['idC']; ?>"   >
            <input hidden="" type="text" size="50"  id="codigo" name="codigo" value="<?php echo $_GET['codigo']; ?>"  >            

            <?php
            $codigoC = $_GET['codigo'];
            $idcontrato = $_GET['idC'];

            $contrato = new contrato();
            $contrato->camposPersonalizadosContrato();
            $contrato->extras_select = "
                inner join tb_caixa cc on cc.id_caixa = c.id_caixa
                inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato
                inner join tb_produto tp on tp.codigo_produto = c.codigo_produto
                where c.id_contrato = " . $idcontrato . " and cc.codigo_caixa = " . $codigoC . "";
            $contrato->selecionaCampos($contrato);

            while ($res = $contrato->retornaDados()):
                $CPF = $res->CPF;
                $CNPJ = $res->CNPJ;
                ?>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">CPF</label>
                    <div class="col-sm-3"> 
                        <input type="text" size="25" class="form-control" id="cpf1" name="cpf" value="<?php echo $CPF ?>" placeholder="Digite o CPF" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">CNPJ</label>
                    <div class="col-sm-3"> 
                        <input type="text" size="25" class="form-control" id="cnpj1" name="cnpj" value="<?php echo $CNPJ ?>" placeholder="Digite o CNPJ" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Nome</label>
                    <div class="col-sm-7">
                        <input type="hidden" size="50" class="form-control" id="id" name="id" value="<?php echo $res->id_contrato ?>" >
                        <input type="text" size="50" class="form-control" id="nome" name="nome" value="<?php echo $res->nome ?>"  placeholder="Digite o nome do cliente" disabled="">

                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Nº do contrato</label>
                    <div class="col-sm-3"> 
                        <input type="text" size="12" class="form-control" id="ncont" name="ncont" value="<?php echo $res->numero_contrato ?>" placeholder="Digite nº contrato" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Data de vencimento</label>
                    <div class="col-sm-3"> 
                        <input type="text" size="35" class="form-control" id="datav" name="datav" value="<?php echo $res->vencimento ?>" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="precv">Tipo de Produto</label>
                    <div class="col-sm-3"> 
                        <select name="codproduto" id="codproduto" class="form-control form-inline"  >
                            <option value="<?php echo $res->codigo_produto ?>"> <?php echo $res->descricao ?> </option>
                            <?php
                            $tipoproduto = new produto();
                            $tipoproduto->selecionaTudo($tipoproduto);

                            while ($res = $tipoproduto->retornaDados()) {

                                printf('<option value="%s"> %s</option>', $res->codigo_produto, $res->descricao);
                            }
                            ?>            
                        </select>
                    </div>
                </div>

                <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default" onclick="location.href = '?m=caixa&t=detalhar&id=<?php echo $_GET['id'] ?>&idTipo=<?php echo $_GET['idTipo'] ?>&codigo=<?php echo $_GET['codigo'] ?>'" title="Retorna para CAIXA DE CONTRATOS"><i class="fa fa-reply fa-2x"></i> Voltar</button>
                        <button type="submit" class="btn btn-default" name="confirma" id="confirma"  title="Confirma alteração dos dados!" data-toggle="modal" data-target="#myDetail">
                            <i class="fa fa-edit fa-2x"></i> Alterar 
                        </button>
                    </div>
                </div>
            </form>
            <?php
        endwhile;
        if (isset($_POST['confirma'])):
            ?>
            <script>
                $(document).ready(function () {
                    $('#myDetail').modal('show')
                }
                );
            </script>
            <!--MODAL DE FINALIZACAO DA COMPRA-->
            <form method="POST" action="" name="formconcluir">
                <div class="modal fade" id="myDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <h5 class="alert alert-warning" role="alert" id="exampleModalCenterTitle">
                                    <i class="fa fa-exclamation-triangle fa-2x"></i>
                                    Tem certeza que deseja alterar essas informações? </h5>
                            </div>
                            <div class="modal-body">
                                <?php
                                $contrato = new contrato();
                                $contrato->camposPersonalizadosContrato();
                                $contrato->extras_select = "
                                inner join tb_caixa cc on cc.id_caixa = c.id_caixa
                                inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato
                                inner join tb_produto tp on tp.codigo_produto = c.codigo_produto
                                where c.id_contrato = " . $idcontrato . " and cc.codigo_caixa = " . $codigoC . "";
                                $contrato->selecionaCampos($contrato);
                                while ($res = $contrato->retornaDados()):
                                    ?>
                                    <legend><h4>Informações do Contrato</h4></legend>
                                    <strong>Nome:</strong> <?php echo $res->nome; ?><br>
                                    <strong>CPF:</strong> <?php echo $res->CPF; ?><br>
                                    <strong>CNPJ:</strong> <?php echo $res->CNPJ; ?><br>
                                    <strong>Nº DE CONTRATO:</strong> <?php echo $res->numero_contrato ?><br>
                                    <strong>DATA VENCIMENTO:</strong> <?php echo $res->vencimento; ?>
                                    <p><strong>TIPO PRODUTO: </strong><?php echo $res->codigo_produto ?> </p><br>
                                    <hr>
                                    <legend><h4>Informações há serem alteradas</h4></legend>
                                    <strong>NOVO Nº DE CONTRATO:</strong> <?php echo $_POST['ncont']; ?><br>
                                    <p><strong>NOVO TIPO PRODUTO: </strong><?php echo $_POST['codproduto']; ?> </p><br>

                                    <input type="text" size="25"  id="ncontrato" name="ncontrato" value="<?php echo $_POST['ncont']; ?>" hidden="" >
                                    <input type="text" size="25"  id="cproduto" name="cproduto" value="<?php echo $_POST['codproduto']; ?>" hidden="">
                                    <input hidden="" type="text" size="50"  id="id" name="id" value="<?php echo $_GET['idC']; ?>"   >
                                    <input hidden="" type="text" size="50"  id="codigo" name="codigo" value="<?php echo $_GET['codigo']; ?>"  >
                                    <?php
                                endwhile;
                                ?>



                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancelar</button>
                                <button type="submit" class="btn btn-primary" name="ok">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>    
            <?php
        endif;


        break;

    default:
        echo 'Tela não selecionada';
        break;


endswitch;
?>
