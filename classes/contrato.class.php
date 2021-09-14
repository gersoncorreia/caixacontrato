<?php
require_once(dirname(__FILE__) . '/autoload.php');
protegeArquivo(basename(__FILE__));

class contrato extends base {
   public function __construct($campos = array()) {
        parent::__construct(); //Na classe pai o construtor faz a conexao com o banco de dados
        $this->tabela = "tb_contrato"; //esse campo é apenas para setar qual Tabela irá ser trabalhada no banco de dados
        if (sizeof($campos) <= 0) {
            $this->campos_valores = array(
                "id_caixa" => NULL, 
                "codigo_caixa" => NULL, 
                "codigo_produto" => NULL,                
                "nome" => NULL, 
                "numero_contrato" => NULL, 
                "vencimento" => NULL, 
                "data_inclusao" => NULL, 
                "CPF" => NULL, 
                "CNPJ" => NULL,
                "situacao" => NULL
            );
        } else {
            $this->campos_valores = $campos;
        }
        $this->campopk = "id_contrato"; //Atribua aqui o nome do campo da tabela que é um campo Primary Key
    }
//construct
    
    public function camposPersonalizadosContrato($campos = array()) {
        parent::__construct(); //Na classe pai o construtor faz a conexao com o banco de dados
        $this->tabela = "tb_contrato c"; //esse campo é apenas para setar qual Tabela irá ser trabalhada no banco de dados
        if (sizeof($campos) <= 0) {
            $this->campos_valores = array(                
                "cc.id_caixa" => NULL, 
                "cc.codigo_caixa" => NULL, 
                "cc.id_tipo_contrato" => NULL, 
                "c.id_contrato" => NULL, 
                "tp.codigo_produto" => NULL, 
                "tp.descricao" => NULL, 
                "tc.tipo_contrato" => NULL,
                "c.nome" => NULL,
                "c.numero_contrato" => NULL,
                "c.vencimento" => NULL,
                "CONVERT(nvarchar(16),c.data_inclusao, 103) 'data_inclu'" => NULL,               
                "c.CPF" => NULL,
                "c.CNPJ" => NULL
                
            );
        } else {
            $this->campos_valores = $campos;
        }
        $this->campopk = "id_contrato"; //Atribua aqui o nome do campo da tabela que é um campo Primary Key
    }
    
}
