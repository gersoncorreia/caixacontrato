<?php

if (isset($_GET['m'])):
    $modulo = $_GET['m'];
else:
    $modulo = null;
endif;
if (isset($_GET['t'])):
    $tela = $_GET['t'];
endif;
if (isset($_GET['id'])):
    $id = $_GET['id'];
else:
    $id = null;
endif;
if (isset($_GET['LoadCaixa'])):
    $LoadCaixa = $_GET['LoadCaixa'];
else:
    $LoadCaixa = null;
endif;
if (isset($_GET['tela'])):
    $tela = $_GET['tela'];
else:
    $tela = null;
endif;

include('header.php');
?>


<div class="col-md-10 content col-md-offset-1">
    <div class="well">
        <?php //include('navbar.php');  ?>


        <?php
        if ($modulo != null and $tela != null):
            loadmodulo($modulo, $tela);
        else:
            if ($LoadCaixa != Null):
                loadmodulo('caixa', 'listar');
            else:
                echo "Não foi encontrato o modulo!"
                ?>                  
        
            </div>
            <br>
            <br>
            <br>

        </div>
    <?php
    endif;
endif
?>



<?php include('footer.php'); ?>