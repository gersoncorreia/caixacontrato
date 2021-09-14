<?php 
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

class usuarios extends base{
	public function __construct($campos=array()){
		parent::__construct();//Na classe pai o construtor faz a conexao com o banco de dados
		$this->tabela = "usuarios"; //esse campo é apenas para setar qual Tabela irá ser trabalhada no banco de dados
		if(sizeof($campos)<=0){
			$this->campos_valores = array(
                            "UsuariosNome"=>NULL,                            
                            "UsuariosEmail"=>NULL,
                            "UsuariosLogin"=>NULL,
                            "UsuariosSenha"=>NULL,
                            "UsuariosAtivo"=>NULL,
                            "UsuariosAdm"=>NULL,
                            "UsuariosDtaCad"=>NULL
                            );
		}
		else {
			$this->campos_valores = $campos;
		}
		$this->campopk = "UsuariosId"; //Atribua aqui o nome do campo da tabela que é um campo Primary Key
	}//construct

        public function doLogin($objeto){
            $objeto->extras_select = "WHERE UsuariosLogin = '".$objeto->getValor('UsuariosLogin')."' AND 
                UsuariosSenha = '".codificaSenha($objeto->getValor('UsuariosSenha'))."' AND UsuariosAtivo ='s'";
            $this->selecionaTudo($objeto);
            $sessao = new sessao();
            if ($this->linhasafetadas>0):
                $usLogado = $objeto->retornaDados();
                $sessao->setVar('iduser', $usLogado->UsuariosId);
                $sessao->setVar('nomeuser', $usLogado->UsuariosNome);
                $sessao->setVar('loginuser', $usLogado->UsuariosLogin);
                $sessao->setVar('logado', TRUE);
                $sessao->setVar('ip', $_SERVER['REMOTE_ADDR']);
                return TRUE;
            else:
                $sessao->destroy(TRUE);
                return FALSE;
            endif;
        }
        
        public function doLogout(){
            $sessao = new sessao();
            $sessao->destroy(TRUE);
            redireciona('?m=usuarios&t=login&erro=1');
        }
        
        public function existeRegistro($campo=null,$valor=null){
            if($campo!=null && $valor!=null):
                is_numeric($valor) ? $valor = $valor : $valor = "'".$valor."'";
                $this->extras_select = "WHERE $campo=$valor";
                $this->selecionaTudo($this);
                if($this->linhasafetadas > 0):
                    return TRUE;
                else:
                    return FALSE;
                endif;
            else:
                $this->trataerro(__FILE__,__FUNCTION__,NULL,'Faltam parâmetros para executar a função', TRUE);
            endif;       
        }

}//fim classe clientes
?>