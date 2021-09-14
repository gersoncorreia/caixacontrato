<?php
require_once(dirname(__FILE__) . '/autoload.php');
protegeArquivo(basename(__FILE__));
class caixa extends base {
     public function __construct($campos = array()) {
        parent::__construct(); //Na classe pai o construtor faz a conexao com o banco de dados
        $this->tabela = "tb_caixa"; //esse campo é apenas para setar qual Tabela irá ser trabalhada no banco de dados
        if (sizeof($campos) <= 0) {
            $this->campos_valores = array(                
                "id_tipo_contrato" => NULL, 
                "data_cad" => NULL,                
                "status" => NULL, 
                "situacao" => NULL,
                
            );
        } else {
            $this->campos_valores = $campos;
        }
        $this->campopk = "id_caixa"; //Atribua aqui o nome do campo da tabela que é um campo Primary Key
    }
    
    public function camposPersonalizadosCaixa($campos = array()) {
        parent::__construct(); //Na classe pai o construtor faz a conexao com o banco de dados
        $this->tabela = "tb_caixa cc"; //esse campo é apenas para setar qual Tabela irá ser trabalhada no banco de dados
        if (sizeof($campos) <= 0) {
            $this->campos_valores = array(                
                "cc.id_caixa" => NULL, 
                "cc.id_tipo_contrato" => NULL, 
                "tc.tipo_contrato" => NULL,                
                "cc.codigo_caixa" => NULL, 
                "CONVERT(nvarchar, cc.data_cad, 13) 'data_cad'" => NULL,
                "CONVERT(nvarchar,cc.data_fechamento, 13) 'data_fecha'" => NULL,
                "cc.status" => NULL,
                "cc.situacao" => NULL
                
            );
        } else {
            $this->campos_valores = $campos;
        }
        $this->campopk = "id_caixa"; //Atribua aqui o nome do campo da tabela que é um campo Primary Key
    }
//construct
}
