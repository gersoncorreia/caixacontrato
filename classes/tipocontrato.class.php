<?php

require_once(dirname(__FILE__) . '/autoload.php');
protegeArquivo(basename(__FILE__));
class tipocontrato extends base{
    public function __construct($campos = array()) {
        parent::__construct(); //Na classe pai o construtor faz a conexao com o banco de dados
        $this->tabela = "tb_tipo_contrato"; //esse campo é apenas para setar qual Tabela irá ser trabalhada no banco de dados
        if (sizeof($campos) <= 0) {
            $this->campos_valores = array(
                "tipo_contrato" => NULL  
            );
        } else {
            $this->campos_valores = $campos;
        }
        $this->campopk = "id_tipo_contrato"; //Atribua aqui o nome do campo da tabela que é um campo Primary Key
    }
//construct
}
