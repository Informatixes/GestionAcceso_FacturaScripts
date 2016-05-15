<?php

/**
 * Description of nuevo_acceso
 *
 * @author cmdearcos <cmdearcos@gmail.com>
 */
require_model('accesos.php');
require_model('cliente.php');

class editar_acceso extends fs_controller {
    
    public $cliente;
    public $acceso;
    public $editar;

    public function __construct()
    {
        parent::__construct(__CLASS__, 'Editar acceso...', 'ventas', FALSE, FALSE);
        $this->editar = '0';
        if(isset($_POST['ga_editar'])){
            if($_POST['ga_editar'] == "1"){
                $this->editar = '1';
            }
        }
    }
    
    protected function private_core() {        
        if( isset($_POST['ga_guardar'])) //Editar un acceso
        {
            $nga = new accesos();
            $ega = $nga->get($_REQUEST['codacceso'], $this->user);            
            $ega->codcliente = $_POST['codcliente'];
            $ega->codagente = $_POST['codagente'];
            $ega->concepto = $_POST['ga_concepto'];
            $ega->descripcion = $_POST['ga_descripcion'];
            $ega->usuario = $_POST['ga_usuario'];
            $ega->ip = $_POST['ga_ip'];
            $ega->teamviewer = $_POST['ga_teamviewer'];
            $ega->hardware = $_POST['ga_hardware'];
            $ega->password = $_POST['ga_password'];
            $ega->splashtop = $_POST['ga_splashtop'];
            $ega->notas = $_POST['ga_notas'];
                                    
            if($ega->save())
            {
                $this->new_message('Acceso editado correctamente.');
            }
            else {
                $this->new_message('Imposible editar el acceso.');
            }
            
            
            header("location:index.php?page=gestion_acceso&codcliente=".$_POST['codcliente']);            
        }
        if(isset($_REQUEST['codacceso']))
        {
            if($_REQUEST['codacceso'] != '')
            {
                $ga = new accesos();
                $this->acceso = $ga->get($_REQUEST['codacceso'], $this->user);                          
                $cli = new cliente();
                $this->cliente = $cli->get($this->acceso->codcliente);               
            }
            
        } else {
        	header ('location:index.php?page=ventas_clientes');
        } 
    }
}
