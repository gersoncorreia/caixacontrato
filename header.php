<?php
require_once('funcoes.php');
protegeArquivo(basename(__FILE__));
verificaLogin();
$sessao = new sessao();

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
        <link href="css/bootstrap.css" rel="stylesheet"/>
        <link href="css/style.css" rel="stylesheet"/>
        <link href="css/jquery.dataTables.css" rel="stylesheet" >  
        <link href="css/screen.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link href="css/jquery-ui.min.css" rel="stylesheet">
        <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">


        <script src="js/jquery.min.js"></script>        
        <script src="js/bootstrap.min.js"></script> 
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/jquery.validate.js"></script>



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
                <a class="navbar-brand" href="painel.php?LoadCaixa=listar"><p >CAIXA ECONOMICA FEDERAL</p></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
               <!-- <li><a href="?m=pesquisas&t=ver"><i class="fa fa-search fa-2x"></i> Pesquisar</a></li>-->
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-gear fa-2x"></i> Configurações <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="?m=usuarios&t=listar"><i class="fa fa-user-circle-o"></i> Usuários</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="?logoff=true"><i class="fa fa-power-off "></i> Sair</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
    <!--
        <body class="painel">
    
            <div class="container"><!--Container
                <div class="row header"><!--primeira linha--  
                    <div class="form-group">               
    
                        <div class="col-sm-6 centered">                      
                            <a href="painel.php">
                                <img class="text-center img-responsive" style="margin-top: 10px; margin-bottom: 10px;" alt="CAIXAECONÔMICA FEDERAL" src="img/logocaixaeconomica.png">
                            </a>                    
                        </div>
                        <br>
                        <br>         
                        <div class="col-sm-5 centered"> 
                            <nav class="navbar navbar-default navbar-right">
                                <div class="container-fluid">                              
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href="#">Pesquisar</a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Caixa Contrato <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="?m=caixa&t=incluir">Cadastrar nova CAIXA</a></li>
                                                <li><a href="#">Cadastrar Tipo de Contrato</a></li>
                                                <li><a href="#">Cadastrar Produtos</a></li>
                                                <li><a href="?m=caixa&t=listar">Exibir CAIXAS</a></li>
                                                <li role="separator" class="divider"></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configurações <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="?m=usuarios&t=listar">Usuários</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a href="?logoff=true"><span class="glyphicon glyphicon-off pull-right"></span>Sair</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div><!-- /.navbar-collapse --
                                <!-- /.container-fluid --
                            </nav>
                        </div>
                    </div>                
                </div><br>
                header Fim Primeira Linha-->
    <?php //echo ' teste de aspas "aspas" "  \'aspas simples\'  " ';  ?>



    