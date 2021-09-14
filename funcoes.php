<?php
inicializa();
protegeArquivo(basename(__FILE__));
function inicializa(){
    if(file_exists(dirname(__FILE__).'/config.php')):
        require_once(dirname(__FILE__).'/config.php');
    else:
        die(utf8_decode('O arquivo de configuração não foi localizada, contate o Administrador. '));
    endif;
    
    foreach ($constates as $valor):    
        if(!defined($valor)):
            die(utf8_decode('Uma configuração do sistema esta ausente: '.$valor));        
        endif;
    endforeach;
    require_once(BASEPATH.CLASSEPATH.'autoload.php');
    if (@$_GET['logoff']==TRUE):
       //faz logoff
        $user = new usuarios();
        $user->doLogout();
        exit;
    endif;
}

//carregamento do css automatico, caso seja um link externo informar import TRUE
function loadCSS($arquivo=null, $media='screen', $import=false){
    if($arquivo != null):
        if($import==TRUE):
            echo '<style type="text/css">@import url("'.BASEURL.CSSPATH.$arquivo.'.css");</style>'."\n";
        else:
            echo '<style type="text/css" rel="stylesheet" href="'.BASEURL.CSSPATH.$arquivo.'.css" media="'.$media.'" / >'."\n";    
        endif;        
    endif;
}

function loadJS($arquivo=null,$remoto=false){
    if($arquivo != null):
        if($remoto==false):
            $arquivo = BASEURL.JSPATH.$arquivo.'.js';
            echo '<script type="text/javascritp" src-"'.$arquivo.'"></script>';
        endif;
    endif;
}

function loadmodulo($modulo=null,$tela=null){
    if($modulo==null || $tela==null):
        echo '<p> Erro na função <strong>'.__FUNCTION__.'</strong>: faltam parametros para execução. </p>';
        
    else:
        if(file_exists(MODULOSPATH."$modulo.php")):
            include_once(MODULOSPATH."$modulo.php");
        else:
            echo("<p> Módulo inexistente neste sistema! </p>");
        endif;
    endif;
}

/*ProtegeArquivo() é uma função criada para que ninguem acesse o arquivo diretamente
 * digitando pela URL por exemplo um arquivo especifico como: http://localhost:8080/www/modamania/modulos/usuarios.php
 * ao tentar abrir um arquivo diretamente o usuario será redirecionado para index.php com erro=3 
*/
function protegeArquivo($nomeArquivo, $redirPara='index.php?erro=3'){
    //PHP_SELF pega o caminho do arquivo nesse caso abaixo é /www/modamania/funcoes.php
    $url = $_SERVER['PHP_SELF'];
    
    /*preg_match possui 3 parametros sendo 2 obrigatorios, o primeiro é o ponto de partida
    o segudo parametro é onde será encontrado o /i significa que nao vai diferenciar maiusculo de minusculo*/
    
    if (preg_match("/$nomeArquivo/i", $url)):
        //redirecionar para outra url
        redireciona($redirPara);
    endif;
}

//funcao de redirecionamento
function redireciona($url=''){
    header("location: ".BASEURL.$url);
}

function codificaSenha($senha){
    return md5($senha);
}

function verificaLogin(){
    $sessao = new sessao();
    if($sessao->getNvars()<=0 || $sessao->getVar('logado')!=TRUE):
        redireciona('?erro=3');
    else:
        return TRUE;
    endif;
}

function printMSG($msg=null, $tipo=null){
    if($msg!=null):
        switch ($tipo):
        case 'erro':
            echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
            break;
        case 'alerta':
            echo '<div class="alert alert-warning" role="alert">'.$msg.'</div>';
            break;
        case 'pergunta':
            echo '<div class="alert alert-info" role="alert">'.$msg.'</div>';
            break;
        default:
            echo '<div class="alert alert-success" role="alert">'.$msg.'</div>';
            break;                 
        endswitch;
    endif;    
}

function isAdmin(){
    verificaLogin();
    $sessao = new sessao();
    $user = new usuarios(array(
        'UsuariosAdm'=>null,
    ));
    @$iduser = $sessao->getVar('iduser');
    $user->extras_select = 'WHERE UsuariosId = '.$iduser;
    $user->selecionaCampos($user);
    $res = $user->retornaDados();
    if (strtolower($res->UsuariosAdm)=='s'):
        return TRUE;
    else:
        return FALSE;
    endif;    
}

?>
