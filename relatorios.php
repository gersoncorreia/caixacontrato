<?php
require_once('funcoes.php');

/*$user = new usuarios();*/
$produtos = new produtos();
$produtos->extras_select = "JOIN marcas ON produtos.MarcasId = marcas.MarcasId
JOIN categorias ON produtos.CategoriasId = categorias.CategoriasId";

$produtos->selecionaTudo($produtos);

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

//if ($print):
//    $pdf->SetDrawColor(255, 255, 255);
//else:
//    $print = false;
//endif;


//CABECALHO
$pdf->Cell(51,6,'Descricao',1,0,'C');
$pdf->Cell(12,6,'Qtd',1,0,'C');
$pdf->Cell(22,6,'Preco',1,0,'C');
$pdf->Cell(15,6,'Genero',1,0,'C');
$pdf->Cell(40,6,'Marca',1,0,'C');
$pdf->Cell(50,6,'Categoria',1,1,'C');



$float = 2;
$i=0;

//$pdf->SetFillColor(240);

while ($res = $produtos->retornaDados()):
    if(is_float($i/2)):
        $pdf->SetFillColor(240);
        $pdf->Cell(51,6,$res->ProdutosDesc,'L',0,'C', true);
        $pdf->Cell(12,6,$res->ProdutosQtd,0,0,'C', true);
        $pdf->Cell(22,6,$res->ProdutosPrecoVenda,0,0,'C', true);
        $pdf->Cell(15,6,$res->ProdutosGenero,0,0,'C', true);
        $pdf->Cell(40,6,$res->MarcasNome,0,0,'C', true);
        $pdf->Cell(50,6,$res->CategoriasNome,'R',1,'C', true);
    else:
        $pdf->SetFillColor(200);
        $pdf->Cell(51,6,$res->ProdutosDesc,'L',0,'C',true);
        $pdf->Cell(12,6,$res->ProdutosQtd,0,0,'C',true);
        $pdf->Cell(22,6,$res->ProdutosPrecoVenda,0,0,'C',true);
        $pdf->Cell(15,6,$res->ProdutosGenero,0,0,'C',true);
        $pdf->Cell(40,6,$res->MarcasNome,0,0,'C',true);
        $pdf->Cell(50,6,$res->CategoriasNome,'R',1,'C',true);
    endif;

        $i++;
endwhile;


    $pdf->Cell(190,10, '', 'T',1,'C');

    $pdf->Ln(20);
    $pdf->Cell(190,6, $i.' resultados encontrados', 1,1,'L');



$pdf->Output();




/* The \b in the pattern indicates a word boundary, so only the distinct
 * word "web" is matched, and not a word partial like "webbing" or "cobweb" */




//$url = $_SERVER['PHP_SELF'];
//echo $url."<br>";
//
//
//if (preg_match("/\bweb\b/i", "PHP is the web scripting language of choice.")) {
//    echo "A match was found."."<br>";
//} else {
//    echo "A match was not found."."<br>";
//}
//
//if (preg_match("/\bweb\b/i", "PHP is the website scripting language of choice.")) {
//    echo "A match was found. "."<br>";
//} else {
//    echo "A match was not found."."<br>";
//}
?>
