<!--Este arquivo é o modulo de usuario, ou seja, toda o INSERT, UPDATE, DELETE, READ esta neste arquivo, assim também como sua funcionalidade de LOGAR ou TELA DE LOGIN-->
<?php

    
require_once(dirname(dirname(__FILE__))."/funcoes.php");
protegeArquivo(basename(__FILE__));


if(isset($_POST['usuario'])):
    $usuario = $_POST['usuario'];   
  
endif;

if(isset($_POST['senha'])):
    $senha = $_POST['senha'];
   
endif;

switch ($tela) {
    case 'login':
        $sessao = new sessao();
       if($sessao->getNvars()>0 || $sessao->getVar('logado')==TRUE ) redireciona('painel.php');
        
        if (isset($_POST['entrar'])):
            $user = new usuarios();
            $user->setValor('UsuariosLogin', $_POST['usuario']);
            $user->setValor('UsuariosSenha', $_POST['senha']);
            if($user->doLogin($user)==TRUE):
                redireciona("painel.php?LoadCaixa=listar");
            else:
                echo '<h1>Usuario = '.$usuario.'</h1>';
                echo 'Senha ='.$senha;
                redireciona('?m=usuarios&t=login&erro=2');
            endif;
        endif;
        
        ?>
<script>
    $( document ).ready(function() {
    $("#usuario").focus();
    });
</script>
    


            <div  style="background:linear-gradient(#ffffff, #F3F3F3); border:2px solid #CCCCCC; height:520px; margin-top:10px;">
                <div class="row"><!--primeira linha-->
                    <div class="col-md-offset-2 col-md-8" style="margin-top:50px;">
                        <a class="col-md-offset-4" href="painel.php">
                            <img class="text-center" alt="CAIXA ECÔNOMICA" src="img/logocaixaeconomica.png">
                        </a> 
                    </div>
                    
                    <div class="col-sm-offset-2 col-sm-8" style="margin-top:50px;">
                        <legend><p class="col-sm-offset-4">Acesso Restrito, Identifique-se</p></legend>
                    </div>
                </div><!--Fim primeira linha-->    
                
                
                <?php
                    if (isset($_GET['erro'])):
                        $erro = $_GET['erro'];
                    endif;
                    switch (@$erro) {
                        case 1:
                            //echo '<div class="container">';
                            echo '<div class="col-sm-offset-2 col-sm-8 centered">';
                            echo '<div class="alert alert-success">Você fez logoff do sistema</div>';
                            echo '</div>';
                            //echo '</div>';
                            break;
                        case 2:
                            //echo '<div class="container">';
                            echo '<div class="col-sm-offset-2 col-sm-8 centered">';
                            echo '<div class="alert alert-info">Dados incorretos ou Usuário inativo</div>';
                            echo '</div>';
                            //echo '</div>';
                            break;
                        case 3:
                            //echo '<div class="container">';
                            echo '<div class="col-sm-offset-2 col-sm-8 centered">';
                            echo '<div class="alert alert-danger">Faça login antes de acessar a página solicitada.</div>';
                            echo '</div>';
                            //echo '</div>';                
                            break;
                        default:
                            break;
                    }                
                ?>
                
                <div class="row"><!--Segunda linha-->
                    <div  class= "col-md-12 centered" >
                        <fieldset>
                            
                            <form class="form-horizontal" id="formlogin" method="POST" name="formlogin" style="margin-top:50px;">
                                <div class="form-group">
                                    <label for="usuario" class="col-sm-4 control-label">Usuário</label>
                                    <div class="col-sm-4">
                                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Digite seu usuario" value="<?php if (isset($_POST['usuario'])): echo $_POST['usuario']; endif ; ?>" required="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-4 control-label">Senha</label>
                                    <div class="col-sm-4">
                                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" value="<?php if (isset($_POST['senha'])): echo $_POST['senha']; endif ; ?>" required="true">
                                    </div>
                                </div>
                    
                                
                                <div class="form-group">
                                    <div class="col-sm-offset-5 col-sm-8">
                                        <button type="submit" class="btn btn-default" name="entrar" id="entrar" style="width:150px;">Entrar</button>
                                    </div>
                                </div>
                            </form>
                            
                            <script>
                                $(document).ready(function() {
                                    $("#formlogin").validate({
                                        messages:{
                                            usuario: "<p style='color: RED;'>Por favor digite seu usuario</p>" ,
                                            senha: "<p style='color: RED;'>Por favor digite sua senha</p>"
                                        }                           
                                    });
                                });
                            </script>                            
                            
                            
                        </fieldset>
                    </div>                    
                </div><!--Fim Segunda linha-->
            </div>
        <?php

        
        break;
    case 'incluir':
        echo '<h2>Cadastro de Usuarios</h2><hr>';
        if(isset($_POST['cadastrar'])):
            $user = new usuarios(array(
                'usuariosnome'=>trim($_POST['nome']),
                'usuariosemail'=>trim($_POST['email']),
                'usuarioslogin'=>trim($_POST['login']),
                'usuariossenha'=>  codificaSenha($_POST['senha']),
                'usuariosadm'=>(@$_POST['adm']=='on')?'s' : 'n',
            ));
        
        if ($user->existeRegistro('usuarioslogin', $_POST['login'])):
            printMSG('Este login ja está cadastrado, escolha outro nome de usuário.','erro');
            $duplicado = TRUE;
        endif;
        if ($user->existeRegistro('usuariosemail', $_POST['email'])):
            printMSG('Este email ja está cadastrado, escolha outro endereço.','erro');
            $duplicado = TRUE;
        endif;        
        
        if (@$duplicado!=TRUE):       
            $user->inserir($user);
                if($user->linhasafetadas==1):
                    printMSG( 'Dados inseridos com sucesso. <a href="'.ADMURL.'?m=usuarios&t=listar">Exibir cadastros</a>');
                    unset($_POST);
                endif;
            endif;
        endif;
        
        ?>    

                            
        <form class="form-horizontal" role="form" method="POST" name="cadusuarios" id="cadusuarios">
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Nome</label>
                <div class="col-sm-7">
                    <input type="text" size="50" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" value="<?php echo @$_POST['nome'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Email</label>
                <div class="col-sm-7"> 
                    <input type="email" size="50" class="form-control" id="email" name="email" placeholder="Digite seu email" value="<?php echo @$_POST['email'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Login</label>
                <div class="col-sm-4"> 
                    <input type="text" size="35" class="form-control" id="login" name="login" placeholder="Digite um login" value="<?php echo @$_POST['login'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Senha</label>
                <div class="col-sm-3"> 
                    <input type="password" size="25" class="form-control" id="senha" name="senha" placeholder="Crie sua senha" value="<?php echo @$_POST['senha'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Repetir Senha</label>
                <div class="col-sm-3"> 
                    <input type="password" size="25" class="form-control" id="senhaconf" name="senhaconf" placeholder="Repita a senha" value="<?php echo @$_POST['senhaconf'] ?>" required>
                </div>
            </div>
            <div class="form-group"> 
                <label class="control-label col-sm-2" for="adm">Administrador</label>
                <div class="col-sm-10">
                    
                <div class="checkbox">
                    <label><input type="checkbox" name="adm" <?php if(!isAdmin()) echo 'disabled="disabled"'; if(@$_POST['adm']) echo 'checked="checked"'; ?> > dar controle total ao usuario</label>
                </div>
                </div>
            </div>
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="location.href='?m=usuarios&t=listar'">Cancelar</button>
                    <button type="submit" class="btn btn-default" name="cadastrar" id="cadastrar">Cadastrar</button>
                </div>
            </div>
        </form>

        <script> <!--Validacao do form de cadastro de usuarios-->
            $(document).ready(function() {
                $("#cadusuarios").validate({
                    rules:{
                        nome: { minlength: 3},
                       
                        login: { minlength: 5},
                        senha: {  rangelength:[6,8]},
                        senhaconf: {  equalTo: "#senha"}
                    },
                    messages:{
                        nome: { required: "<p style='color: blue;'>Por favor digite seu nome</p>", minlength: "<p>O minimo de caracteres é 3</p>"} ,
                        email: {required: "<p style='color: blue;'>Por favor digite seu email</p>", email:"<p'>Por favor digite um email válido</p>"},
                        login: { required:"<p style='color: blue;'>Por favor digite seu login</p>", minlength: "<p>O mínimo de caracteres é 5</p>"},
                        senha: {required: "<p style='color: blue;'>Por favor digite sua senha</p>", rangelength: "<p>O minimo de caracteres é 6</p>"},
                        senhaconf: { required: "<p style='color: blue;'>Repita a senha por favor</p>" ,equalTo: "<p>Senha não confere</p>"}
                    }

                });
            });
        </script>

        <?php
        break;
    case 'listar':
        echo '<h2>Usuario cadastrados <i class="fa fa-user-circle-o"></i></h2>';
        ?>
        
        <script><!--Configuração do dataTable em portugues e outros-->
            $(document).ready(function(){
                               
               $("#listausers").dataTable({
                  'sScrollY': "300px",
                  'bPaginate': true,
                  'aaSorting': [[0, 'asc']],
                  'searching': true,
                  "columnDefs": [
                    { "width": "30%", "targets": 0 }
                  ],
                  
                  
                "language":  {
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
        
        <table cellspacing="0" cellpading="0" border="0" class="table table-striped table-bordered" id="listausers">
            <thead>                
                <th>Nome</th>
                <th>Email</th>
                <th>Login</th>
                <th>Ativo/Adm</th>
                <th>Cadastro</th>
                <th>Ações</th>
            </thead>
            <tbody>
                <?php
                $user = new usuarios();
                $user->selecionaTudo($user);
            
                while ($res = $user->retornaDados()):     
                    echo '<tr>';                    
                    printf('<td>%s</td>',$res->UsuariosNome);
                    printf('<td>%s</td>',$res->UsuariosEmail);
                    printf('<td>%s</td>',$res->UsuariosLogin);
                    printf('<td class="center">%s/%s</td>',strtoupper($res->UsuariosAtivo),strtoupper($res->UsuariosAdm));
                    printf('<td class="center">%s</td>',date("d/m/Y",strtotime($res->UsuariosDtaCad)));
                    printf('<td class="center">
                        <a href="?m=usuarios&t=incluir" title="Novo cadastro"><img src="img/add.png" alt="Novo cadastro" /></a>
                        <a href="?m=usuarios&t=editar&id=%s" title="Editar"><img src="img/edit.png" alt="Editar"/></a>
                        <a href="?m=usuarios&t=senha&id=%s" title="Mudar senha"><img src="img/pass.png" alt="Mudar senha"/></a>
                        <a href="?m=usuarios&t=excluir&id=%s" title="Excluir"><img src="img/delete.png" alt="Excluir"/></a>
                        </td>',$res->UsuariosId, $res->UsuariosId, $res->UsuariosId  );
                    echo '</tr>';
                endwhile;
                ?>
            </tbody>
        </table>
        
        
        
        <?php
        break;
    case 'editar':
        echo '<h2>Edição de usuários</h2>';
        $sessao = new sessao();
        if (isAdmin()==TRUE || $sessao->getVar('iduser')==$_GET['id']):
            if(isset($_GET['id'])):
                
                $id2 = $_GET['id'];
                //faz a edicao do user
                if(isset($_POST['editar'])):
                    $user = new usuarios(array(
                        'UsuariosNome' => trim($_POST['nome']),
                        'UsuariosEmail' => trim($_POST['email']),
                        'UsuariosAtivo' => (@$_POST['ativo']=='on') ?'s' : 'n',
                        'UsuariosAdm' => (@$_POST['adm']=='on') ? 's': 'n',
                    ));
                    $user->valorpk = $id2;
                    $user->extras_select = "WHERE UsuariosId = ".$id2;
                    $user->selecionaTudo($user);
                    $resuser = $user->retornaDados();
                    if($resuser->UsuariosEmail != $_POST['email']):
                        if ($user->existeRegistro('UsuariosEmail', $_POST['email'])):
                            printMSG('Este email já existe no sistema, escolha outro endereço!','erro');
                            @$duplicado = TRUE;
 
                        endif;
                    endif;
                    if(@$duplicado!=TRUE):
                        $user->atualizar($user);
                        if($user->linhasafetadas==1):
                            printMSG('Dados alterados com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>');
                            unset($_POST);
                        else:
                            printMSG('Nenhum dado foi alterado. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','alerta');
      
                        
                        endif;
                    endif;
                    
                endif;
           
                $id = $_GET['id'];
                $userbd = new usuarios();
                $userbd->extras_select = "WHERE UsuariosId = ".$id;
                $userbd->selecionaTudo($userbd);
                $resbd = $userbd->retornaDados();
                
            else:
                //avisa para selecionar um user;
                printMSG('Usuário não definido, <a href="#" onclick="history.back()">Voltar</a>','erro');
            
            endif;
            ?>

                <form class="form-horizontal" role="form" method="POST" name="editusuarios" id="editusuarios">
            <div class="form-group">
                <label class="control-label col-sm-2" for="nome">Nome</label>
                <div class="col-sm-7">
                    <input type="text" size="50" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" value="<?php if($resbd) echo $resbd->UsuariosNome; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="eamil">Email</label>
                <div class="col-sm-7"> 
                    <input type="email" size="50" class="form-control" id="email" name="email" placeholder="Digite seu email" value="<?php if($resbd) echo $resbd->UsuariosEmail; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="login">Login</label>
                <div class="col-sm-4"> 
                    <input type="text" disabled="disabled" size="35" class="form-control" id="login" name="login" placeholder="Digite um login" value="<?php if($resbd) echo $resbd->UsuariosLogin; ?>" required>
                </div>
            </div>

            <div class="form-group"> 
                <label class="control-label col-sm-2" for="ativo">Ativo</label>
                <div class="col-sm-10">
                    
                <div class="checkbox">
                    <label><input type="checkbox" name="ativo" id="ativo" <?php if(!isAdmin()) echo 'disabled="disabled"'; if($resbd->UsuariosAtivo == 's') echo 'checked="checked"'; ?> > habilitar ou desabilitar o usuário</label>
                </div>
                </div>
            </div>                    

            <div class="form-group"> 
                <label class="control-label col-sm-2" for="adm">Administrador</label>
                <div class="col-sm-10">
                    
                <div class="checkbox">
                    <label><input type="checkbox" name="adm" id="adm" <?php if(!isAdmin()) echo 'disabled="disabled"'; if($resbd->UsuariosAdm == 's') echo 'checked="checked"'; ?> > dar controle total ao usuario</label>
                </div>
                </div>
            </div>
                    
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="location.href='?m=usuarios&t=listar'">Cancelar</button>
                    <button type="submit" class="btn btn-default" name="editar" id="editar">Salvar</button>
                </div>
            </div>
        </form>

        <script> <!--Validacao do form de cadastro de usuarios-->
            $(document).ready(function() {
                $("#editusuarios").validate({
                    rules:{
                        nome: { minlength: 3}
                       
                    },
                    messages:{
                        nome: { required: "<p style='color: blue;'>Por favor digite seu nome</p>", minlength: "<p>O minimo de caracteres é 3</p>"} ,
                        email: {required: "<p style='color: blue;'>Por favor digite seu email</p>", email:"<p'>Por favor digite um email válido</p>"}

                    }

                });
            });
        </script>
        
        
            <?php
        else:
            //avisa que nao tem permissao para alterar
            printMSG('Você não tem permissão para acessar esta página. <a href="#" onclick="history.back()"></a>','erro');
                
        endif;
        
        break;
        
        
    case 'senha':
        echo '<h2>Mudar senha</h2>';
        $sessao = new sessao();
        if (isAdmin()==TRUE || $sessao->getVar('iduser')==$_GET['id']):
            if(isset($_GET['id'])):
                
                $id2 = $_GET['id'];
                //faz a edicao do user
                if(isset($_POST['mudasenha'])):
                    $user = new usuarios(array(
                        'UsuariosSenha' => codificaSenha($_POST['senha']),
                    ));
                    $user->valorpk = $id2;                    
  
                    $user->atualizar($user);
                    if($user->linhasafetadas==1):
                        printMSG('Senha alterada com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>');
                        unset($_POST);
                    else:
                        printMSG('Nenhum dado foi alterado. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','alerta');                             
                    endif; 
                    
                endif;
           
                $id = $_GET['id'];
                $userbd = new usuarios();
                $userbd->extras_select = "WHERE UsuariosId = ".$id;
                $userbd->selecionaTudo($userbd);
                $resbd = $userbd->retornaDados();
                
            else:
                //avisa para selecionar um user;
                printMSG('Usuário não definido, <a href="#" onclick="history.back()">Voltar</a>','erro');
            
            endif;
            ?>

                <form class="form-horizontal" role="form" method="POST" name="mudasenhausuario" id="mudasenhausuario">
            <div class="form-group">
                <label class="control-label col-sm-2" for="nome">Nome</label>
                <div class="col-sm-7">
                    <input type="text" disabled="disabled" size="50" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" value="<?php if($resbd) echo $resbd->UsuariosNome; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="eamil">Email</label>
                <div class="col-sm-7"> 
                    <input type="email" disabled="disabled" size="50" class="form-control" id="email" name="email" placeholder="Digite seu email" value="<?php if($resbd) echo $resbd->UsuariosEmail; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="login">Login</label>
                <div class="col-sm-4"> 
                    <input type="text" disabled="disabled" size="35" class="form-control" id="login" name="login" placeholder="Digite um login" value="<?php if($resbd) echo $resbd->UsuariosLogin; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Senha</label>
                <div class="col-sm-3"> 
                    <input type="password" size="25" class="form-control" id="senha" name="senha" placeholder="Crie sua senha" value="<?php echo @$_POST['senha'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Repetir Senha</label>
                <div class="col-sm-3"> 
                    <input type="password" size="25" class="form-control" id="senhaconf" name="senhaconf" placeholder="Repita a senha" value="<?php echo @$_POST['senhaconf'] ?>" required>
                </div>
            </div>
                    
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="location.href='?m=usuarios&t=listar'">Cancelar</button>
                    <button type="submit" class="btn btn-default" name="mudasenha" id="mudasenha">Salvar</button>
                </div>
            </div>
        </form>

        <script> <!--Validacao do form de cadastro de usuarios-->
            $(document).ready(function() {
                $("#mudasenhausuario").validate({
                    rules:{                                
                        senha: {  rangelength:[6,8]},
                        senhaconf: {  equalTo: "#senha"}
                    },
                    messages:{
                        senha: {required: "<p style='color: blue;'>Por favor digite sua senha</p>", rangelength: "<p>O minimo de caracteres é 6</p>"},
                        senhaconf: { required: "<p style='color: blue;'>Repita a senha por favor</p>" ,equalTo: "<p>Senha não confere</p>"}
                    }

                });
            });
        </script>
        
        
            <?php
        else:
            //avisa que nao tem permissao para alterar
            printMSG('Você não tem permissão para acessar esta página. <a href="#" onclick="history.back()"></a>','erro');
                
        endif;
        
        break;
        
        
    case 'excluir':
        echo '<h2>Exclusão de usuários</h2>';
        $sessao = new sessao();
        if (isAdmin()==TRUE ):
            if(isset($_GET['id'])):
                
                $id2 = $_GET['id'];
                //faz a edicao do user
                if(isset($_POST['excluir'])):
                    $user = new usuarios();
                    $user->valorpk = $id2;
               
                    $user->deletar($user);
                    if($user->linhasafetadas==1):
                        printMSG('Registro excluido com sucesso. <a href="?m=usuarios&t=listar">Exibir cadastros</a>');
                        unset($_POST);
                    else:
                        printMSG('Nenhum registro foi excluido. <a href="?m=usuarios&t=listar">Exibir cadastros</a>','alerta');                              
                    endif;                    
                endif;
           
                $id = $_GET['id'];
                $userbd = new usuarios();
                $userbd->extras_select = "WHERE UsuariosId = ".$id;
                $userbd->selecionaTudo($userbd);
                $resbd = $userbd->retornaDados();
                
            else:
                //avisa para selecionar um user;
                printMSG('Usuário não definido, <a href="#" onclick="history.back()">escolha um usuário para excluir</a>','erro');
            
            endif;
            ?>

                <form class="form-horizontal" role="form" method="POST" name="excluirusuarios" id="excluirusuarios">
            <div class="form-group">
                <label class="control-label col-sm-2" for="nome">Nome:</label>
                <div class="col-sm-7">
                    <input type="text" disabled="disabled"  size="50" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" value="<?php if($resbd) echo $resbd->UsuariosNome; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="eamil">Email</label>
                <div class="col-sm-7"> 
                    <input type="email" disabled="disabled"  size="50" class="form-control" id="email" name="email" placeholder="Digite seu email" value="<?php if($resbd) echo $resbd->UsuariosEmail; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="login">Login</label>
                <div class="col-sm-4"> 
                    <input type="text" disabled="disabled" size="35" class="form-control" id="login" name="login" placeholder="Digite um login" value="<?php if($resbd) echo $resbd->UsuariosLogin; ?>" required>
                </div>
            </div>

            <div class="form-group"> 
                <label class="control-label col-sm-2" for="ativo">Ativo</label>
                <div class="col-sm-10">
                    
                <div class="checkbox">
                    <label><input type="checkbox" disabled="disabled"  name="ativo" id="ativo" > habilitar ou desabilitar o usuário</label>
                </div>
                </div>
            </div>                    

            <div class="form-group"> 
                <label class="control-label col-sm-2" for="adm">Administrador</label>
                <div class="col-sm-10">
                    
                <div class="checkbox">
                    <label><input type="checkbox" disabled="disabled"  name="adm" id="adm"  > dar controle total ao usuario</label>
                </div>
                </div>
            </div>
                    
            <div class="form-group"> 
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default" onclick="location.href='?m=usuarios&t=listar'">Cancelar</button>
                    <button type="submit" class="btn btn-default" name="excluir" id="excluir">Excluir</button>
                </div>
            </div>
        </form>


        
        
            <?php
        else:
            //avisa que nao tem permissao para alterar
            printMSG('Você não tem permissão para acessar esta página. <a href="#" onclick="history.back()"></a>','erro');
                
        endif;
        
        break;
        
        
        
    default:
        echo '<p>A tela solicitada não existe.</p>';
        break;
}

?>
