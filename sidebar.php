<?php
    require_once('funcoes.php');
    protegeArquivo(basename(__FILE__));
?>
<div id="sidebar">
    <ul class="nav nav-pills nav-stacked">
        <li class=""><a href="<?php echo BASEURL ?>"><p class="text-left"><span class="glyphicon glyphicon-home pull-right"></span>Inicio</p></a></li>
        
        <li class="dropdown">
            <a  data-toggle="collapse" data-target="#usuarios" href="#">Usuários<span class="caret pull-right"></span></a>
            
            <ul class="collapse nav" id="usuarios">
                <li><a href="?m=usuarios&t=incluir">Cadastrar</a></li>
                <li><a href="?m=usuarios&t=listar">Exibir</a></li>                      
            </ul>
        </li>
        
        <li class="dropdown">
            <a  data-toggle="collapse" data-target="#produtos" href="#">Caixas<span class="caret pull-right"></span></a>
            
            <ul class="collapse nav" id="produtos">
                <li><a href="?m=caixa&t=incluir">Cadastrar</a></li>
                <li><a href="?m=caixa&t=listar">Exibir</a></li>
                <li><a href="relatorios.php">Relatórios<span class="glyphicon glyphicon-list-alt pull-right"></span></a></li> 
            </ul>
        </li>
        
        
        <?php
        $sessao = new sessao();
        $meuid = $sessao->getVar('iduser');
        ?>
        <!--<li><a href="?m=usuarios&t=senha&id=<?php //echo $meuid; ?>">Troca senha</a></li>-->
        <li><a href="?logoff=true"><span class="glyphicon glyphicon-off pull-right"></span>Sair</a></li>
    </ul>
</div> <!--sidebar-->

