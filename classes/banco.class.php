<?php

require_once(dirname(__FILE__) . '/autoload.php');
protegeArquivo(basename(__FILE__));

define('DB_DRIVER', "sqlsrv");

abstract class banco {

    //propriedades
    public $servidor = 'GERSON-EG\SQLEXPRESS';
    public $usuario = 'admin';
    public $senha = 'admin123';
    public $nomebanco = 'db_caixa_contrato';
    public $conexao = NULL;
    public $connectionInfo = NULL;
    public $dataset = NULL;
    public $linhasafetadas = -1;
    public $resultado = -1;

//metodos
    public function __construct() {
        $this->conecta();
    }

//construct

    public function __destruct() {
        if ($this->conexao != NULL) {
            sqlsrv_close($this->conexao);
        }
    }

//destruct

    public function conecta() {
        $this->connectionInfo = array("Database" => 'db_caixa_contrato', "UID" => 'admin', "PWD" => 'admin123', "ReturnDatesAsStrings" => true);
        $this->conexao = sqlsrv_connect('GERSON-EG\SQLEXPRESS', $this->connectionInfo)
                or die($this->trataerro(__FILE__, __FUNCTION__, sqlsrv_errors(), TRUE));
        sqlsrv_query($this->conexao, "SET NAMES 'utf8'");
        sqlsrv_query($this->conexao, "SET character_set_connection=utf8");
        sqlsrv_query($this->conexao, "SET character_set_client=utf8");
        sqlsrv_query($this->conexao, "SET character_set_results=utf8");
        return $this->conexao;

        if ($this->conexao <> null):
            echo 'Conexao efetuada com sucesso';
        else:
            echo 'Conexao não efetuada';
        endif;
    }

//conecta

    public function inserir($objeto) {
        //insert into nomedatabela (campo1, campo2) values (valor1, valor2)
        $sql = "INSERT INTO " . $objeto->tabela . " (";
        for ($i = 0; $i < count($objeto->campos_valores); $i++) {
            $sql .= key($objeto->campos_valores);
            if ($i < count($objeto->campos_valores) - 1) {
                $sql .= ", ";
            } else {
                $sql .= ") ";
            }
            next($objeto->campos_valores);
        }
        reset($objeto->campos_valores);
        $sql .= "VALUES (";
        for ($i = 0; $i < count($objeto->campos_valores); $i++) {
            $sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ?
                    $objeto->campos_valores[key($objeto->campos_valores)] :
                    "'" . $objeto->campos_valores[key($objeto->campos_valores)] . "'";
            if ($i < count($objeto->campos_valores) - 1) {
                $sql .= ", ";
            } else {
                $sql .= ") ";
            }
            next($objeto->campos_valores);
        }
        //echo $sql;
        return $this->executaSQL($sql);
    }

//inserir

    public function atualizar($objeto) {
        //UPDATE NOMETABELA SET CAMPO1=VALOR1, CAMPO2=VALOR2 WHERE CAMPOCHAVE=VALORCHAVE
        $sql = "UPDATE " . $objeto->tabela . " SET ";
        for ($i = 0; $i < count($objeto->campos_valores); $i++) {
            $sql .= key($objeto->campos_valores) . "=";
            $sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ?
                    $objeto->campos_valores[key($objeto->campos_valores)] :
                    "'" . $objeto->campos_valores[key($objeto->campos_valores)] . "'";
            if ($i < count($objeto->campos_valores) - 1) {
                $sql .= ", ";
            } else {
                $sql .= " ";
            }
            next($objeto->campos_valores);
        }
        $sql .= " WHERE " . $objeto->campopk . " = ";
        $sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'" . $objeto->valorpk . "'";
        //echo $sql;
        return $this->executaSQL($sql);
    }

//atualizar

    public function deletar($objeto) {
        $sql = "DELETE FROM " . $objeto->tabela;
        $sql .= " WHERE " . $objeto->campopk . "=";
        $sql .= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'" . $objeto->valorpk . "'";
        return $this->executaSQL($sql);
    }

//deletar

