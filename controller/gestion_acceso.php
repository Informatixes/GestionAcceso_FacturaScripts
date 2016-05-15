<?php

require_model('cliente.php');
require_model('accesos.php');

class gestion_acceso extends fs_controller
{        
    public $allow_delete;
    public $cliente;
    public $grupo;
    public $pais;
    public $resultados;
    public $serie;
    public $tarifa;
    public $tarifas;


    public function __construct()
    {
        parent::__construct(__CLASS__, 'Clientes', 'Gestion accesos', FALSE, FALSE);
    }
    
    protected function private_core() {
        $this->share_extension();        
        if( isset($_REQUEST['delete']) & isset($_REQUEST['codcliente']))
        {
            $sql = "DELETE FROM `gestion_acceso` WHERE `idgestionacceso` = ".$_REQUEST['delete'];
            //var_dump($sql);die();
            $data = $this->db->exec($sql);
             /// recargamos la página
            header('location: '.$this->url().'&codcliente='.$_REQUEST['codcliente']);
        }
        
        if( isset($_REQUEST['codcliente']) )
        {
            if($_REQUEST['codcliente'] != '')
            {
                $cli0 = new cliente();
                $this->cliente = $cli0->get($_REQUEST['codcliente']);
                $sql = "SELECT `idgestionacceso`, `codcliente`, `codagente`, `concepto`, `descripcion`, `usuario`, `ip`, `teamviewer`,"
                        ."`hardware`, AES_DECRYPT(`password`,'exunir2015') AS 'password', `splashtop`, `notas`,"
                        ."DATE_FORMAT(`fechaalta`, '%d-%m-%Y %T') AS 'fechaalta' FROM `gestion_acceso` WHERE `codcliente` = '"
                .$_REQUEST['codcliente']."' ORDER BY fechaalta ASC;";
                //var_dump($sql);die();
                $data = $this->db->select($sql);
                if($data){
                    foreach($data as $d)
                    {
                        $this->resultados[] = new accesos($d);
                    }
                }
            }
        } else {
        	header ('location:index.php?page=ventas_clientes');
        }        
    }

   private function share_extension()
   {
      $extensiones = array(
          array(
              'name' => 'gestion_acceso_cliente',
              'page_from' => __CLASS__,
              'page_to' => 'ventas_cliente',
              'type' => 'button',
              'text' => '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> &nbsp; '.ucfirst('gestión de acceso'),
              'params' => ''
          ),
          array(
              'name' => 'gestion_acceso_agente',
              'page_from' => __CLASS__,
              'page_to' => 'admin_agente',
              'type' => 'button',
              'text' => '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> &nbsp; '.ucfirst('gestión de acceso') . ' de cliente',
              'params' => ''
          ),
          array(
              'name' => 'gestion_acceso_articulo',
              'page_from' => __CLASS__,
              'page_to' => 'ventas_articulo',
              'type' => 'tab_button',
              'text' => '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> &nbsp; '.ucfirst('gestión de acceso') . ' de cliente',
              'params' => ''
          ),
      );
      foreach ($extensiones as $ext)
      {
         $fsext0 = new fs_extension($ext);
         if (!$fsext0->save())
         {
            $this->new_error_msg('Imposible guardar los datos de la extensión ' . $ext['name'] . '.');
         }
      }
   }    
}