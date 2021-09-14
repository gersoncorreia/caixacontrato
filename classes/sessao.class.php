<?php
require_once(dirname(__FILE__).'/autoload.php');
protegeArquivo(basename(__FILE__));
 
class sessao{
    protected $id;
    protected $nvars;
    
    public function __construct($inicia=true) {
        if($inicia=true):
            $this->start();
        endif;
    }
    
    public function start(){
        @session_start();
        $this->id = session_id();
        $this->setNvars();
    }
    
    private function setNvars(){
        $this->nvars = sizeof($_SESSION);
    }
    
    public function getNvars(){
        return $this->nvars;
    }
    
    public function setVar($var, $valor){
        $_SESSION[$var] = $valor;
        $this->setNvars();
    }
    
    public function unsetVar($var){
        unset($_SESSION[$var]);
    }
    
    public function  getVar($var){
        if(isset($_SESSION[$var])):
            return $_SESSION[$var];
        else:
            return NULL;
        endif;
    }
    
    public function destroy($inicia=false){
        session_unset();
        session_destroy();
        $this->setNvars();
        if($inicia==TRUE):
        $this->start();
        endif;
    }
    
    public function printAll(){
        foreach($_SESSION as $k => $v):
            printf("%s = %s<br />", $k, $v);
        endforeach;
    }
}
?>
