<?php

/**
 * Description of nuevo_acceso
 *
 * @author cmdearcos <cmdearcos@gmail.com>
 */
require_model('accesos.php');
require_model('cliente.php');
require_model('grupo_clientes.php');

class nuevo_acceso extends fs_controller {
    
    public $cliente;

    public function __construct()
    {
        parent::__construct(__CLASS__, 'Nuevo acceso...', 'ventas', FALSE, FALSE, TRUE);
    }
    
    protected function private_core() {
        
        $this->cliente = new cliente();
        
        if( isset($_POST['codcliente'])) //Añadir un acceso
        {
            $nga = new accesos();
            $nga->codcliente = $_POST['codcliente'];
            $nga->cliente_s = $_POST['codcliente'];
            $nga->codagente = $_POST['codagente'];
            $nga->concepto = $_POST['ga_concepto'];
            $nga->descripcion = $_POST['ga_descripcion'];
            $nga->usuario = $_POST['ga_usuario'];
            $nga->ip = $_POST['ga_ip'];
            $nga->teamviewer = $_POST['ga_teamviewer'];
            $nga->hardware = $_POST['ga_hardware'];
            $nga->password = $_POST['ga_password'];
            $nga->splashtop = $_POST['ga_splashtop'];
            $nga->notas = $_POST['ga_notas'];
            if($nga->save())
            {
                $this->new_message('Acceso agregado correctamente.');
            }
            else {
                $this->new_message('Imposible crear el acceso.');
            }
            if( isset($_REQUEST['buscar_cliente']) )
            {
                $this->buscar_cliente();
            } 
            //header("location:index.php?page=gestion_acceso&codcliente=".$_POST['codcliente']);
            
        }
        if( isset($_REQUEST['codcliente']) )
        {
            if($_REQUEST['codcliente'] != '')
            {
                $cli0 = new cliente();
                $this->cliente_s = $_REQUEST['codcliente'];
                $this->cliente = $cli0->get($_REQUEST['codcliente']);
            }
            
        } else {
            if( isset($_REQUEST['buscar_cliente']) )
            {
                $this->buscar_cliente();
            }
//            header ('location:index.php?page=ventas_clientes');
        }
        //Si ha elegido uno y pulsa, le redirigimos a gestion_acceso
        if(isset($_POST['cliente'])){
            header("location:index.php?page=gestion_acceso&codcliente=".$_POST['cliente']);
        }
    }

   private function buscar_cliente()
   {
      /// desactivamos la plantilla HTML
      $this->template = FALSE;
      
      $json = array();
      foreach($this->cliente->search($_REQUEST['buscar_cliente']) as $cli)
      {
         $json[] = array('value' => $cli->nombre, 'data' => $cli->codcliente);
      }
      
      header('Content-Type: application/json');
      echo json_encode( array('query' => $_REQUEST['buscar_cliente'], 'suggestions' => $json) );
   }
   
   private function datos_cliente()
   {
      /// desactivamos la plantilla HTML
      $this->template = FALSE;
      
      header('Content-Type: application/json');
      echo json_encode( $this->cliente_s->get($_REQUEST['datoscliente']) );
   }
}
