<?php
//Arquivo AJAX

require_once(dirname(dirname(__FILE__)) . "/funcoes.php");
$acao = (isset($_GET['acao'])) ? $_GET['acao'] : '';
$parametro = (isset($_GET['parametro'])) ? $_GET['parametro'] : '';
$p = (isset($_GET['p'])) ? $_GET['p'] : '';
$dados = "";

$parametropesquisa = (isset($_GET['param'])) ? $_GET['param'] : '';

if ($acao == 'autocomplete'):
    $cliente = new cliente();
    if ($p == 'cpf'):
        $cliente->extras_select = " where CPF LIKE '%" . $parametro . "%' ORDER BY nome ASC";
    else:
        $cliente->extras_select = " where CNPJ LIKE '%" . $parametro . "%' ORDER BY nome ASC";
    endif;

    $cliente->selecionaCampos($cliente);
    while ($res = $cliente->retornaDados()):
        $dados[] = $res;
    endwhile;

    if (empty($dados)):
        echo "não foram encontrado dados!";
    else:
        $json = json_encode($dados);
        echo $json;

    endif;

endif;

if (isset($_POST['cpf']) || isset($_POST['cnpj']) || isset($_POST['num-contrato']) || isset($_POST['num-caixa'])):



    echo $paramCPF = $_POST['cpf1'];
    echo $paramCNPJ = $_POST['cnpj'];

    switch ($_POST['tipo-escolha']):
        case 'cpf':
            if (empty($paramCPF)):
                echo "Informe o Cpf!";
            else:
                
                echo "chegou ate aqui";
                $msg = "";
                $msg .= '<table style="background-color: #e3f2fd" class="table table-striped table-hover table-bordered" >';
                $msg .= "	<thead>";
                $msg .= "		<tr>";
                $msg .= "			<th class='text-center'>Caixa</th>";
                $msg .= "			<th class='text-center'>Produto</th>";
                $msg .= "			<th class='text-center'>Nº contrato:</th>";
                $msg .= "			<th class='text-center'>Nome</th>";
                $msg .= "			<th class='text-center'>CPF</th>";
                $msg .= "			<th class='text-center'>CNPJ</th>";
                $msg .= "			<th class='text-center'>Vencimento</th>";
                $msg .= "		</tr>";
                $msg .= "	</thead>";
                $msg .= "	<tbody>";
                $contrato = new contrato();
                $contrato->camposPersonalizadosContrato();
                $contrato->extras_select = "
                        inner join tb_caixa cc on cc.id_caixa = c.id_caixa
                        inner join tb_tipo_contrato tc on tc.id_tipo_contrato = cc.id_tipo_contrato
                        inner join tb_produto tp on tp.codigo_produto = c.codigo_produto
                        where  c.CPF LIKE '%".$paramCPF."%' order by nome LIMIT 3;";
                $contrato->selecionaCampos($contrato);

                while ($res = $contrato->retornaDados()):
                    echo '<tr>';
                    printf('<td class="text-center">%s</td>', $res->nome);
                    printf('<td class="text-center">%s</td>', $res->numero_contrato);
                    printf('<td class="text-center">%s</td>', $res->codigo_produto);
                    printf('<td class="text-center">%s</td>', $res->vencimento);
                    printf('<td class="text-center">%s</td>', $res->CPF);
                    printf('<td class="text-center">%s</td>', $res->CNPJ);
                    
                    echo '</tr>';
                endwhile;


                $msg .= "	</tbody>";
                $msg .= "</table>";

                echo $msg;
                


            endif;
            break;
        case 'cnpj':
            if (empty($paramCNPJ)):
                echo "Informe o Cpf!";
            else:

                $msg = "";
                $msg .= '<table style="background-color: #e3f2fd" class="table table-striped table-hover table-bordered" >';
                $msg .= "	<thead>";
                $msg .= "		<tr>";
                $msg .= "			<th class='text-center'>Caixa</th>";
                $msg .= "			<th class='text-center'>Produto</th>";
                $msg .= "			<th class='text-center'>Nº contrato:</th>";
                $msg .= "			<th class='text-center'>Nome</th>";
                $msg .= "			<th class='text-center'>CPF</th>";
                $msg .= "			<th class='text-center'>CNPJ</th>";
                $msg .= "			<th class='text-center'>Vencimento</th>";
                $msg .= "		</tr>";
                $msg .= "	</thead>";
                $msg .= "	<tbody>";
                $contrat = new Contratos();
                $contrat->setCnpj($paramCNPJ);
                $dados2 = $contrat->pegaCNPJ();

                if (empty($dados2)):
                    $msg .= "					<td class='text-center'> - </td>";
                    $msg .= "					<td class='text-center'> - </td>";
                    $msg .= "					<td class='text-center'> - </td>";
                    $msg .= "					<td class='text-center'> - </td>";
                    $msg .= "					<td class='text-center'> - </td>";
                    $msg .= "					<td class='text-center'> - </td>";
                    $msg .= "					<td class='text-center'> - </td>";
                else:
                    $res = new ArrayIterator($dados2);

                    while ($res->valid()):

                        $msg .= "				<tr>";
                        $msg .= "					<td class='text-center'>" . $res->current()->codigoCaixa . "</td>";
                        $msg .= "					<td class='text-center'>" . $res->current()->descricao . "</td>";
                        $msg .= "					<td class='text-center'>" . $res->current()->numero_contrato . "</td>";
                        $msg .= "					<td class='text-center'>" . $res->current()->nome . "</td>";
                        $msg .= "					<td class='text-center'>" . $res->current()->CPF . "</td>";
                        $msg .= "					<td class='text-center'>" . $res->current()->CNPJ . "</td>";
                        $msg .= "					<td class='text-center'>" . $res->current()->data_venc . "</td>";
                        $msg .= "				</tr>";
                        $res->next();
                    endwhile;
?>
                <?php

                endif;
                $msg .= "	</tbody>";
                $msg .= "</table>";

                echo $msg;
            endif;
            break;
    /*
      case 'numcontrato':
      echo "numcontrato";
      break;
      case 'numcaixa':
      echo "numcaixa";
      break;
     * */
    endswitch;
endif;
                ?>
