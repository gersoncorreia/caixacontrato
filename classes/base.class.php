<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));

abstract class base extends banco{
//Essa Classe servi como base de configuração de todas as tabelas do banco de dados
    
	//propriedades
	public $tabela = "";
	public $campos_valores = array();//Colunas
	public $campopk = NULL;//Chave Primaria
	public $valorpk = NULL;//Nome da coluna por isso campo_valores é um array
	public $extras_select = "";
	
	public function addCampo($campo=NULL, $valor=NULL){
		if($campo != NULL){
			$this->campos_valores[$campo] = $valor;
		}
	}//addCampo
	
	public function delCampo($campo){
		if(array_key_exists($campo, $this->campos_valores)){
			unset($this->campos_valores[$campo]);
		}
	}//delCampo
	
	public function setValor($campo=NULL, $valor=NULL){
		if($campo != NULL && $valor != NULL){
			$this->campos_valores[$campo] = $valor;
		}
	}//setValor
	
	public function getValor($campo=NULL){
		if($campo != NULL && array_key_exists($campo, $this->campos_valores)){
			return $this->campos_valores[$campo];
		} else {
			return FALSE;
		}
	}//getValor
	
	
}//fim classe base 
?>