    public function selecionaTudo($objeto) {
        $sql = "SELECT * FROM " . $objeto->tabela;
        if ($objeto->extras_select != NULL):
            $sql .= " " . $objeto->extras_select;
        endif;
        return $this->executaSQL($sql);
    }

//selecionaTudo

    public function selecionaCampos($objeto) {

        $sql = "SELECT ";
        for ($i = 0; $i < count($objeto->campos_valores); $i++) {
            $sql .= key($objeto->campos_valores);
            if ($i < count($objeto->campos_valores) - 1) {
                $sql .= ", ";
            } else {
                $sql .= " ";
            }
            next($objeto->campos_valores);
        }
        $sql .= " FROM " . $objeto->tabela;
        if ($objeto->extras_select != NULL):
            $sql .= " " . $objeto->extras_select;
        endif;
        return $this->executaSQL($sql);
    }

//selecionaCampos

    public function executaSQL($sql = NULL) {
        if ($sql != NULL) {
            //$query = sqlsrv_query($this->conexao, $sql, array(), array("Scrollable" => "static")) or $this->trataerro(__FILE__, __FUNCTION__);
            //$query = sqlsrv_query($this->conexao, $sql, array()) or $this->trataerro(__FILE__, __FUNCTION__);
            //$this->linhasafetadas = sqlsrv_rows_affected($query);            
            strtolower(trim($sql));

            if (substr($sql, 0, 6) == 'SELECT'):
                //SE O COMANDO FOR UM SELECT, OU SEJA, UMA CONSULTA, SERA PASSADO O PARAMETRO SCROLLABLE DO TIPO STATIC E SERA EXECUTADO O SQL
                $query = sqlsrv_query($this->conexao, $sql, array(), array("Scrollable" => "static")) or $this->trataerro(__FILE__, __FUNCTION__);
                $this->dataset = $query;
                $this->linhasafetadas = sqlsrv_num_rows($query); //num_rows referente a um resultado por SELECT
                return $this->resultado;
            else:
                //SE O COMANDO NAO FOR UM SELECT, SERA PASSADO O PARAMETRO SCROLLABRE DO TIPO FORWARD
                $query = sqlsrv_query($this->conexao, $sql, array(), array("Scrollable" => "forward")) or $this->trataerro(__FILE__, __FUNCTION__);
                $this->linhasafetadas = sqlsrv_rows_affected($query); //rows_affected referente a INSERT, UPDATE, DELETE
                
                return $this->linhasafetadas;
            endif;
        }
        else {
            $this->trataerro(__FILE__, __FUNCTION__, NULL, 'Comando SQL nao informado na rotina', FALSE);
        }
    }

//executaSQL

    public function retornaDados($tipo = NULL) {

        switch ($tipo):
            case "array":
                return sqlsrv_fetch_array($this->dataset);
                sqlsrv_free_result($this->dataset);
                break;
            case "assoc":
                return sqlsrv_fetch_assoc($this->dataset);
                sqlsrv_free_result($this->dataset);
                break;
            case "object":
                return sqlsrv_fetch_object($this->dataset);
                sqlsrv_free_result($this->dataset);
                break;
            default:
                return sqlsrv_fetch_object($this->dataset);
                sqlsrv_free_result($this->dataset);
                break;
        endswitch;
    }

//RetornaDados

    public function trataerro($arquivo = NULL, $rotina = NULL, $msgerro = ARRAY(), $geraexcept = FALSE) {
        if ($arquivo == NULL)
            $arquivo = "nao informado";
        if ($rotina == NULL)
            $rotina = "nao informada";
        if ($msgerro == NULL)
            $msgerro = sqlsrv_errors();
        $resultado = 'Ocorreu um erro com os seguintes detalhes: <br />
		<strong>Arquivo:</strong>' . $arquivo . ' <br/>
		<strong>Rotina:</strong>' . $rotina . ' <br/>
		<strong>Mensagem:</strong>' . $msgerro;
        if ($geraexcept == FALSE) {
            echo($resultado);
            print_r($msgerro);
        } else {
            die($resultado);
        }
    }

//trataerro
}

?>