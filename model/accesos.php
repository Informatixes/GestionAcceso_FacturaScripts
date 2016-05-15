<?php
require_model('cliente.php');

/**
 * Description of gestion_acceso
 *
 * @author cmdearcos <cmdearcos@gmail.com>
 */
class accesos extends fs_model{
    
    //Columnas de la tabla
    public $idgestionacceso;
    public $codcliente;
    public $codagente;
    public $concepto;
    public $descripcion;
    public $usuario;
    public $ip;
    public $teamviewer;
    public $hardware;
    public $password;
    public $splashtop;
    public $notas;
    public $fechaalta;
    
    public function __construct($a = FALSE) {
        parent::__construct('gestion_acceso');
        if($a){
            $this->idgestionacceso = $a['idgestionacceso'];
            $this->codcliente = $a['codcliente'];
            $this->codagente = $a['codagente'];
            $this->concepto = $a['concepto'];
            $this->descripcion = $a['descripcion'];
            $this->usuario = $a['usuario'];
            $this->ip = $a['ip'];
            $this->teamviewer = $a['teamviewer'];
            $this->hardware = $a['hardware'];
            $this->password = $a['password'];
            $this->splashtop = $a['splashtop'];
            $this->notas = $a['notas'];
            $this->fechaalta = $a['fechaalta'];            
        }
        else{
            $this->idgestionacceso = NULL;
            $this->codcliente = NULL;
            $this->codagente = NULL;
            $this->concepto = NULL;
            $this->descripcion = NULL;
            $this->usuario = NULL;
            $this->ip = NULL;
            $this->teamviewer = NULL;
            $this->hardware = NULL;
            $this->password = NULL;
            $this->splashtop = NULL;
            $this->notas = NULL;
            $this->fechaalta = NULL;            
        }
    }
    
    //funciones que se deben definir al heredar de fs_model
    
    protected function install() {
        ;
    }
    
    public function exists() {   
        if( is_null($this->idgestionacceso) )
        {
            return FALSE;
        }
        else
            return $this->db->select("SELECT * FROM ".$this->table_name." WHERE idgestionacceso = ".$this->var2str($this->idgestionacceso).";");   
    }
    
    public function save() {
        if( $this->exists() ){
            $sql = "UPDATE ".$this->table_name." SET "
                ."codcliente = ".$this->var2str($this->codcliente)            
                .", codagente = ".$this->var2str($this->codagente)            
                .", concepto = ".$this->var2str($this->concepto) 
                .", descripcion = ".$this->var2str($this->descripcion)
                .", usuario = ".$this->var2str($this->usuario)
                .", ip = ".$this->var2str($this->ip)    
                .", teamviewer = ".$this->var2str($this->teamviewer)            
                .", hardware = ".$this->var2str($this->hardware)
                .", password = AES_ENCRYPT(".$this->var2str($this->password).", 'exunir2015')"
                .", splashtop = ".$this->var2str($this->splashtop)
                .", notas = ".$this->var2str($this->notas)            
                ."  WHERE idgestionacceso = ".$this->var2str($this->idgestionacceso).";";            
        }
        else{
            //idgestionacceso`, `codcliente`, `codagente`, `concepto`, `descripcion`, `usuario`, `ip`, `teamviewer`,"
                        //."`hardware`, AES_DECRYPT(`password`,'exunir2015') AS 'password', `splashtop`, `notas`,
            $sql = "INSERT INTO ".$this->table_name." (`idgestionacceso`, `codcliente`, `codagente`, 
                `concepto`, `descripcion`, `usuario`, `ip`, `teamviewer`, `hardware`, `password`, `splashtop`, `notas`, 
                `fechaalta`) VALUES (NULL"
                .",".$this->var2str($this->codcliente)
                .",".$this->var2str($this->codagente)
                .",".$this->var2str($this->concepto) 
                .",".$this->var2str($this->descripcion)
                .",".$this->var2str($this->usuario)
                .",".$this->var2str($this->ip)    
                .",".$this->var2str($this->teamviewer)            
                .",".$this->var2str($this->hardware)
                .", AES_ENCRYPT(".$this->var2str($this->password).", 'exunir2015')"
                .",".$this->var2str($this->splashtop)
                .",".$this->var2str($this->notas)
                .", now()"
                .");";
        }
        
        return $this->db->exec($sql);

        //var_dump($sql);die();
        
    }
    
    public function delete() {
        ;
    }
    
    public function test(){
        
    }
    
    public function url(){
        if( is_null($this->codcliente) )
        {
            return "#";
        }
        else
        {
            return "index.php?page=editar_acceso&codacceso=".$this->idgestionacceso;
        }
    }
    
    /**
    * Devuelve un acceso a partir del idgestionacceso
    * @param type $cod
    * @return \cliente|boolean
    */
   public function get($cod, $user =  FALSE)
   {
    /*   if($user == FALSE){
           $sql = "SELECT `idgestionacceso`,`codcliente`,`codagente`, "
                   ."`concepto`, `descripcion`, `usuario`, `ip`, `teamviewer`, `hardware`, NULL AS 'password', `splashtop`, "
                   ."`notas`, DATE_FORMAT(`fechaalta`, '%d-%m-%Y %T') AS 'fechaalta' "
                   . "FROM ".$this->table_name." WHERE idgestionacceso = ".$this->var2str($cod).";";                                  
       }
       else{*/
           //
        //   if($user->admin){
               $sql = "SELECT `idgestionacceso`,`codcliente`,`codagente`, "
                       ."`concepto`, `descripcion`, `usuario`, `ip`, `teamviewer`, `hardware`, AES_DECRYPT(`password`,'exunir2015') AS 'password', `splashtop`, "
                       ."`notas`, DATE_FORMAT(`fechaalta`, '%d-%m-%Y %T') AS 'fechaalta' "
                       . "FROM ".$this->table_name." WHERE idgestionacceso = ".$this->var2str($cod).";";
          /* }
           else{
               $codagente = $this->db->select("SELECT codagente FROM ".$this->table_name." WHERE idgestionacceso = ".$this->var2str($cod).";");
               if($codagente[0]['codagente'] == $user->codagente){
                    $sql = "SELECT `idgestionacceso`,`codcliente`,`codagente`, "
                            ."`concepto`, `descripcion`, `usuario`, `ip`, `teamviewer`, `hardware`, AES_DECRYPT(`password`,'exunir2015') AS 'password', `splashtop`, "
                            ."`notas`, DATE_FORMAT(`fechaalta`, '%d-%m-%Y %T') AS 'fechaalta' "
                            . "FROM ".$this->table_name." WHERE idgestionacceso = ".$this->var2str($cod).";";
               }
               else{
                    $sql = "SELECT `idgestionacceso`,`codcliente`,`codagente`, "
                            ."`concepto`, `descripcion`, `usuario`, `ip`, `teamviewer`, `hardware`, NULL AS 'password', `splashtop`, "
                            ."`notas`, DATE_FORMAT(`fechaalta`, '%d-%m-%Y %T') AS 'fechaalta' "
                            . "FROM ".$this->table_name." WHERE idgestionacceso = ".$this->var2str($cod).";";                                  
               }
           }
            */          
           //$acc = $this->db->select("SELECT * FROM ".$this->table_name." WHERE idgestionacceso = ".$this->var2str($cod).";");
           
           
      //  }
      
        $acc = $this->db->select($sql);
        if($acc)
        {
            return new accesos($acc[0]);
        }
        else
            return FALSE;
   }



    //La funcion test no es necesaria.
    
    
}
