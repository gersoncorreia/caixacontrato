<?php

require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));




abstract class banco {

    //propriedades
    public $servidor = DBHOST;
    public $usuario = DBUSER;
    public $senha = DBPASS;
    public $nomebanco = DBNAME;
    public $conexao = NULL;
    //public $connectionInfo = NULL;
    public $dataset = NULL;
    public $linhasafetadas = -1;
    //public $resultado = -1;
    
//metodos
    public function __construct() {
        $this->conecta();
    }

//construct

    public function __destruct() {
        if ($this->conexao != NULL) {
            mysqli_close($this->conexao);
        }
    }

//destruct

    public function conecta() {  
        $this->conexao = mysqli_connect($this->servidor, $this->usuario, $this->senha, $this->nomebanco)
               or die($this->trataerro(__FILE__, __FUNCTION__, mysqli_errno(), mysqli_error(), TRUE));
        //mysqli_select_db($this->nomebanco) or die($this->trataerro(__FILE__, __FUNCTION__, mysqli_error(), TRUE));
//        if ($this->conexao):
//            echo 'Conexao estabelecida com sucesso';
//        endif;
        mysqli_query($this->conexao,"SET NAMES 'utf8'");
        mysqli_query($this->conexao,"SET character_set_connection=utf8");
        mysqli_query($this->conexao,"SET character_set_client=utf8");
        mysqli_query($this->conexao,"SET character_set_results=utf8");
		return $this->conexao;                
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
        $sql = "SELECT * FROM " .$objeto->tabela;
        if ($objeto->extras_select != NULL):
            $sql .= " " .$objeto->extras_select;
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
            $query = mysqli_query($this->conexao, $sql) or $this->trataerro(__FILE__, __FUNCTION__);
            $this->linhasafetadas = mysqli_affected_rows($this->conexao);
            strtolower(trim($sql));
            if (substr($sql, 0, 6) == 'SELECT'):
                $this->dataset = $query;
                return $this->dataset;
            else:
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
                return mysqli_fetch_array($this->dataset);
				mysqli_free_result($this->dataset);
                break;
            case "assoc":
                return mysqli_fetch_assoc($this->dataset);
				mysqli_free_result($this->dataset);
                break;
            case "object":
                return mysqli_fetch_object($this->dataset);
				mysqli_free_result($this->dataset);
                break;
            default:
                return mysqli_fetch_object($this->dataset);
				mysqli_free_result($this->dataset);
                break;
        endswitch;
    }

//RetornaDados

    public function trataerro($arquivo = NULL, $rotina = NULL, $numerro = NULL, $msgerro = NULL, $geraexcept = FALSE) {
        if ($arquivo == NULL)
            $arquivo = "nao informado";
        if ($rotina == NULL)
            $rotina = "nao informada";
        if ($numerro == NULL)
            $numerro = mysqli_errno($this->conexao);
        if ($msgerro == NULL)
            $msgerro = mysqli_error($this->conexao);
        $resultado = 'Ocorreu um erro com os seguintes detalhes: <br />
		<strong>Arquivo:</strong>' . $arquivo . ' <br/>
		<strong>Rotina:</strong>' . $rotina . ' <br/>
		<strong>Codigo:</strong>' . $numerro . ' <br/>
		<strong>Mensagem:</strong>' . $msgerro;
        if ($geraexcept == FALSE) {
            echo($resultado);
        } else {
            die($resultado);
        }
    }

//trataerro
}

?>